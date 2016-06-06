<?php
	namespace vps\uploader;

	use vps\tools\helpers\HumanHelper;
	use Yii;
	use yii\base\BootstrapInterface;
	use yii\base\InvalidConfigException;

	class Module extends \yii\base\Module implements BootstrapInterface
	{
		/**
		 * @var int
		 * File chunk size in bytes to upload large files. Default is 1048576 (1M). This value must be less than
		 * $maxsize.
		 */
		public $chunksize = 1048576;

		/**
		 * @var null|string[]
		 * Allowed extensions to load. If _null_ then any extension is allowed.
		 */
		public $extensions = null;

		/**
		 * @var null|string
		 * Maximum file size to upload. Default is _null_ (unlimited). Format is like 128M.
		 */
		public $maxsize = null;

		/**
		 * @var string
		 * Base path to store files. Must be writable.
		 */
		public $path;

		/**
		 * @var string
		 * Relative URL to build link for file. The full URL look like http(s)://<host><baseurl>/<relativepath>
		 */
		public $url = '/uploader/files';

		/**
		 * @inheritdoc
		 */
		public function bootstrap ($app)
		{
			Yii::setAlias('vps-uploader', __DIR__);

			$app->getUrlManager()->addRules(
				[
					'<_m:uploader>/?'                                     => '<_m>/uploader/index',
					'<_m:uploader>/file/?'                                => '<_m>/file/index',
					'<_m:uploader>/file/<action:(index|upload|add|guid)>' => '<_m>/file/<action>',
					'<_m:uploader>/file/<page:[0-9]+>/?'                  => '<_m>/file/index',
					'<_m:uploader>/file/<guid:[a-zA-Z0-9]{5,}>/?'         => '<_m>/file/view',
				]
			);

			if (!isset( $app->i18n->translations[ 'vps/uploader' ] ) && !isset( $app->i18n->translations[ 'vps/*' ] ))
			{
				$app->i18n->translations[ 'vps-uploader' ] = [
					'class'            => 'yii\i18n\PhpMessageSource',
					'basePath'         => '@vps-uploader/messages',
					'forceTranslation' => true,
					'fileMap'          => [
						'vps-uploader' => 'uploader.php',
					]
				];
			}
		}

		public function init ()
		{
			parent::init();
			$this->checkParameters();
		}

		private function checkParameters ()
		{
			// Check path.
			if (!is_dir($this->path))
				throw new InvalidConfigException($this->path . ' is not a directory.');

			if (!is_writable($this->path))
				throw new InvalidConfigException($this->path . ' is not writable.');

			// Check chunksize.
			$bytes = HumanHelper::maxBytesUpload();
			if ($this->chunksize >= $bytes)
				throw new InvalidConfigException('Chunksize value must be less than ' . $bytes . 'B. Current value is ' . $this->chunksize . '.');
		}
	}