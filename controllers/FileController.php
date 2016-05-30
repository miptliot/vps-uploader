<?php
	namespace vps\uploader\controllers;

	class FileController extends BaseController
	{
		public function actionAdd ()
		{
			$this->data('simultaneous', $this->module->simultaneous);
		}

		public function actionIndex ()
		{
		}

		public function actionView ()
		{
		}
	}