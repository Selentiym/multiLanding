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
            ]
        ];
    }

    /**
     * So that the search params were preserved
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @param bool $clear
     * @return string|void
     */
    public function createUrl($route,$params=[],$ampersand = '&',$clear = false){
        $dops = $_GET;
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
        } else {
            $a=1;
        }
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
            if (!empty($p)) {
                $params = $p;
            }
            echo $this->createUrl($data['action'], $params);
        }
    }
}