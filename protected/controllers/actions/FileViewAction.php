<?php
	class FileViewAction extends CAction
	{
		
		/**
		 * @var callable access function to be called to access page
		 */
		public $access = true;
		/**
		 * @var string view for render
		 */
		public $view;
		/**
		 * @var boolean - allow everyone including guests visit this page
		 */
		public $everyone = true;
		/**
		 * @var boolean - whether the view shall e partially rendered of fully.
		 */
		public $partial = false;
		/**
		 * @param $arg string model argument to be taken into customFind
		 * @throws CHttpException
		 */
		public function run()
		{
			if ((!Yii::app() -> user -> isGuest)||($this -> everyone)) {
				if (is_callable($this -> access)) {
					$name = $this -> access;
					$this -> access = $name ();
				}
				if ($this -> access) {
					if (!$this -> partial) {
						$this->controller->render($this->view, array('get' => $_GET));
					} else {
						$this->controller->renderPartial($this->view, array('get' => $_GET));
					}
				} else {
					$this -> controller -> render('//accessDenied');
				}
				//}
			} else {
				$this -> controller -> redirect(Yii::app() -> baseUrl.'/');
			}
		}
	}
?>