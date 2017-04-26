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
        ]);
    }
}