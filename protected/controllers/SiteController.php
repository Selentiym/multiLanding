<?php

class SiteController extends Controller
{
	const FULL_CYCLE_MINS = 10;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			/*'index'=>array(
				'class'=>'application.controllers.actions.FileViewAction',
				'view' => '//subs/index'
			),*/
			'index'=>array(
				'class'=>'application.controllers.site.ModelViewAction',
				'modelClass' => 'Rule',
				'view' => function($rule){
					/**
					 * @type CWebApplication $app
					 */
					$app = Yii::app();
					$folder = $app->session->get('folder');
					if (!$folder) {
						$time = time();
						//Каждые self::FULL_CYCLE_MINS/2 минут меняем представление.
						if ($time % (60 * self::FULL_CYCLE_MINS) < 30 * self::FULL_CYCLE_MINS) {
							$folder = '//subs/';
						} else {
							$folder = '//subs_newDesign/';
						}
					}
					//пересохраняем сессию
					//@todo убрать!
					//$folder = '//subs_newDesign/';
					//$folder = '//subs/';
					$app->session->add('folder', $folder);
					return $folder . 'index';
				},
				'scenario' => Rule::USE_RULE,
				'external' => $_GET
			),
			'post' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs/post',
				'partial' => true
			),
			'post_newDesign' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs_newDesign/post',
				'partial' => true
			),

		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	/**
	 *
	 */
	public function actionTransfer(){
		$count = 0;
		foreach (Rule::model() -> findAll() as $rule) {
			if ($rule -> price) {
				$rule -> prices_input = array($rule -> price -> id);
			}
			if ($rule -> save()){
				$count ++;
			} else {
				var_dump($rule -> getErrors());
			}
		}
		echo $count;
	}
}