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
            ),
            'moreNewsForService' => array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/news/feedback',
                'guest' => true,
                'partial' => true
            ),
//            ,
//            'service'=>array(
//                'class'=>'application.controllers.actions.FileViewAction',
//                'view' => '/clinics/serviceView',
//                'partial' => false,
//                'guest' => true,
//            ),
        ]);
    }
    public function actionCheck(){
//        $medem = clinics::model() -> findByAttributes(['verbiage' => 'medem']);
//        $medem -> savePrices();
    }
}