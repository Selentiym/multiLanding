<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.01.2017
 * Time: 18:16
 */
class MainController extends Controller {
    public function actionIndex() {
        $this -> renderPartial('index');
    }
}