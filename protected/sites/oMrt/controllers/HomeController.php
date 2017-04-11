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

    public function actionRemakeSitemap(){
        require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');

        $sitemap = new samdark\sitemap\Sitemap(SiteDispatcher::getFilesDir().'/sitemap.xml');
        function fullUrl($fromRoot) {
            static $root = false;
            if (!$root) {
                $root = "http://".$_SERVER['HTTP_HOST'];
            }
            return $root.$fromRoot;
        }
        //Добавляем все клиники
        foreach (clinics::model() -> findAll() as $clinic) {
            $sitemap -> addItem(fullUrl($this -> createUrl('home/modelView',['modelName' => "clinics", 'verbiage' => $clinic -> verbiage])),time(),null,1.0);
        }
        //Добавляем все статьи
        $crit = new CDbCriteria();
        $crit -> compare('id_type',Article::getTypeId('text'));
        foreach (Article::model() -> findAll($crit) as $article) {
            $sitemap -> addItem(fullUrl($this -> createUrl('home/articleView',['verbiage' => $article -> verbiage])),time(),null,1.0);
        }

//        $triggers = [
//            'district' => ['distr1', 'distr2'],
//            'metro' => [2,1],
//            'research' => ['mrt','kt']
//        ];

        $controller = $this;
        function cartesianSitemap($toUse, &$sitemap, &$controller, $alreadyUsed = []) {
            /**
             * @type samdark\sitemap\Sitemap $sitemap
             */
            //Если мы на нижнем уровне, то записаваем нацонец-таки в фсайтмап результат
            if (empty($toUse)) {
                $sitemap->addItem(fullUrl($controller -> createUrl('home/clinics', $alreadyUsed)),time(),null,0.9);
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
                cartesianSitemap($toUse,$sitemap, $controller,array_merge($alreadyUsed,[$key => $value]));
            }
        }
        //Делаем siteMap по Питерским триггерам
        $triggers = [];

        $districts = [
            false,
            'admiralteyskiy', 'petrogradskiy', 'kalininskiy',
            'central-nyy', 'krasnosel-skiy', 'kirovskiy', 'moskovskiy',
            'krasnogvardeyskiy', 'frunzenskiy', 'nevskiy', 'vyborgskiy',
            'primorskiy', 'vasileostrovskiy'
        ];

        $metros = [
            false, 21, 23, 63, 58, 64, 3, 53, 59, 60, 51, 50, 61, 65, 47, 24, 36, 31, 22, 39
        ];

        $research = [
            false,
            'mrtMozg', 'mrtHyp', 'mrtOrbit','mrtBackSpine','mrtChestSpine','mrtNeckSpine',
            'mrtAbdomen', 'MRTkidney', 'MRTliver', 'mrtPelvis','mrtHipJoint','mrtKneeJoint',
            'mrtShoulderJoint','MRTmolochniejelezi','mrtBrainVessels','ktBrainVessels',
            'ktMozg','ktNose','ktAbdomen','KTkidney','KTliver','ktPelvis','ktLungs'
        ];

        $triggers = [
            'district' => $districts,
            'metro' => $metros,
            'research' => $research
        ];
        cartesianSitemap($triggers, $sitemap, $controller,['area' => 'spb']);
        //Делаем сайтмап по Московским триггерам
        $districts = [
            false, 'severnoe-tushino','yuzhnoe-tushino','perovo','kurkino','lyublino',
            'mar-ino','bibirevo','vyhino-zhulebino','sokol-niki','novogireevo','strogino',
            'biryulevo-vostochnoe','biryulevo-zapadnoe','otradnoe','novo-peredelkino','yasenevo',
            'novokosino'
        ];

        $metros = [
            false, 215, 223, 229, 132, 163, 143, 161, 210, 134, 77, 136, 218, 303, 145, 84, 152, 227, 307, 70, 116, 146
        ];
        $triggers = [
            'research' => $research,
        ];

        $subs = [
            'Lyberczi', 'Mytichi', 'Odinchovo','Podolsk','Vidnoe','Zelenograd','SergievPosad','balashiha','Kolomna',
            'Orehovo-Zuevo','Himki','Voskresensk','Domodedovo','Schelkovo','Krasnogorsk','Dolgoprudnyi','Dubna',
            'Ramenskoe','Korolev','Naro-Fominsk'
        ];

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