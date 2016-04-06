<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2016
 * Time: 18:53
 */
/**
 * Login controller
 */
class LoginController extends CController
{
    public $defaultAction = 'index';
    public function actionIndex() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginForm') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app() -> baseUrl);
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->baseUrl);
        }
        // display the login form
        $this->renderPartial('//login/loginform', array('model' => $model));
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
?>