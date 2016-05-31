<?php
	namespace vps\uploader\controllers;

	class FileController extends BaseController
	{
		public function actionAdd ()
		{
			$this->data('chunksize', $this->module->chunksize);
		}

		public function actionIndex ()
		{
		}

		public function actionView ()
		{
		}
	}