<?php
	namespace vps\uploader\controllers;

	use vps\tools\helpers\StringHelper;
	use Yii;
	use vps\tools\net\Flow;
	use vps\uploader\models\File;
	use yii\data\ActiveDataProvider;

	class FileController extends BaseController
	{
		public function actionAdd ()
		{
			$this->title = Yii::t('vps-uploader', 'Add files');

			$this->data('chunksize', $this->module->chunksize);
		}

		public function actionBatch ()
		{
		}

		/**
		 * Generate unique GUID.
		 * @return string
		 */
		public function actionGuid ()
		{
			$guid = StringHelper::random();

			while (File::find()->where([ 'guid' => $guid ])->count() > 0)
				$guid = StringHelper::random();

			return $guid;
		}

		public function actionIndex ()
		{
			$this->title = Yii::t('vps-uploader', 'File list');

			$query = File::find();

			$provider = new ActiveDataProvider([
				'query'      => $query,
				'sort'       => [
					'defaultOrder' => [
						'dt' => SORT_DESC
					]
				],
				'pagination' => [
					'pageSize'       => 50,
					'forcePageParam' => false,
					'pageSizeParam'  => false,
					'urlManager'     => new \yii\web\UrlManager([
						'enablePrettyUrl' => true,
						'showScriptName'  => false,
						'rules'           => [
							'uploader/file/<page>' => 'uploader/file/index'
						]
					])
				]
			]);

			// Uploaded files.
			$list = Yii::$app->request->get('list');
			if ($list !== null)
			{
				$this->data('uploaded', File::find()->where([ 'guid' => explode(',', $list) ])->orderBy([ 'dt' => SORT_DESC ])->all());
			}

			// Common files list.
			$this->data('files', $provider->models);
			$this->data('pagination', $provider->pagination);
		}

		public function actionView ()
		{
		}

		public function actionUpload ()
		{
			$datapath = $this->module->path;

			$flow = new Flow;
			$flow->tmpDir = $datapath . '/tmp';
			$flow->targetDir = $datapath . '/files';

			if ($flow->isUploading)
			{
				$guid = $flow->getParam('identifier');

				if ($flow->isNew)
				{
					$filename = $flow->getParam('filename');

					$file = new File;
					$file->guid = $guid;
					$file->name = pathinfo($filename, PATHINFO_FILENAME);
					$file->extension = pathinfo($filename, PATHINFO_EXTENSION);
					$file->save();
				}
				else
				{
					$file = File::findOne([ 'guid' => $guid ]);
				}

				$flow->uploadChunk();

				if ($flow->isComplete)
				{
					$targetDir = $datapath . '/files/' . $file->guid[ 0 ] . '/' . $file->guid[ 1 ];

					$flow->targetDir = $targetDir;
					$flow->save($file->guid);

					if (file_exists($targetDir . '/' . $flow->savedFilename))
					{
						$file->status = File::S_OK;
						$file->path = $file->guid[ 0 ] . '/' . $file->guid[ 1 ] . '/' . $flow->savedFilename;
						$file->size = (string)filesize($targetDir . '/' . $flow->savedFilename);
						$file->save();
					}
					else
					{
						$file->status = File::S_ERROR;
						$file->message = Yii::t('vps-uploader', 'Error saving file to path {path}.', [ 'path' => $file->guid[ 0 ] . '/' . $file->guid[ 1 ] . '/' . $flow->savedFilename ]);
						$file->save();
					}
				}
				elseif ($file->status != File::S_UPLOADING)
				{
					$file->status = File::S_UPLOADING;
					$file->save();
				}
				// @TODO: output errors
			}
			else
				$flow->testChunk();

			Yii::$app->end();
		}
	}