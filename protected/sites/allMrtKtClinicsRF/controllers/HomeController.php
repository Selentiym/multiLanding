<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:00
 */
class HomeController extends CController {
    public $defaultAction = 'clinics';
    public $layout = 'home';
    public function actions() {
        return [
            'clinics'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/clinics/list',
                'guest' => true,
            ),
        ];
    }
}