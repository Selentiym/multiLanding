<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:00
 */
class HomeController extends HomeControllerCatalogCommon {
    public function actions() {
        return SiteDispatcher::mergeArray(parent::actions(),[
            'tomography'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/article/tomography',
                'guest' => true,
            )
//            ,
//            'service'=>array(
//                'class'=>'application.controllers.actions.FileViewAction',
//                'view' => '/clinics/serviceView',
//                'partial' => false,
//                'guest' => true,
//            ),
        ]);
    }
    public function actionService(){
        //$this -> layout = 'home';
        $this -> render('/clinics/serviceView');
    }
    public function actionCheck(){
        //$this -> layout = 'home';
        $this -> render('/clinics/serviceView');
    }
}