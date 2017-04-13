<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.04.2017
 * Time: 17:59
 */
class SeoController extends CController {

    public function actionRobots(){
        header( 'Content-Type: text/plain' );
        $filename = SiteDispatcher::getFilesDir().'/robots.txt';
        if (file_exists($filename)) {
            readfile($filename);
        } else {
            //Генерируем стандартный robots.txt
            echo "Sitemap: http://". $_SERVER['SERVER_NAME'].$this -> createUrl('seo/sitemap');
            //throw new CHttpException(404,'Robots.txt file is not present');
        }
    }
    public function actionSitemap($name = ''){
        header('Content-Type: application/xml');
        $filename = SiteDispatcher::getFilesDir()."/sitemap$name.xml";
        if (file_exists($filename)) {
            readfile($filename);
        } else {
            throw new CHttpException(404,"No sitemap$name.xml found.");
        }
    }
}