<?php
	namespace vps\uploader\batch;

	use vps\uploader\models\File;
	use Yii;
	use yii\helpers\Url;

	/**
	 * @property-read array $errors
	 * @property-read array $listItems
	 * @property-read array $oks
	 */
	class BatchResult extends BatchResultBase
	{
		/**
		 * Gets associative array of error messages where keys are file GUIDs and values are links to file view.
		 * @return array
		 */
		public function getErrors ()
		{
			if (count($this->_errors) > 0 and empty( current($this->_errors) ))
				$this->_errors = $this->linksToFiles('error');

			return $this->_errors;
		}

		/**
		 * Gets associative array of ok messages where keys are file GUIDs and values are links to file view.
		 * @return array
		 */
		public function getOks ()
		{
			if (count($this->_oks) > 0 and empty( current($this->_oks) ))
				$this->_oks = $this->linksToFiles('ok');

			return $this->_oks;
		}

		/**
		 * Generate links to files to use them as messages.
		 * @param string $type Message type, ok or error.
		 * @return array
		 */
		private function linksToFiles ($type = 'ok')
		{
			$array = ( $type == 'ok' ) ? $this->_oks : $this->_errors;

			$files = File::find()->where([ 'guid' => array_keys($array) ])->all();
			foreach ($files as $file)
				$array[ $file->guid ] = Url::to([ 'file/' . $file->guid ]);

			return $array;
		}
	}