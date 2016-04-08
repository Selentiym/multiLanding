<?php

class SiteController extends Controller
{
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
				'view' => '//subs/index',
				'scenario' => Rule::USE_RULE,
				'external' => $_GET
			),
			'post' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs/post',
				'partial' => true
			)
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

}