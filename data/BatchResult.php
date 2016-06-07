<?php
	namespace vps\uploader\data;

	use yii\base\Object;

	class BatchResult extends Object
	{
		const T_FILE = 'file';
		const T_LOG  = 'log';

		private $_errorList = [ ];
		private $_okList    = [ ];

		public function error ($guid, $type = self::T_FILE)
		{
		}
	}