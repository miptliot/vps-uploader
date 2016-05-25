<?php
	namespace vps\iploader;

	class Module extends \yii\base\Module
	{
		/**
		 * @var string
		 * Base path to store files. Must be writable.
		 */
		public $basepath;

		/**
		 * @var int
		 * File chunk size in bytes to upload large files. Default is 1048576 (1M).
		 */
		public $chunksize = 1048576;

		/**
		 * @var null|string[]
		 * Allowed extensions to load. If _null_ then any extension is allowed.
		 */
		public $extensions = null;

		/**
		 * @var null|string
		 * Maximum file size to upload. Default is _null_ (unlimited). If this value more than _upload_max_filesize_ or
		 * _post_max_size_, then minimum of these values will be used. Format is like 128M.
		 */
		public $maxsize = null;
	}