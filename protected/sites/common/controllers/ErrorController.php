<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.01.2017
 * Time: 16:21
 */
class ErrorController extends Controller {
    public $defaultAction = 'index';
    /**
     * This is the action to handle external exceptions.
     */
    public function actionIndex()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', $error);
        }
    }
}