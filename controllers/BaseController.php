<?php
	namespace vps\uploader\controllers;

	class BaseController extends \vps\tools\controllers\WebController
	{
		/**
		 * @inheritdoc
		 */
		public function beforeAction ($action)
		{
			if (parent::beforeAction($action))
			{
				$this->setViewPath('@vps-uploader/views');
				$this->_tpl = $this->viewPath . '/index';
				$this->data('pageTpl', $this->viewPath . '/' . $this->id . '/' . $this->action->id . '.tpl');

				return true;
			}

			return false;
		}
	}