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
            'clinicsLink'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/clinics/redirect',
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
    
    private function research($area = null){
        return [
            false,
            'mrtMozg', 'mrtHyp', 'mrtOrbit','mrtBackSpine','mrtChestSpine','mrtNeckSpine',
            'mrtAbdomen', 'MRTkidney', 'MRTliver', 'mrtPelvis','mrtHipJoint','mrtKneeJoint',
            'mrtShoulderJoint','MRTmolochniejelezi','mrtBrainVessels','ktBrainVessels',
            'ktMozg','ktNose','ktAbdomen','KTkidney','KTliver','ktPelvis','ktLungs'
        ];
    }
    private function district($area) {
        if ($area == 'spb') {
            return [
                false,
                'admiralteyskiy', 'petrogradskiy', 'kalininskiy',
                'central-nyy', 'krasnosel-skiy', 'kirovskiy', 'moskovskiy',
                'krasnogvardeyskiy', 'frunzenskiy', 'nevskiy', 'vyborgskiy',
                'primorskiy', 'vasileostrovskiy'
            ];
        }
        if ($area == 'msc') {
            return [
                false, 'severnoe-tushino','yuzhnoe-tushino','perovo','kurkino','lyublino',
                'mar-ino','bibirevo','vyhino-zhulebino','sokol-niki','novogireevo','strogino',
                'biryulevo-vostochnoe','biryulevo-zapadnoe','otradnoe','novo-peredelkino','yasenevo',
                'novokosino'
            ];
        }
        return false;
    }
    private function metro($area){
        if ($area == 'msc') {
            return [
                false, 21, 23, 63, 58, 64, 3, 53, 59, 60, 51, 50, 61, 65, 47, 24, 36, 31, 22, 39
            ];
        }
        if ($area == 'spb') {
            return [
                false, 21, 23, 63, 58, 64, 3, 53, 59, 60, 51, 50, 61, 65, 47, 24, 36, 31, 22, 39
            ];
        }
        return [false];
    }

    private function siteMapSPB() {
        
    }
    private function cartesianSitemap($toUse, &$sitemap, $alreadyUsed = []) {
        /**
         * @type samdark\sitemap\Sitemap $sitemap
         */
        //Если мы на нижнем уровне, то записаваем нацонец-таки в фсайтмап результат
        if (empty($toUse)) {
            $sitemap->addItem($this -> fullUrl($this -> createUrl('home/clinics', $alreadyUsed)),null,null,0.9);
            return;
        }
        //Если же нет, то получаем очередной ключ
        $key = key($toUse);
        if (!$key) {
            throw new Exception('Invalid key. Got "'.$key.'"');
        }
        //И пробегаем по всем вариантам значений в этом измерении,
        //добавив к уже имеющейся комбинации дополнительное условие
        $toLoop = array_shift($toUse);
        $alreadyUsed = array_filter($alreadyUsed);
        foreach ($toLoop as $value) {
            $this -> cartesianSitemap($toUse,$sitemap, array_merge($alreadyUsed,[$key => $value]));
        }
    }

    private function suburbs($area){
        if ($area == 'spb') {
            $trigger = Triggers::model() -> findByPk(17);
            $rez = [];
            foreach ($trigger -> trigger_values as $val) {
                if (current($val -> dependencies) -> parent -> verbiage == 'spb') {
                    $rez[] = $val -> verbiage;
                }
            }
            array_unshift($rez, false);
            return $rez;
        }
        if ($area == 'msc') {
            return [
                false, 'Lyberczi', 'Mytichi', 'Odinchovo','Podolsk','Vidnoe','Zelenograd','SergievPosad','balashiha','Kolomna',
                'Orehovo-Zuevo','Himki','Voskresensk','Domodedovo','Schelkovo','Krasnogorsk','Dolgoprudnyi','Dubna',
                'Ramenskoe','Korolev','Naro-Fominsk'
            ];
        }
        return [false];
    }
    private function fullUrl($fromRoot) {
        static $root = false;
        if (!$root) {
            $root = "http://".$_SERVER['HTTP_HOST'];
        }
        return $root.$fromRoot;
    }

    public function actionRemakeSitemap(){
        require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
        /**
         * @type ClinicsModule $mod
         */
        $mod = Yii::app() -> getModule('clinics');

        //Заготовили общие триггеры, которые всегда перемножаются
        $common = [
            'research' => $this -> research(),
            'field' => [false,'strong','extraStrong'],
            'magnetType' => [false,'opened','closed'],
            'children' => [false,'yes'],
            'contrast' => [false, 'withConstrast']
        ];

        $sitemap = new samdark\sitemap\Sitemap(SiteDispatcher::getFilesDir().'/sitemapSPB.xml');


        //Добавляем все статьи
        $crit = new CDbCriteria();
        $crit -> compare('id_type',Article::getTypeId('text'));
        foreach (Article::model() -> findAll($crit) as $article) {
            $sitemap -> addItem($this -> fullUrl($this -> createUrl('home/articleView',['verbiage' => $article -> verbiage])),null,null,1.0);
        }
        //Делаем sitemap по Питеру
        //Добавляем все клиники СПб
        foreach ($mod -> getClinics(['area' => 'spb']) as $clinic) {
            $sitemap -> addItem($this -> fullUrl($this -> createUrl('home/modelView',['modelName' => "clinics", 'verbiage' => $clinic -> verbiage,'area'=> 'spb'])),null,null,1.0);
        }

        //Общее + районы
        $this -> cartesianSitemap([
                'district' => array_filter($this -> district('spb'))
            ]+$common, $sitemap, ['area' => 'spb']);
        //Общее + метро
        $this -> cartesianSitemap([
                'metro' => array_filter($this -> metro('spb'))
            ]+$common, $sitemap, ['area' => 'spb']);
        //Общее + пригороды
        $this -> cartesianSitemap([
                'prigorod' => array_filter($this -> suburbs('spb'))
            ]+$common, $sitemap, ['area' => 'spb']);
        $sitemap -> write();
        unset($sitemap);


        //Делаем сайтмап по Московским триггерам
        $sitemap = new \samdark\sitemap\Sitemap(SiteDispatcher::getFilesDir().'/sitemapMSC.xml');
        //Добавляем все клиники МСК
        foreach ($mod -> getClinics(['area' => 'msc']) as $clinic) {
            $sitemap -> addItem($this -> fullUrl($this -> createUrl('home/modelView',['modelName' => "clinics", 'verbiage' => $clinic -> verbiage,'area'=> 'msc'])),null,null,1.0);
        }
        //Общее + районы
        $this -> cartesianSitemap([
                'district' => array_filter($this -> district('msc'))
            ]+$common, $sitemap, ['area' => 'msc']);
        //Общее + метро
        $this -> cartesianSitemap([
                'metro' => array_filter($this -> metro('msc'))
            ]+$common, $sitemap, ['area' => 'msc']);
        //Общее + пригороды
        $this -> cartesianSitemap([
                'prigorod' => array_filter($this -> suburbs('msc'))
            ]+$common, $sitemap, ['area' => 'msc']);
        $aos = array_map(function($val){ return $val -> verbiage;},Triggers::model() -> findByPk(18) -> trigger_values);
        array_unshift($aos,false);
        //Общее + Административные округа
        $this -> cartesianSitemap([
                'okrug' => array_filter($aos)
            ]+$common, $sitemap, ['area' => 'msc']);
        $sitemap -> write();
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