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
				$this->setViewPath('@uploader/views');
				$this->_tpl = $this->viewPath . '/' . $this->id . '/' . $this->action->id;

				return true;
			}

			return false;
		}
	}