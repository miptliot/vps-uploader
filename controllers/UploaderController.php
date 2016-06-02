<?php
	namespace vps\uploader\controllers;

	use Yii;
	use vps\uploader\models\File;

	class UploaderController extends BaseController
	{
		public function actionIndex ()
		{
			$this->title = Yii::t('vps-uploader', 'VPS uploader');

			$this->data('last', File::find()->orderBy([ 'dt' => SORT_DESC ])->all());
		}
	}