<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:00
 */
class SpecSiteHomeController extends HomeControllerCatalogCommon {
    public $layout = 'home';
//    public function actions() {
//        return SiteDispatcher::mergeArray(parent::actions(),[
//            'tomography'=>array(
//                'class'=>'application.controllers.actions.FileViewAction',
//                'view' => '/article/tomography',
//                'guest' => true,
//            ),
//        ]);
//    }
    /**
     * @return ObjectPrice[]
     */
    public function getPrices() {
        $config = Yii::app() -> params['priceBlocks'];
        if (empty($config)) {
            return ObjectPrice::model() -> findAll(['order' => 'id_block ASC']);
        }
        $crit = new CDbCriteria();
        $crit -> addInCondition('id_block', $config);
        return ObjectPrice::model() -> findAll($crit);
    }
}