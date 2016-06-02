<?php
	namespace vps\uploader\controllers;

	use Yii;

	class UploaderController extends BaseController
	{
		public function actionIndex ()
		{
			$this->title = Yii::t('vps-uploader', 'VPS uploader');
		}
	}