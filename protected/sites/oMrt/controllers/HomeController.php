<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:00
 */
class HomeController extends CController {
    public $defaultAction = 'articles';
    public $layout = 'home';

    public function beforeAction(){
        $path = Yii::getPathOfAlias('application.sites.oMrt.components.Helpers') . '.php';
        require_once($path);
        return true;
    }

    public function actions() {
        return [
            'articles'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/article/list',
                'guest' => true,
            ),
            'articleView'=>array(
                'class'=>'application.controllers.actions.ModelViewAction',
                'view' => '/article/view',
                'modelClass' => function(){
                    $mod = Yii::app() -> getModule('clinics');
                    return get_class($mod->getClassModel('Article'));
                },
                'scenario' => 'view',
                'layout'=>'home',
                'guest' => true
            ),
            'articlePreview'=>array(
                'class'=>'application.controllers.actions.ModelViewAction',
                'view' => '/article/view',
                'modelClass' => function(){
                    $mod = Yii::app() -> getModule('clinics');
                    return get_class($mod->getClassModel('Article'));
                },
                'scenario' => 'preview',
                'layout'=>'home',
            ),
            'clinics'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/clinics/list',
                'guest' => true,
            ),
            'modelView' => [
                'class'=>'application.controllers.actions.ModelViewAction',
                'view' => function($model){
                    return '/'.get_class($model).'/view';
                },
                'modelClass' => $_GET['modelName'],
                'guest' => true,
                'scenario' => 'view',
                'layout'=>'home'
            ],
            'landing'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => function(){
                    return '/landing/index'.$_GET['area'];
                },
                'guest' => true,
            ),
        ];
    }

    /**
     * So that the search params were preserved
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @param bool $clear
     * @param bool $paramsOnly
     * @return string|void
     */
    public function createUrl($route,$params=[],$ampersand = '&',$clear = false, $paramsOnly = false){
        if (!$paramsOnly) {
            $dops = $_GET;
        } else {
            $dops = [];
        }
        static $allowed;

        if (!$clear) {
            if (!$allowed) {
                $allowed = CHtml::giveAttributeArray(Triggers::model()->findAll(), 'verbiage');
                $allowed[] = 'metro';
                $allowed[] = 'research';
            }
            //Оставляем только поисковые параметры!
            $dops = array_filter($dops,function($key) use($allowed) {
                return in_array($key,$allowed);
            }, ARRAY_FILTER_USE_KEY);
            $params = SiteDispatcher::mergeArray($dops,$params);
        }
        array_filter($params);
        return parent::createUrl($route,$params,$ampersand);
    }

    /**
     * generates pretty url for a form
     */
    public function actionCreateFormUrl() {
        if (Yii::app() -> request -> isAjaxRequest) {
            $data = $_POST;
//            $m = $_GET['method'];
//            if ($m == 'post') {
//                $data = $_POST;
//            } else {
//                $data = $_GET;
//            }
            $params = [];
            parse_str($data['data'], $p);
            $p = array_filter($p);
            if (!empty($p)) {
                $params = $p;
            }
            echo $this->createUrl($data['action'], $params);
        }
    }
}