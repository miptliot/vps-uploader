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

			$flow->process();

			if ($flow->isComplete)
			{
				$filename = $flow->getParam('filename');

				$file = new File;
				$file->guid = StringHelper::random();
				$file->name = pathinfo($filename, PATHINFO_FILENAME);
				$file->extension = pathinfo($filename, PATHINFO_EXTENSION);
				$file->save();

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

				echo $file->guid;
			}

			Yii::$app->end();
		}
	}