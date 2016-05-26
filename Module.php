<?php
	namespace vps\uploader;

	use Yii;
	use yii\base\BootstrapInterface;

	class Module extends \yii\base\Module implements BootstrapInterface
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

		/**
		 * @inheritdoc
		 */
		public function bootstrap ($app)
		{
			Yii::setAlias('uploader', __DIR__);

			$app->getUrlManager()->addRules(
				[
					'<_m:uploader>'                             => '<_m>/uploader/index',
					'<_m:uploader>/file'                        => '<_m>/file/index',
					'<_m:uploader>/file/index'                  => '<_m>/file/index',
					'<_m:uploader>/file/<page:[0-9]+>'          => '<_m>/file/index',
					'<_m:uploader>/file/<guid:[a-zA-Z0-9]{5,}>' => '<_m>/file/view',
					'<_m:uploader>/file/add'                    => '<_m>/file/add',
				]
			);

			if (!isset( $app->i18n->translations[ 'vps/uploader' ] ) && !isset( $app->i18n->translations[ 'vps/*' ] ))
			{
				$app->i18n->translations[ 'vps/uploader' ] = [
					'class'            => 'yii\i18n\PhpMessageSource',
					'basePath'         => '@vps/uploader/messages',
					'forceTranslation' => true,
					'fileMap'          => [
						'vps/uploader' => 'uploader.php',
					]
				];
			}
		}
	}