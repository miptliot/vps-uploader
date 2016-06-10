<?php
	namespace vps\uploader\batch;

	use yii\base\Object;
	use vps\tools\helpers\Html;

	abstract class BatchResultBase extends Object
	{
		/**
		 * Associative array of error messages where keys are file GUIDs and values are links to file view.
		 * @var array
		 */
		protected $_errors = [ ];

		/**
		 * Associative array of ok messages where keys are file GUIDs and values are links to file view.
		 * @var array
		 */
		protected $_oks = [ ];

		/**
		 * Creates list items (li tag) for display in (un)ordered list.
		 * @param string $type Messages type to use as base for creating list.
		 * @return mixed
		 */
		public function getListItems ($type = 'ok')
		{
			$array = ( $type == 'ok' ) ? $this->oks : $this->errors;

			$list = [ ];
			foreach ($array as $key => $value)
				$list[] = Html::a($key, $value);

			return $list;
		}

		/**
		 * Stores guid which was not correctly processed.
		 * @param string $guid
		 */
		public function error ($guid)
		{
			$this->_errors[ $guid ] = '';
		}

		/**
		 * Stores guid which was correctly processed.
		 * @param string $guid
		 */
		public function ok ($guid)
		{
			$this->_oks[ $guid ] = '';
		}

		abstract public function getErrors ();

		abstract public function getOks ();
	}