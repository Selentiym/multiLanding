<?php
class SiteController extends CController {
    public $defaultAction = 'index';

    public function actions() {
        return [
//            'index'=>array(
//                'class'=>'application.sites.common.controllers.site.ModelViewAction',
//                'modelClass' => 'CommonRule',
//                'view' => '',
//                'scenario' => '',
//                'external' => $_GET
//            ),
        ];
    }

    public function actionIndex() {
        echo "index";
    }
}