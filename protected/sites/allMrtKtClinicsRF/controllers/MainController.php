<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.01.2017
 * Time: 18:16
 */
class MainController extends Controller {

    public $layout = 'plain';

    public function actionIndex() {
        $this -> render('//index');
    }
    public function init() {
        CallTrackerModule::useTracker();
        /*$chosen = false;
        if ($_GET['mobile']) {
            $theme = 'mobile_';
        }
        if ($_GET['fullscreen']) {
            $chosen = true;
        }
        if ((!$theme)&&(!$chosen)) {
            $theme = Yii::app()->request->cookies ['theme'] -> value;
        }
        if ((!$theme)&&(!$chosen)) {
            $res = browserInfoHolder::getInstance();
            if ($res) {
                if ($res->isMobile() === true) {
                    $theme = CallTrackerModule::getExperiment() -> getParams()['theme'];
                    //$theme = 'mobile';

                } else {
                    $theme = null;
                    $chosen = true;
                }
            } else {
                $theme = null;
                $chosen = true;
            }
        }
        Yii::app() -> setTheme($theme);
        //Сохранили результат выбора темы
        Yii::app() -> request -> cookies ['theme'] = new CHttpCookie('theme',$theme);*/
    }
}