<?php
	class ModelViewAction extends CAction
	{
		/**
		 * @var string model class for action
		 */
		public $modelClass;
		/**
		 * @var mixed external - data from the controller
		 */
		public $external = false;
		/**
		 * @var string|callable view for render
		 */
		public $view;
		/**
		 * @var string scenario - scenario that is to be assigned to the model
		 */
		public $scenario = false;
		/**
		 * @var boolean partial - whether to user render partial.
		 */
		public $partial = false;
		/**
		 * @var boolean - allow everyone including guests visit this page
		 */
		public $everyone = true;
		
		/**
		 * @param $arg string model argument to be taken into customFind
		 * @throws CHttpException
		 */
		public function run($arg = false)
		{
			if ((!Yii::app() -> user -> isGuest)||($this -> everyone)) {
				$model = CActiveRecord::model($this->modelClass)->customFind($arg, $this -> external, $this -> scenario);
				//echo $arg."<br/>";
				//return;
				//if(Yii::app()->user->checkAccess('createPost')) {
					if(!$model)
						throw new CHttpException(404, "{$this->modelClass} not found");
					//echo $this -> view;
					//var_dump($model);
					if (is_callable($this -> view)) {
						$this -> view = call_user_func($this -> view,$model);
					}
					$this->controller->layout = '//layouts/site';
					if ($this -> partial) {
						$this->controller->renderPartial($this->view, array('model' => $model, 'get' => $_GET), false, true);
					} else {
						$this->controller->render($this->view, array('model' => $model, 'get' => $_GET));
					}
				//}
			} else {
				$this -> controller -> redirect(Yii::app() -> baseUrl.'/login');
			}
		}
	}
?>