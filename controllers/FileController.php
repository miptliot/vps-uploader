<?php
	namespace vps\uploader\controllers;

	class FileController extends BaseController
	{
		public function actionAdd ()
		{
			$this->data('chunksize', $this->module->chunksize);
			$this->data('simultaneous', $this->module->simultaneous);
		}

		public function actionIndex ()
		{
		}

		public function actionView ()
		{
		}
	}