<?php
	namespace vps\uploader\batch;

	use vps\tools\helpers\Html;
	use vps\uploader\models\File;
	use Yii;
	use yii\base\Object;
	use yii\helpers\Url;

	/**
	 * @property-read array $errors
	 * @property-read array $listItems
	 * @property-read array $oks
	 */
	class BatchResult extends Object
	{
		/**
		 * Associative array of error messages where keys are file GUIDs and values are links to file view.
		 * @var array
		 */
		private $_errors = [ ];

		/**
		 * Associative array of ok messages where keys are file GUIDs and values are links to file view.
		 * @var array
		 */
		private $_oks = [ ];

		/**
		 * Gets associative array of error messages where keys are file GUIDs and values are links to file view.
		 * @return array
		 */
		public function getErrors ()
		{
			if (count($this->_errors) > 0 and empty( current($this->_errors) ))
			{
				$files = File::find()->where([ 'guid' => array_keys($this->_errors) ])->all();
				foreach ($files as $file)
					$this->_errors[ $file->guid ] = Url::to([ 'file/' . $file->guid ]);
			}

			return $this->_errors;
		}

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
		 * Gets associative array of ok messages where keys are file GUIDs and values are links to file view.
		 * @return array
		 */
		public function getOks ()
		{
			if (count($this->_oks) > 0 and empty( current($this->_oks) ))
			{
				$files = File::find()->where([ 'guid' => array_keys($this->_oks) ])->all();
				foreach ($files as $file)
					$this->_oks[ $file->guid ] = Url::to([ 'file/' . $file->guid ]);
			}

			return $this->_oks;
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
	}