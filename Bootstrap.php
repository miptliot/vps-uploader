<?php

	namespace vps\uploader;

	class Bootstrap implements \yii\base\BootstrapInterface
	{
		/**
		 * @inheritdoc
		 */
		public function bootstrap ($app)
		{
			// Add module URL rules.
			$app->getUrlManager()->addRules(
				[
					'<_m:uploader>/file'                        => '<_m>/file/index',
					'<_m:uploader>/file/index'                  => '<_m>/file/index',
					'<_m:uploader>/file/<page:[0-9]+>'          => '<_m>/file/index',
					'<_m:uploader>/file/<guid:[a-zA-Z0-9]{5,}>' => '<_m>/file/view',
					'<_m:uploader>/file/add'                    => '<_m>/file/add',
				]
			);

			// Add module I18N category.
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
