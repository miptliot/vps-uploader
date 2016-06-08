<?php
	namespace vps\uploader\batch;

	use vps\uploader\models\File;
	use Yii;
	use yii\base\Object;

	class BatchResult extends Object
	{
		/**
		 * @var string[] List of error GUIDs.
		 */
		private $_errors = [ ];

		/**
		 * @var string[] List of OK GUIDs.
		 */
		private $_oks = [ ];

		/**
		 * @var [[vps\uploader\Module]] Just internal variable to store module.
		 */
		private $_module;

		public function getErrors ()
		{
		}

		public function init ()
		{
			parent::init();

			$this->_module = Yii::$app->controller->module;
		}

		public function error ($guid)
		{
			$this->_errors[] = $guid;
		}

		public function ok ($guid)
		{
			$this->_oks[] = $guid;
		}
	}