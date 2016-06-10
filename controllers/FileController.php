<?php
	namespace vps\uploader\controllers;

	use vps\tools\helpers\Html;
	use vps\tools\helpers\StringHelper;
	use vps\uploader\batch\BatchResultBase;
	use Yii;
	use vps\tools\net\Flow;
	use vps\uploader\models\File;
	use yii\data\ActiveDataProvider;
	use yii\base\InvalidConfigException;

	class FileController extends BaseController
	{
		public function actionAdd ()
		{
			$this->title = Yii::t('vps-uploader', 'Add files');

			$this->data('chunksize', $this->module->chunksize);
		}

		public function actionBatch ()
		{
			$path = Yii::$app->request->get('path');
			$action = $this->module->findBatchAction($path);

			if ($action == null)
				throw new InvalidConfigException('Cannot find action with path ' . $path);

			list( $class, $method ) = $action[ 'method' ];
			if (!method_exists($class, $method))
				throw new InvalidConfigException('Cannot find method: ' . implode('::', $action[ 'method' ]));

			$result = call_user_func($action[ 'method' ], StringHelper::explode(Yii::$app->request->get('guids'), ','));

			if ($result instanceof BatchResultBase)
			{
				if (count($result->oks) > 0)
				{
					$ok = Yii::t('vps-uploader', 'Following files were processed.');
					$ok .= Html::ul($result->getListItems('ok'), [ 'encode' => false ]);
					Yii::$app->notification->messageToSession($ok);
				}

				if (count($result->errors) > 0)
				{
					$error = Yii::t('vps-uploader', 'Following files were NOT processed.');
					$error .= Html::ul($result->getListItems('error'), [ 'encode' => false ]);
					Yii::$app->notification->errorToSession($error);
				}
			}

			$this->redirect(Yii::$app->request->referrer);
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

		public function actionView ($guid)
		{
			$this->title = Yii::t('vps-uploader', 'File view');

			$file = File::findOne([ 'guid' => $guid ]);
			if ($file !== null)
				$this->data('file', $file);
		}

		public function actionUpload ()
		{
			$flow = new Flow;
			$flow->tmpDir = $this->module->tmppath;
			$flow->targetDir = $this->module->filepath;

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
					$targetDir = $this->module->filepath . '/' . $file->guid[ 0 ] . '/' . $file->guid[ 1 ];

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