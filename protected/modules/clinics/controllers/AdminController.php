<?php

class AdminController extends Controller
{
	public $defaultAction = 'login';
	public $layout='/layouts/admin';
    public $pageTitle;
	//list of prices to export
	public $clinicsPrices = array(
		'price' => 'Цена',
		'price2' => 'Цена1'
	);
	//list of prices to export
	public $doctorsPrices = array(
		
	);
	//Базовые поля для экспорта.
	public $clinicsFields = Array(
			'name' => 'Название',
			'site' => 'Сайт',
			'verbiage' => 'Урл',
			'logo' => 'Логотип',
			'city' => 'Город',
			'address' => 'Адрес',
			'district' => 'Район',
			'metro_station' => 'Метро',
			'phone' => 'Телефон',
			'phone_extra' => 'Дополнительный телефон',
			'email' => 'Электронная почта',
			'working_hours' => 'Часы работы',
			'triggers' => 'Триггеры',
			'description' => 'мета-тег description',
			'keywords' => 'мета-тег keywords'
	);
	//Базовые поля для экспорта.
	public $doctorsFields = Array(
			'name' => 'Название',
			'site' => 'Сайт',
			'verbiage' => 'Урл',
			'logo' => 'Логотип',
			'city' => 'Город',
			'address' => 'Адрес',
			'district' => 'Район',
			'metro_station' => 'Метро',
			'phone' => 'Телефон',
			'phone_extra' => 'Дополнительный телефон',
			'email' => 'Электронная почта',
			'working_hours' => 'Часы работы',
			'triggers' => 'Триггеры',
			'description' => 'мета-тег description',
			'keywords' => 'мета-тег keywords'
	);
	
	private $_model;

    public function actions(){
        return [
            'objectCommentsList'=>array(
                'class'=>'application.controllers.actions.ModelViewAction',
                'modelClass' => $_GET['modelName'],
                'scenario' => 'comments',
                'view' => '/comments/_list'
            ),
            'objectCommentCreate' => array(
                'class' => 'application.controllers.actions.ClassMethodAction',
                'method' => 'createComment',
                'modelClass' => $_GET['modelName'],
                'view' => $_POST['submit'] ? false : '/comments/create',
                'redirectUrl' => function($data){
                    return $this -> createUrl('admin/objectCommentsList',['modelName' => get_class($data), 'id' => $data -> id]);
                },
                'scenario' => 'comments',
                'access' => $this -> isSuperAdmin()
            ),
            'PriceBlockList'=>array(
                'class'=>'application.controllers.actions.FileViewAction',
                //'access' => function () {return $this -> isSuperAdmin();},
                'view' => '/prices/blocks/_list',
                'access' => $this -> isSuperAdmin()
            ),
            'PriceBlockCreate' => array(
                'class' => 'application.controllers.actions.ModelCreateAction',
                'modelClass' => 'ObjectPriceBlock',
                'view' => '/prices/blocks/create',
                'redirectUrl' => $this -> createUrl('admin/PriceBlockList'),
                'scenario' => 'create'
            ),
            'PriceBlockUpdate' => array(
                'class' => 'application.controllers.actions.ModelUpdateAction',
                'modelClass' => 'ObjectPriceBlock',
                'view' => '/prices/blocks/update',
                'redirectUrl' => function($data){
                    return $this -> createUrl('admin/PriceBlockList');
                },
                'scenario' => 'update'
            ),
            'PriceBlockDelete' => array(
                'class' => 'application.controllers.actions.ModelDeleteAction',
                'modelClass' => 'ObjectPriceBlock'
            ),

            'PriceList'=>array(
                'class'=>'application.controllers.actions.ModelViewAction',
                'modelClass' => $_GET['modelName'],
                'scenario' => 'model',
                //'access' => function () {return $this -> isSuperAdmin();},
                'view' => '/prices/_list'
            ),
            'PriceCreate' => array(
                'class' => 'application.controllers.actions.ModelCreateAction',
                'modelClass' => 'ObjectPrice',
                'view' => '/prices/create',
                'redirectUrl' => $this -> createUrl('admin/PriceList',['modelName' => $_GET['modelName']]),
                'scenario' => 'create'
            ),
            'PriceUpdate' => array(
                'class' => 'application.controllers.actions.ModelUpdateAction',
                'modelClass' => 'ObjectPrice',
                'view' => '/prices/update',
                'redirectUrl' => function($data){
                    return $this -> createUrl('admin/PriceList',['modelName' => Objects::getName($data -> object_type)]);
                },
                'scenario' => 'update'
            ),
            'PriceDelete' => array(
                'class' => 'application.controllers.actions.ModelDeleteAction',
                'modelClass' => 'ObjectPrice'
            ),
            'cabinet' => array(
                'class' => 'application.controllers.actions.ModelViewAction',
                'modelClass' => 'User',
                'view' => '//LK'
            ),
            'Rules' => [
                'class'=>'application.controllers.actions.FileViewAction',
                'view' => '/rule/admin'
            ],
            'RuleList' => [
                'class'=>'application.controllers.actions.ModelViewAction',
                'modelClass' => 'ArticleRule',
                'scenario' => 'list',
                //'access' => function () {return $this -> isSuperAdmin();},
                'view' => '/rule/list'
            ],
            'RuleCreate' => [
                'class'=>'application.controllers.actions.ModelCreateAction',
                'modelClass' => 'ArticleRule',
                'scenario' => 'create',
                'redirectUrl' => function($model){
                    return $this -> createUrl('admin/RuleList',['type' => $model -> id_object_type]);
                },
                'view' => '/rule/_create'
            ],
            'RuleUpdate' => [
                'class'=>'application.controllers.actions.ModelUpdateAction',
                'modelClass' => 'ArticleRule',
                'scenario' => 'update',
                'redirectUrl' => function($model){
                    return $this -> createUrl('admin/RuleList',['type' => $model -> id_object_type]);
                },
                'view' => '/rule/_update'
            ],
            'RuleDelete' => array(
                'class' => 'application.controllers.actions.ModelDeleteAction',
                'modelClass' => 'ArticleRule'
            ),
            'ArticleList' => [
                'class'=>'application.controllers.actions.ModelViewAction',
                'modelClass' => 'Article',
                'scenario' => 'list',
                //'access' => function () {return $this -> isSuperAdmin();},
                'view' => '/article/admin'
            ],
            'ArticleCreate' => [
                'class' => 'application.controllers.actions.ModelCreateAction',
                'modelClass' => 'Article',
                'view' => '/article/create',
                'redirectUrl' => $this -> createUrl('admin/ArticleList'),
                'scenario' => 'create'
            ],
            'ArticleUpdate' => array(
                'class' => 'application.controllers.actions.ModelUpdateAction',
                'modelClass' => 'Article',
                'view' => '/article/update',
                'redirectUrl' => function($data){
                    return $this -> createUrl('admin/ArticleList');
                },
                'scenario' => 'update'
            ),
            'ArticleDelete' => array(
                'class' => 'application.controllers.actions.ModelDeleteAction',
                'modelClass' => 'Article'
            ),
            'TriggerParameterList' => [
                'class'=>'application.controllers.actions.ModelViewAction',
                'modelClass' => 'TriggerParameter',
                'scenario' => 'list',
                //'access' => function () {return $this -> isSuperAdmin();},
                'view' => '/triggers/parameters/_list'
            ],
            'TriggerParameterCreate' => [
                'class' => 'application.controllers.actions.ModelCreateAction',
                'modelClass' => 'TriggerParameter',
                'view' => '/triggers/parameters/create',
                'redirectUrl' => function($model){return $this -> createUrl('admin/TriggerParameterList',['id' => $model -> id_trigger]);},
                'scenario' => 'create'
            ],
            'TriggerParameterUpdate' => array(
                'class' => 'application.controllers.actions.ModelUpdateAction',
                'modelClass' => 'TriggerParameter',
                'view' => '/triggers/parameters/update',
                'redirectUrl' => function($model){return $this -> createUrl('admin/TriggerParameterList',['id' => $model -> id_trigger]);},
                'scenario' => 'update'
            ),
            'TriggerParameterDelete' => array(
                'class' => 'application.controllers.actions.ModelDeleteAction',
                'modelClass' => 'TriggerParameter'
            ),

            'createArticleFast' => array(
                'class' => 'application.controllers.actions.ClassMethodAction',
                'method' => 'createDescendantFast',
                'ajax' => true,
                'ignore' => true,
                'modelClass' => 'Article',
                'scenario' => 'createDescendant',
                'access' => true
            ),
            'copyDescendants' => array(
                'class' => 'application.controllers.actions.ClassMethodAction',
                'method' => 'copyDescendants',
                'ajax' => true,
                'ignore' => true,
                'modelClass' => 'Article',
                'scenario' => 'copyDescendants',
                'access' => true
            ),
            'triggerRequest' => array(
                'class' => 'application.controllers.actions.ClassMethodAction',
                'method' => 'dumpValues',
                'ajax' => true,
                'ignore' => true,
                'modelClass' => 'Triggers',
                'scenario' => 'dumpValues',
                'access' => true,
                'guest' => true
            ),
        ];
    }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    
    
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                  'actions'=>array('login', 'triggerRequest'),
                  'users'=> array('*')
			),
            array('allow',
                      //'actions'=>array('index', 'view', 'clinics', 'triggers', 'banners', 'articles', 'comments', 'menus', 'logout'),
                      'expression'=> 'Yii::app()->controller->isSuperAdmin()',
                      //'users'=> array('*')
            ),
            array('allow',
                    'actions' => array('logout', 'clinicUpdate'),
                    'expression'=>'Yii::app()->controller->isClinicAdmin()',
                    //'users' => array('*')
            ),            
            array('deny',  // deny all users
                  'users'=>array('*'),
            ),
            
        );

	}   

    public function isSuperAdmin()
    {
        $user = User::model()->findbyPk(Yii::app()->user->id);
         
        if ($user) {
            if ($user->superuser != 1)
                return false;
            else
                return true;                        
        }
        return false;        
    }

    public function isClinicAdmin()
    {
        $user = User::model()->findbyPk(Yii::app()->user->id); //var_dump($user->clinic_id); die();
        if ($user) {
            if ($user->clinic_id)
                return $user->clinic_id;
            else
                return false;
        }
        return false;    
    }
    
    /**
     * Displays Login page.
     */
    public function actionLogin()
    {  
        if ($this->isSuperAdmin())
            $this->redirectHome();

        if ($this->isClinicAdmin())
            $this->redirect(array('admin/clinicUpdate/'. $this->isClinicAdmin()));
            
        $this->layout='admin_login';
        $this->pageTitle = Yii::app()->name . ' - Админка Логин';
        
        $model=new LoginForm;

        //print (Yii::app()->controller->isAdmin());
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            $val = $model->validate();
            $log = $model->login();
            if( $val && $log ) {
                if ($this->isSuperAdmin())
                    $this->redirectHome();

                if ($this->isClinicAdmin())
                    $this->redirect(array('admin/clinicUpdate/'. $this->isClinicAdmin()));
                
           }            
        }

        $this->render('login',array('model'=>$model));

    }
	public function actionImageUpload() {
		/*******************************************************
		* Only these origins will be allowed to upload images *
		******************************************************/
		$accepted_origins = array("http://localhost", "http://192.168.1.1", "http://cq97848.tmweb.ru");

		/*********************************************
		* Change this line to set the upload folder *
		*********************************************/
		$imageFolder = "http://localhost/test/public_html/files/tinymce/source/";

		reset ($_FILES);
		$temp = current($_FILES);
		if (is_uploaded_file($temp['tmp_name'])){
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// same-origin requests won't set an origin. If the origin is set, it must be valid.
				if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
					header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
				} else {
					header("HTTP/1.0 403 Origin Denied");
					return;
				}
			}
				
			/*
				If your script needs to receive cookies, set images_upload_credentials : true in
				the configuration and enable the following two headers.
			*/
			// header('Access-Control-Allow-Credentials: true');
			// header('P3P: CP="There is no P3P policy."');

			// Sanitize input
			if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
				header("HTTP/1.0 500 Invalid file name.");
				return;
			}

			// Verify extension
			if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
				header("HTTP/1.0 500 Invalid extension.");
				return;
			}

			// Accept upload if there was no origin, or if it is an accepted origin
			$filetowrite = $imageFolder . $temp['name'];
			move_uploaded_file($temp['tmp_name'], $filetowrite);

			// Respond to the successful upload with JSON.
			// Use a location key to specify the path to the saved image resource.
			// { location : '/your/uploaded/image/file'}
			echo json_encode(array('location' => $filetowrite));
		} else {
			// Notify editor that the upload failed
			header("HTTP/1.0 500 Server Error");
		}
	}
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('login'));
    }
	public function actionSettings(){
		$model = Setting::model() -> find();
		if (isset($_POST["Setting"])) {
			$model -> attributes = $_POST["Setting"];
			if ($model -> save()){
				new CustomFlash('success', 'Setting','Saved','Изменения успешно сохранены!',true);
			}
		}
		$crit = new CDbCriteria();
		$crit -> order = 'position ASC';

		
		$this -> render('settings', array(
			'model' => $model
		));
	}

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        //if (Yii::app()->controller->isAdmin()) print 'yes'; else print 'no';
        //var_dump(Yii::app()->controller->isAdmin()); //die();
        //$model = $this->loadModel();
        $this->render('view', array(
            //'model'=>$model,
        ));
    }

    public function actionBanners()
    {   
        // top banner
      
        $top_banner = Options::model()->findByAttributes(array('name' => 'top_banner'));
        $side_banner = Options::model()->findByAttributes(array('name' => 'side_banner'));

                $end = function($c) use($top_banner, $side_banner) {$c->render('banners',array(
                   'top_banner'=> $top_banner,
                   'side_banner'=> $side_banner)
               );};
    
        $allowed =  array('gif','png','jpg', 'jpeg');

        if (isset($_FILES['top_banner'])){ 
            if (trim($_FILES['top_banner']['name']) != '') {
                $top_banner_old = $top_banner->value;
                $filename = $_FILES['top_banner']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);   
                if(!in_array($ext,$allowed) ) {
                    Yii::app()->user->setFlash('errorUploadTop', 'Недопустимый формат файла для верхнего баннера');
                    $end($this);
                    return;
                }  
                      
                $top_banner_filePath = Yii::app()->basePath . '/../images/banners/' . basename($_FILES['top_banner']['name']);
        
                if (move_uploaded_file($_FILES['top_banner']['tmp_name'], $top_banner_filePath)) {
                    $top_banner->value = $_FILES['top_banner']['name'];
                    if ($top_banner->save())
                        Yii::app()->user->setFlash('successfullUploadTop', 'Файл для верхнего баннера успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUploadTop', 'При загрузке файла для верхнего баннера произошла ошибка');
                }
        
                if (!file_exists($top_banner_filePath)) {
                    Yii::app()->user->setFlash('nothingToUploadTop', 'Файл для загрузки не найден (верхний баннер)');
                    $end($this);
                    return;
                }
            }      
        }
                
        if (isset($_FILES['side_banner'])){ 
            if (trim($_FILES['side_banner']['name']) != '') {

                $filename = $_FILES['side_banner']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    Yii::app()->user->setFlash('errorUploadSide', 'Недопустимый формат файла для бокового баннера');
                    $end($this);
                    return;
                }  
                      
                $side_banner_filePath = Yii::app()->basePath.'/../images/banners/' . basename($_FILES['side_banner']['name']);

                if (move_uploaded_file($_FILES['side_banner']['tmp_name'], $side_banner_filePath)) {
                    $side_banner->value = $_FILES['side_banner']['name'];
                    if ($side_banner->save())
                        Yii::app()->user->setFlash('successfullUploadSide', 'Файл для бокового баннера успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUploadSide', 'При загрузке файла для бокового баннера произошла ошибка');
                }
        
                if (!file_exists($side_banner_filePath)) {
                    Yii::app()->user->setFlash('nothingToUploadSide', 'Файл для загрузки не найден (боковой баннер)');
                    $end;
                    return;
                }  
            }    
        }                
       
       $end($this);
    }

    public function actionMenus() 
    {   
        $model = new Menus;

        $this->render('menus_list',
                array('model' => $model)
        );
    }

    public function actionmenuCreate()
    {
        $model = new Menus;
        
        if(isset($_POST['Menus']))
        {
            $model->attributes=$_POST['Menus'];
            if($model->save())
                $this->redirect(array('/admin/menus'));
        }

        $this->render('//menus/create',array(
            'model'=>$model,
        ));
    }

    public function actionmenuUpdate($id)
    {
        $model = Menus::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        if(isset($_POST['Menus']))
        {
            $model->attributes=$_POST['Menus'];
            if($model->save())
                $this->redirect(array('/admin/menus','id'=>$model->id));
        }
        $this->render('//menus/update',array(
            'model'=>$model,

        ));
    }

    public function actionmenuDelete($id)
    {
        $model = Menus::model()->findByPk($id);
        $model->delete();
        
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
        
    public function actionModels($modelName)
	{
		$model = new $modelName('search');
		$model->unsetAttributes();
        if(isset($_GET[ucfirst(strtolower($modelName))]))
            $model->attributes = $_GET[ucfirst(strtolower($modelName))];

        $this->render('/'.$modelName.'/_list',array(
            'model'=>$model,
        ));
	}
    /*public function actionClinics()
    {
        $model = new clinics('search'); 
        $model->unsetAttributes();
        if(isset($_GET['clinics']))
            $model->attributes = $_GET['clinics'];

        $this->render('clinics_list',array(
            'model'=>$model,
        ));
    }*/
	
	protected function objectInit($model)
	{
		$modelName = get_class($model);
		if (isset($_POST[$modelName]))
		{
			$model -> FillFieldsFromArray($model, $_POST);
			//Если ключом для сохранения файлов является id, и модель новая, то сохраняем модель, чтобы его получить
			if (($model -> FolderKey() === 'id')&&($model -> isNewRecord))
				$model -> save();
			//Делаем с файлами все, что нужно.
			if (isset($_FILES))
				$model -> FilesOperationsFromArray($model, $_FILES);
			//Сохраняем все изменения и редиректим куда нужно.
			if ($model -> save())
			{
				if ($this->isSuperAdmin())
					$this->redirect(array(strtolower($modelName)));
				else {
					Yii::app()->user->setFlash('successfullSave', CHtml::encode('Изменения сохранены'));
					return; 
				}
			} else {
				return false;
			}
		}
	}
	/*protected function clinicInit($model)
	{
		if (isset($_POST['clinics']))
		{
			$model -> FillClinicFieldsFromArray($model, $_POST);
			//Если ключом для сохранения файлов является id, и модель новая, то сохраняем модель, чтобы его получить
			if (($model -> FolderKey() === 'id')&&($model -> isNewRecord))
				$model -> save();
			//Делаем с файлами все, что нужно.
			if (isset($_FILES))
				$model -> ClinicFilesOperationsFromArray($model, $_FILES);
			//Сохраняем все изменения и редиректим куда нужно.
			if ($model -> save())
			{
				if ($this->isSuperAdmin())
					$this->redirect(array('clinics'));
				else {
					Yii::app()->user->setFlash('successfullSave', CHtml::encode('Изменения сохранены'));
					return; 
				}
			} else {
				return false;
			}
		}
	}*/

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionObjectCreate($modelName)
    {
        $model = new $modelName();

        $this->objectInit($model);

        $this->render('/'.$modelName.'/_create',array(
            'model'=>$model
        ));
    }
    public function actionObjectUpdate($id, $modelName)
    {
        if (!$this->isSuperAdmin())
            if ((int)$id != (int)$this->isDoctor()) {
                new CustomFlash('warning','Admin','AccessDenied','У вас недостаточно прав для просмотра данной страницы. Скорее всего, Вы опечатались при наборе своего id в базе.',true);
                return false;
            }

        $model = $modelName::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        $this->objectInit($model);

        $this->render("/$modelName/_update",array(
            'model'=>$model,
        ));
    }
    //public function actionclinicDelete($id)
    public function actionObjectDelete($id, $modelName)
    {
        $model = $modelName::model()->findByPk($id); //print $model->primaryKey; die();
        $model->delete();
        
        // reset autoincrement     
        //resetId($model);
        
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionpropDelete($id = NULL)
    {	
        switch ($_POST['model']) {
            case 'clinic': $model = clinics::model()->findByPk($id);
                       break;
            case 'trigger': $model = Triggers::model()->findByAttributes(array('name' => $_POST['prop']));    
                       break;                    
			case 'RightText': $model = RightText::model() -> findByPk($id);
						break;
			case 'HorizontalText': $model = HorizontalText::model() -> findByPk($id);
						break;
		}
        
		//$model = clinics::model()->findByPk($id);
        switch ($_POST['prop']) {
				case 'image': $model -> image = NULL; //for righttext
							break;
                case 'logo':        $model->logo = NULL;   
                                    //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                    break;
                case 'img':         if (isset($_POST['prop_value'])) {                                
                                        $images_old = explode(';', $model->pictures);
                                        $img = $_POST['prop_value'];   
                                        if(($key = array_search($img, $images_old)) !== false) {
                                            unset($images_old[$key]);
                                            $images = implode(';' , $images_old); 
                                        }                         
                                        //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                        $model->pictures = $images;                       
                                    }
                                    break;
                case 'top_banner':            
                case 'side_banner': $model->value = NULL;   
                                    break;         
                case 'audio':       $model->audio = NULL;   
                                    //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                    break;
                                                                   
        }
        
        if (!$model->save())
            echo CHtml::encode('Файл не может быть удален');
           
        Yii::app()->end();
                           
    }
    /**
     * Displays a particular Pricelist.
     */
//    public function actionPricelists($id, $modelName)
//    {
//
//        $model = new PriceList('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
//        $model->object_id = $id;
//        $model->object_type = Objects::model()->getNumber($modelName);
//        $object = $modelName::model()->findByPk($id);
//
//        $this->render('/pricelist/admin',array(
//            'model'=>$model,
//            'object_id'=>$id,
//            'object'=>$object
//        ));
//    }
    /**
     * Displays a particular Pricelist.
     */
    public function actionPricelists($id, $modelName)
    {

        $model = new PriceList('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->object_id = $id;
        /**
         * @type clinics|doctors $object
         */
        $object = $modelName::model()->findByPk($id);
        $data = $_POST['prices'];
        if ($data) {
            foreach ($data as $id => $val) {
                if ($val > 0) {
                    $obj = new ObjectPriceValue();
                    $obj->id_object = $object->id;
                    $obj->id_price = $id;
                    $obj->value = $val;
                    if (!$obj -> save()) {
                        $err = $obj -> getErrors();
                    }
                } else {
                    if ($obj = $object -> getPriceValue($id)) {
                        $obj -> delete();
                    }
                }
            }
        }
        $this->render('/pricelist/adminVector',array(
            'model'=>$model,
            'object'=>$object
        ));
    }

	public function actionPricelistCreate($id, $modelName)
	{
		$model = new PriceList;
		$model->object_type = Objects::model() -> getNumber($modelName);
		$object = $modelName::model() -> findByPk($id);
		$object_id = $id;
		
		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			$model->object_id = $object_id;
			if($model->save())
				$this->redirect($this -> createUrl('admin/Pricelists',['modelName' => $modelName, 'id' => $object_id]));
				//$this->redirect(array('/admin/'.$modelName.'Pricelists', 'id' => $object_id));
		}
		
		$this->render('/pricelist/create',array(
			'model'=>$model,
			'object' => $object,
			'object_id' => $id
		));
	}
	public function actionPricelistUpdate($id)
	{
		$model=PriceList::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			if($model->save()) {
                $modelName = Objects::model() -> getName($model -> object_type);
                $this->redirect($this->createUrl("admin/Pricelists",['id' => $model -> object_id,'modelName' => $modelName]));
                //$this->redirect(array('/admin/' . Objects::model()->getName($model->object_type)));
            }
		}
		$this->render('/pricelist/update',array(
			'model'=>$model,
		));
	}

    public function actionPricelistDelete($id)
    {
        $model = PriceList::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Displays a particular Service.
     */
	public function actionClinicsServices($id)
	{
		$this -> Services($id, 'clinics');
	}
	public function actionDoctorsServices($id)
	{
		$this -> Services($id, 'doctors');
	}
    public function Services($id, $modelName)
    {
        $model = new Services('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->attributes=array('object_id'=>$id, 'object_type' => Objects::model() -> getNumber($modelName));
        $object = $modelName::model()->findByPk($id);

        $this->render('//services/admin',array(
            'model'=>$model,
            'object_id'=>$id,
            'object'=>$object
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actionClinicsServiceCreate($id){
		$this -> ServiceCreate($id, 'clinics');
	}
	public function actionDoctorsServiceCreate($id){
		$this -> ServiceCreate($id, 'doctors');
	}
    public function ServiceCreate($id, $modelName)
    {
        $model = new Services;
        $object_id = $id;
        //$clinic = clinics::model()->findByPk($id);
		$object = $modelName::model() -> findByPk($id);
        if(isset($_POST['Services']))
        {
            $model->attributes=$_POST['Services'];
            $model->object_id = $object_id;
			$model -> object_type = Objects::model()->getNumber($modelName);
            if($model->save())
                //$this->redirect(array('/admin/'.$modelName,'id'=>$model->object_id));
                $this->redirect(array('/admin/'.$modelName));
        }

        $this->render('//services/create',array(
            'model'=>$model,
			'object' => $object,
            'object_id' => $id
        ));
    }

    public function actionClinicsServiceUpdate($id){
		$this -> ServiceUpdate($id, 'clinics');
	}
	public function actionDoctorsServiceUpdate($id){
		$this -> ServiceUpdate($id, 'doctors');
	}
    public function ServiceUpdate($id, $modelName)
    {
        $model=Services::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        if(isset($_POST['Services']))
        {
            $model->attributes=$_POST['Services'];
            if($model->save())
                $this->redirect(array('/admin/'.$modelName.'Services','id'=>$model->object_id));
        }
        $this->render('//services/update',array(
            'model'=>$model
        ));
    }

    public function actionserviceDelete($id)
    {
        $model = Services::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


	public function actionFields($id, $modelName)
	{

		$model = new FieldsValue('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
		$model->attributes=array('object_id'=>$id,'object_type' => Objects::model() -> getNumber($modelName));
		$clinic = $modelName::model()->findByPk($id);

		$this->render('/fields/object/admin',array(
			'model'=>$model,
			'object_id'=>$id,
			'object'=>$clinic
		));
			
	}
//
//	public function actionClinicsFields($id)
//	{
//
//		$model = new FieldsValue('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
//		$model->attributes=array('object_id'=>$id,'object_type' => Objects::model() -> getNumber('clinics'));
//		$clinic = clinics::model()->findByPk($id);
//
//		$this->render('//clinicsfields/admin',array(
//			'model'=>$model,
//			'clinic_id'=>$id,
//			'clinic'=>$clinic
//		));
//
//	}
//	public function actionDoctorsFields($id)
//	{
//
//		$model = new FieldsValue('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
//		$model->attributes=array('object_id'=>$id,'field.object_type' => Objects::model() -> getNumber('doctors'));
//		$doctor = doctors::model()->findByPk($id);
//
//		$this->render('//doctorsfields/admin',array(
//			'model'=>$model,
//			'doctor_id'=>$id,
//			'doctor'=>$doctor
//		));
//
//	}


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionFieldsCreate($id, $modelName)
    {
        $model = new FieldsValue;
        $object = $modelName::model()->findByPk($id);
		$model->object_id = $id;
        if(isset($_POST['FieldsValue']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['FieldsValue'];
			//$model->object_type = Objects::model() -> getNumber($modelName);
            if($model->save())
                $this->redirect($this -> createUrl('admin/Fields', ['id'=>$id, 'modelName' => $modelName]));
        }

        $this->render('/fields/object/create',array(
            'model'=>$model,
			'object' => $object,
            'id' => $id
        ));
    }

    public function actionFieldsUpdate($id, $modelName)
    {
        $model = FieldsValue::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        //if(isset($_POST[ucfirst(strtolower($modelName)).'Fields']))
        if(isset($_POST['FieldsValue']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['FieldsValue'];
            if($model->save())
                $this->redirect($this -> createUrl('admin/Fields', ['id'=>$model->object_id, "modelName" => $modelName]));
			else
				print_r($model->getErrors());
        }
        $this->render('/fields/object/update',array(
            'model'=>$model,
        ));
    }

    public function actionFieldsDelete($id)
    {
        /**
         * @type FieldsValue $model
         */
        $model = FieldsValue::model()->findByPk($id);
        //$modelName = Objects::model() -> getName();
        //$id = $model -> object_id;
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            if (isset($_POST['returnUrl'])) {
                $this->redirect($_POST['returnUrl']);
            } else {
                $this->redirect('admin/index');
            }
        }
    }
    /**
     * Displays Trigger list
     */
     
    public function actionTriggers()
    {
        $model = new Triggers('search'); 
        $model->unsetAttributes();
        if(isset($_GET['Triggers']))
            $model->attributes = $_GET['Triggers'];

        $this->render('/triggers/_list',array(
            'model'=>$model,
        ));
    }

    public function actiontriggerCreate()
    {
        $model = new Triggers();
            
        if(isset($_POST[get_class($model)]))
        {
            $model->attributes=$_POST[get_class($model)];
            if($model->save()) {
				$images_filePath = $model -> giveImageFolderAbsoluteUrl();
				//echo $images_filePath;
				if (strlen($images_filePath) > 0)
				{
					if (!file_exists($images_filePath))
					{
						mkdir($images_filePath);
					}

					if(isset($_FILES[get_class($model)])) { // logo
					
						if(!empty($_FILES[get_class($model)]['name']['logo'])){
							$model->logo = CUploadedFile::getInstance($model,'logo');
							$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
							$fileName = $images_filePath . DIRECTORY_SEPARATOR . $image_unique_id;
		
							if ($model->validate()) {
								$model->logo->saveAs($fileName);
								$model->logo = $image_unique_id;
								$model->save();
							}
						}
					}
					$this->redirect($this -> createUrl('admin/triggers'));
				} else {
					new CustomFlash("error", get_class($model), 'CreateFilepath', 'Не удалось сгенерировать каталог для изображений.', true) ;
				}
            } 
        }

        $this->render('/triggers/create',array(
            'model'=>$model
        ));
    }
    
    public function actiontriggerUpdate($id)
    {
        $model = Triggers::model()->findByPk($id);
		
		if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
		
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		
        if (!file_exists($images_filePath))
            mkdir($images_filePath);

        if(isset($_POST[get_class($model)]))
        {
            $model->attributes=$_POST[get_class($model)];
            if(isset($_FILES[get_class($model)])) { // logo
                if(!empty($_FILES[get_class($model)]['name']['logo'])){
                    $logo_old = $model->logo;
                    $model->logo = CUploadedFile::getInstance($model,'logo');
                    $image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
                    $fileName = $images_filePath . '/' . $image_unique_id;

                    if ($model->validate()) {
                        $model->logo->saveAs($fileName);
                        $model->logo = $image_unique_id;
						@unlink($images_filePath.'/'.$logo_old);
                    }
                    else
                        $model->logo = $logo_old;
                }
            }    
                      
            if($model->save())
                $this->redirect($this -> createUrl('admin/triggers'));
        }
        $this->render('/triggers/update',array(
            'model'=>$model,
        ));
    }

    public function actiontriggerDelete($id)
    {
        $model = Triggers::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actiontriggerValues($id)
    {
        $model = new TriggerValues('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->attributes=array('trigger_id'=>$id);
        $trigger = Triggers::model()->findByPk($id);

        $this->render('/triggervalues/admin',array(
            'model' => $model,
            'trigger_id' => $id,
            'trigger' => $trigger
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actiontriggerValueCreate($id)
	{
		$model = new TriggerValues();
		$trigger_id = $id;

		if(isset($_POST['TriggerValues']))
		{
			$model->attributes=$_POST['TriggerValues'];
			$model->trigger_id = $trigger_id;
			if($model->save())
				$this->redirect(array('admin/triggerValues', 'id'=>$trigger_id));
		}

		$this->render('/triggervalues/create',array(
			'model'=>$model,
			'trigger_id' => $id
		));
	}

	public function actiontriggerValueUpdate($id)
	{
		$model = TriggerValues::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_POST['TriggerValues']))
		{
			$model->attributes=$_POST['TriggerValues'];
			if($model->save())
				$this->redirect(array('admin/triggerValues', 'id'=>$model->trigger_id));
		}
		$this->render('/triggervalues/update',array(
			'model'=>$model,

		));
	}

    public function actiontriggerValueDelete($id)
    {
        $model = TriggerValues::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }     
    public function actionDescriptions()
	{
		$model = new Description();
		$model -> unsetAttributes();
		if (isset($_GET['Description']))
		{
			$model->attributes = $_GET['Description'];
			$model -> searchId = $_GET['Description']['searchId'];
		}
		$this -> render ( '//descriptions/admin', array(
			'model' => $model
		));
	}
	public function actionDescriptionCreate()
	{
		$model = new Description('search');
		$model->attributes=$_POST['Description'];
		if(isset($_POST['Description']))
		{
			$values_array = $_POST['triggers_array'];
			asort($values_array);
			$model -> trigger_values = implode(';', $values_array);
			if($model->save())
				$this->redirect(array('admin/Descriptions', 'id'=>$trigger_id));
		} else {
			$model -> trigger_values = $_POST['triggers_array'];
		}

		$this->render('//descriptions/create',array(
			'model'=>$model
		));
	}

	public function actionDescriptionUpdate($id)
	{
		$model = Description::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_GET['Description']))
		{
			$model->attributes=$_POST['Description'];
			if($model->save())
				$this->redirect(array('admin/Descriptions'));
		}
		$this->render('//descriptions/update',array(
			'model'=>$model,

		));
	}
	public function actionDescriptionDelete($id)
    {
        $model = Description::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Displays Users list
     */
    //public function actionFields()
    public function actionFieldsGlobal($modelName)
    {
        $model = new Fields('search');
        $model->unsetAttributes();
		$model->object_type = Objects::model() -> getNumber($modelName);
        if(isset($_GET['Fields'])) {
            $model->attributes = $_GET['Fields'];
		}
		
        $this->render('/fields/_list',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionFieldCreateGlobal($modelName)
    {
        $model = new Fields;

        if(isset($_POST['Fields']))
        {
            $model->attributes=$_POST['Fields'];
			$model->object_type = Objects::model() -> getNumber($modelName);
            if($model->save())
                $this->redirect($this -> createUrl('admin/FieldsGlobal',['modelName' => $modelName]));//,'id'=>$model->id));
        }

        $this->render('/fields/create',array(
            'model'=>$model
        ));
    }

    public function actionFieldUpdateGlobal($id)
    {
        $model = Fields::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
        
        if(isset($_POST['Fields']))
        {
            $model->attributes = $_POST['Fields'];
            if($model->save())
                $this->redirect($this -> createUrl('admin/FieldsGlobal',['modelName' => Objects::model() -> getName($model -> object_type)]));//,'id'=>$model->id));
        }
        $this->render('/fields/update',array(
            'model'=>$model,
        ));
    }

    public function actionFieldDeleteGlobal($id)
    {
        $model = Fields::model()->findByPk($id);
        $modelName = Objects::model() -> getName($model -> object_type);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])) {
            if (isset($_POST['returnUrl'])) {
                $this->redirect($_POST['returnUrl']);
            } else {
                $this -> redirect('admin/FieldsGlobal',['modelName' => $modelName]);
            }
        }
    }

    /* DEFAULT ACTIONS */
    public function actionIndex()
    {
        $this->render('view');


//        $trigger = Triggers::model() -> findByPk(17);
//        foreach ($trigger -> trigger_values as $v) {
//            echo $v -> id. " ". $v -> value. " ". $v -> verbiage ."<br/>";
//        }


        //васька 59.942525, 30.278247
        //март 59.941344, 30.257154
//        echo DistanceSpherical(30.278247, 59.942525,30.257154,59.941344);
//        $a = Article::model() -> findByPk(3);
//        //$a -> text = "<search:nameOne>";
//        echo $a -> prepareText(['search' => 2]);
    }

    public function actionfileUpload()
    { 
        //$this->layout='';
        //header('Content-type: application/json');
        if ($_FILES)
        {
            if(!empty($_FILES['fileUploded'])){
                $filePath = Yii::app()->basePath.'/../images/' . basename($_FILES['fileUploaded']['name']);
        
                if (move_uploaded_file($_FILES['fileUploaded']['tmp_name'], $filePath)) {
                    Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
                    return false;
                }
            }
        }
            
        else            
            echo '<form method="post" id="fileUpload" enctype="multipart/form-data">
                  <input type="file" name="fileUploaded" id="fileUploaded"> <br/>
                  <input type="submit" id="submitUpload">
                  </form>
                     
                  ';
         return true;
    }
	
	public function actionImportCsv($modelName) {
		//Задаем имя файлу на сервере
		$csv_filePath = Yii::app()->basePath.'/../files/'.$modelName.'.csv' ;
		//Пытаемся вытащить из временных загруженный файл
		if (move_uploaded_file($_FILES[$modelName.'_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		$reader = new CsvReader($csv_filePath);
		//Создаем csv-reader
		if ($reader -> file) {
			//Задаем параметры ридера
			$reader -> separator = ';';
			$reader -> exportFileEncoding = 'utf-8';
			//Если открытие файла удачно, то сохраняем заголовок и продолжаем.
			$header = $reader -> saveHeader();
			//print_r($header);
			while($line = $reader -> line()) {
				$modelName::model() -> modelFromImportArray($line, $header);
				/*if ($count > 1) {
					break;
				}
				$count ++;
				echo "<br/><br/><br/>";*/
			}
			Yii::app() -> end();
		}
		
		
	}
	/*public function actionImportCsv($modelName)
	{
		$csv_filePath = Yii::app()->basePath.'/../files/'.$modelName.'.csv' ;
        
        if (move_uploaded_file($_FILES[$modelName.'_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		
		$handle=fopen($csv_filePath, "r");
		
		if ($handle)
		{
			$attrName = $modelName.'Fields';
			$attrName2 = $modelName.'Prices';
			$modelName::model() -> ImportCsv($handle, $this -> $attrName, $this -> $attrName2);
			fclose($handle);
		}
		$this->redirect($modelName);
	}*/
	/*public function actionImportCsv($modelName)
	{
		$csv_filePath = Yii::app()->basePath.'/../files/clinics.csv' ;
        
        if (move_uploaded_file($_FILES['clinics_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		
		$handle=fopen($csv_filePath, "r");
		
		if ($handle)
		{
			clinics::model() -> ImportCsv($handle, $this -> fields);
			fclose($handle);
		}
		$this->redirect('clinics');
	}*/
	/*
	* Export objects in a csv file.
	* $<modelName>Fields array specifies which fields are to be exported. 
	* Every key of the array equals to the table field, while the value is the text that is to be shown to users in the exported file.
	*/
	public function actionExportCsv($modelName)
	{
		$attrName = $modelName.'Fields';
		$attrName2 = $modelName.'Prices';
		$modelName::model() -> ExportCsv($this -> $attrName, $this -> $attrName2);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']); //notsafe()->
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	public function disableProfilers()
    {
        if (Yii::app()->getComponent('log')) {
            foreach (Yii::app()->getComponent('log')->routes as $route) {
                if (in_array(get_class($route), array('CProfileLogRoute', 'CWebLogRoute', 'YiiDebugToolbarRoute','DbProfileLogRoute'))) {
                    $route->enabled = false;
                }
            }
        }
    }
    public function actionGoogleDoc() {
        $api = new GoogleDocApiHelper();

        if ($api -> success) {
            $api -> setDefaultWorkArea();
            /*var_dump($api -> giveData() -> getEntries());
            echo "good";*/
            clinics::importFromGoogleDoc($api);
            $f = new CustomFlash();
            $html = $f -> showAll();
            if (!$html) {
                $this -> redirect(array('admin/clinics'));
            }
            echo "Обнаружены ошибки. Их список можно увидеть ниже. ".CHtml::link('Перейти к админке', '//admin/clinics');
            echo $html;
        }
    }
    /*public function actionDownloadImages(){
        $xml = file_get_contents('http://o-mri.ru.clinics.s3.amazonaws.com/');
        $obj = new SimpleXMLElement($xml);
        //var_dump($obj);
        $verb = function($str){
            $matches = array();
            $rez = preg_replace('/(\.jpg)|(\.JPG)/','',$str);
            //preg_replace("/.*?\./", '', 'photo.jpg');
            return $rez;
        };

        $download = function ($url, $target) {
            if(!$hfile = fopen($target, "w"))return false;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FILE, $hfile);

            if(!curl_exec($ch)){
                curl_close($ch);
                fclose($hfile);
                unlink($target);
                return false;
            }

            fflush($hfile);
            fclose($hfile);
            curl_close($ch);
            return true;
        };
        $baseUrl = 'http://o-mri.ru.clinics.s3.amazonaws.com';

        //$imageName = '1mrt.jpg';
        //$download($urlbase.$imageName, Yii::getPathOfAlias('webroot.images').'/'.$imageName);
        //Yii::app() -> end();
        foreach ($obj -> Contents as $image) {
            if ($clinic = clinics::model() -> findByAttributes(array('verbiage' => $verb($image -> Key)))) {
                $images_filePath = $clinic -> giveImageFolderAbsoluteUrl();
                if (!file_exists($images_filePath))
                {
                    mkdir($images_filePath);
                }
                $fileName = $images_filePath.'/'.$image -> Key;

                if (file_exists($fileName)) {
                    unlink($fileName);
                    $deleted ++;
                }

                if ($download($baseUrl.'/'.$image -> Key, $images_filePath.'/'.$image -> Key)) {
                //if ($download($baseUrl.'/'.$image -> Key, Yii::getPathOfAlias('webroot.images').'/'.$image -> Key)) {
                    $clinic -> logo = $image -> Key;
                    $clinic -> save();
                    $d ++;
                } else {
                    $nd ++;
                }
            } else {
                $nf ++;
            }

        }
        echo "Uploaded: $d, not uploaded: $nd, not found: $nf, deleted: $deleted";
    }
    public function actionDownloadAllImages(){
        $xml = file_get_contents('http://o-mri.ru.clinics.s3.amazonaws.com/');
        $obj = new SimpleXMLElement($xml);
        $download = function ($url, $target) {
            if(!$hfile = fopen($target, "w"))return false;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FILE, $hfile);

            if(!curl_exec($ch)){
                curl_close($ch);
                fclose($hfile);
                unlink($target);
                return false;
            }

            fflush($hfile);
            fclose($hfile);
            curl_close($ch);
            return true;
        };
        $verb = function($str){
            $matches = array();
            $rez = preg_replace('/(\.jpg)|(\.JPG)/','',$str);
            //preg_replace("/.*?\./", '', 'photo.jpg');
            return $rez;
        };
        $baseUrl = 'http://o-mri.ru.clinics.s3.amazonaws.com';
        foreach ($obj -> Contents as $image) {
            echo $image -> Key;

            echo Yii::getPathOfAlias('webroot.images.allimages').'\\'.$image -> Key;
            if ($download($baseUrl.'/'.$image -> Key, Yii::getPathOfAlias('webroot.images.allimages').'/'.$image -> Key)) {
                $d++;
            } else {
                $nd++;
            }
        }
        echo "downloaded: $d, not downloaded: $nd";
    }*/
    public function redirectHome(){
        $this -> redirect('admin/index');
    }
    public function actionAjaxGetParents() {
        $level = (int) $_POST['Article']['level'];
        echo Article::model() -> GenerateParentList($level - 1);
    }
    /**
     * Ajax action that returns children info by the given task id
     */
    public function actionGiveArticleChildren(){
        $data = $_GET;
        if ($data['id']) {
            $model = Article::model()->findByPk($data['id']);
            $models = $model -> giveChildren();
        } else {
            $models = array_merge(Article::model() -> root() -> findAll(), Article::model() -> uncategorized() -> findAll());
        }
        echo json_encode(UHtml::giveArrayFromModels($models,function($el){
            /**
             * @type Task $el
             */
            return $el -> dumpForProject();
        }), JSON_PRETTY_PRINT);
    }
//    public function actionLoadDistricts(){
//        foreach (Districts::model() -> findAll() as $d) {
//            $val = new TriggerValues();
//            $val -> verbiage = str2url($d -> name);
//            $val -> value = $d -> name;
//            $val -> trigger_id = 7;
//            if (!$val -> save()) {
//                var_dump($val -> getErrors());
//                continue;
//            }
//            $dep = new TriggerValueDependency();
//            $dep -> verbiage_child = $val -> verbiage;
//            $dep -> verbiage_parent = 'spb';
//            if (!$dep -> save()) {
//                var_dump($dep -> getErrors());
//            }
//        }
//    }
//    public function actionParseStreets() {
//        $empty = [];
//        $select = Triggers::model() -> findByAttributes(['verbiage' => 'district']) -> getHtml($empty, [], ['noChildren' => true]);
//        echo "<form method='post'>
//<textarea name='str'></textarea>
//<input type='submit' value='распарсить' name='go'>$select
//</form>";
//
//        $data = $_POST;
//        if ($data['go']) {
//            $str = $data['str'];
//            $str = strip_tags($str,'<td>');
//            $str = substr($str,4);
//            $str = substr($str,0,-5);
//            $streets = explode('</td><td>',$str);
//            sort($streets);
//            var_dump($streets);
//            $i = 0;
//            $inDatabase = TriggerValueDependency::model() -> findByAttributes(['verbiage_parent'=>$data['district']]);
//            if (!$inDatabase) {
//                foreach ($streets as $street) {
//                    $val = new TriggerValues();
//                    $val -> value = $street;
//                    $val -> verbiage = str2url($street);
//                    $val -> trigger_id = 8;
//                    if (!$val -> save()) {
//                        var_dump($val -> getErrors());
//                        continue;
//                    }
//                    $dep = new TriggerValueDependency();
//                    $dep -> verbiage_child = $val -> verbiage;
//                    $dep -> verbiage_parent = $data['district'];
//                    if (!$dep -> save()) {
//                        var_dump($dep -> getErrors());
//                        continue;
//                    }
//
//                    echo "Saved: $i ".$val -> verbiage." to ".$dep -> verbiage_parent."<br/>".PHP_EOL;
//                    $i ++;
//                }
//            } else {
//                echo $data['district']." already has dependencies!";
//            }
//        }
//    }
    private function findObject($id, $modelName, $scenario = null){
        $model = $modelName::model();
        $model -> setScenario($scenario);
        $model = $model -> customFind($id);
        $model -> setScenario($scenario);
        if (!$model) {
            throw new Exception("Could not find $modelName object by id $id");
        }
        return $model;
    }
    public function actionObjectCommentDelete($id, $modelName, $idComment){
        $model = $this -> findObject($id,$modelName, 'comments');
        $commentsMod = $this -> getModule() -> getObjectsReviewsPool(get_class($model));
        $modelComment = $commentsMod -> getComment($idComment);
        $commentsMod -> deleteComment($modelComment);
    }
    public function actionObjectCommentUpdate($id, $modelName, $idComment){
        $data = $_POST;
        /**
         * @type clinics|doctors $model
         */
        $model = $this -> findObject($id,$modelName, 'comments');
        $commentsMod = $this -> getModule() -> getObjectsReviewsPool(get_class($model));
        $modelComment = $commentsMod -> getComment($idComment);
        if ($data['submit']) {
            $modelData = $data['Comment'];
            /**
             * @type VKCommentsModule $commentsMod
             */
            $modelComment = $commentsMod -> updateComment($modelComment,$model -> id, $modelData['text'],$modelData);
            if (empty($modelComment -> getErrors())) {
                $this -> redirect($this -> createUrl('admin/objectCommentsList',['modelName' => get_class($model), 'id' => $model -> id]));
            } else {
                $err = $modelComment -> getErrors();
            }
        }
        $form = $commentsMod -> commentForm($modelComment);
        $this -> render('/comments/_update',['model' => $model, 'form' => $form]);
    }
    public function actionObjectCommentCreate($id, $modelName){
        $data = $_POST;
        /**
         * @type clinics|doctors $model
         */
        $model = $this -> findObject($id,$modelName, 'comments');
        $commentsMod = $this -> getModule() -> getObjectsReviewsPool(get_class($model));
        $saved = null;
        if ($data['submit']) {
            $modelData = $data['Comment'];
            /**
             * @type VKCommentsModule $commentsMod
             */
            $saved = $commentsMod -> addComment($model -> id, $modelData['text'],$modelData);
            if (empty($saved -> getErrors())) {
                $this -> redirect($this -> createUrl('admin/objectCommentsList',['modelName' => get_class($model),'id' => $model -> id]));
            } else {
                $err = $saved -> getErrors();
            }
        }
        $form = $commentsMod -> commentForm($saved);
        $this -> render('/comments/_create',['model' => $model, 'form' => $form]);
    }
    public function actionParseDistricts() {
        echo "<form method='post'>
        <textarea name='str'></textarea>
        <input type='submit' value='распарсить' name='go'>
        </form>";
        $data = $_POST;
        if ($data['go']) {
            $arr = preg_split('~\<[/]option\>\<option[^\>]*\>~ui',$data['str']);
            $i = 0;
            foreach ($arr as $dName) {
                $dName = trim($dName);
                $obj = new TriggerValues();
                $obj -> value = $dName;
                $obj -> verbiage = str2url($dName);
                $obj -> trigger_id = 7;
                if ($obj -> save()) {
                    $dep = new TriggerValueDependency();
                    $dep -> verbiage_parent = 'mscCity';
                    $dep -> verbiage_child = $obj -> verbiage;
                    $dep -> save();
                    $i++;
                } else {
                    echo "Could not save $dName with verbiage {$obj->verbiage}<br/>";
                }
            }
            echo "saved $i";
        }
    }
    public function actionParseMetroCoords() {
        echo "<form method='post'>
        <textarea name='str'></textarea>
        <input type='submit' value='распарсить метро' name='go'>
        </form>";
        $data = $_POST;
        if ($data['go']) {
            $str = $data['str'];
            $obj = json_decode($str) -> data;
            $obj = json_decode(end($obj)->data) -> stations;
            $names = [];
            $i = 1;
            foreach ($obj as $station) {
                //echo $station -> name.'<br/>';
                $names[] = $station -> name;
                if (!Metro::model() -> findByAttributes(['name' => $station -> name])) {
                    echo "$i ".$station -> name. " not found <br/>";
                    $i++;
                }
            }
        }
    }
//    public function actionParseMetroCoords() {
//        $empty = [];
//        echo "<form method='post'>
//<textarea name='str'></textarea>
//<input type='submit' value='распарсить' name='go'>
//</form>";
//
//        $data = $_POST;
//        $data['go'] = 1;
//        if ($data['go']) {
//            $str = $data['str'];
//            require_once(Yii::getPathOfAlias('application.components.simple_html_dom') . '.php');
////            $html = str_get_html($str);
////            $metros = $html -> find('.list-name');
////            $str = strip_tags($str,'<tr><td>');
////            $str = str_replace('</tr>','',$str);
////            $str = preg_replace('[\r\n]','',$str);
////            $str = preg_replace('/\W*<\/td>\W*<td>\W*/ui',';',$str);
////            $arrs = explode('<tr>',$str);
//            $i = 0;
//            $c = new CDbCriteria();
//            $c -> compare('city','msc');
//            $c -> addCondition('latitude IS NULL');
//            $metros = Metro::model() -> findAll($c);
//            foreach ($metros as $m) {
//                $m -> name = trim($m -> name);
//                $n = $m -> name;
//                $id = $m -> id;
//                $rez = getCoordinates('Москва, станция метро '.$m -> name);
//                $m -> latitude = (float)$rez['lat'];
//                $m -> longitude = (float)$rez['long'];
//                $m -> save();
////                return;
//            }
////            foreach ($metros as $dom) {
////                $name = trim(strip_tags($dom -> innerText()));
////                $nameNew = preg_replace('/\d{4}\W*год$/ui','',$name);
////                if ($name != $nameNew) {
////                    echo 'replaced';
////                }
////                $m = new Metro();
////                $m -> name = $nameNew;
////                $m -> city = 'msc';
////                if (($m -> save())&&((!$m -> latitude)||(!$m -> longitude))) {
////                    $rez = getCoordinates('Москва, станция метро '.$nameNew);
////                    $m -> latitude = $rez['lat'];
////                    $m -> longitude = $rez['long'];
////                    $m -> save();
////                    $i ++;
////                } else {
////                    var_dump($m -> getErrors());
////                }
////            }
////            foreach ($arrs as $arrString) {
////                $arrString = preg_replace('~\W*</?td>\W*~ui','',$arrString);
////                $arr = explode(';',$arrString);
////                var_dump($arr);
////                $m = new Metro();
////                $m -> name = $arr[0];
////                $m -> city = 'msc';
////                if ($m instanceof Metro) {
////                    $m -> longitude = $arr[2];
////                    $m -> latitude = $arr[1];
////                    if ($m -> save()) {
////                        $i ++;
////                    }
////                }
////            }
//            echo "Сохранено $i станций";
//            //$inDatabase = TriggerValueDependency::model() -> findByAttributes(['verbiage_parent'=>$data['district']]);
////            if (!$inDatabase) {
////                foreach ($streets as $street) {
////                    $val = new TriggerValues();
////                    $val -> value = $street;
////                    $val -> verbiage = str2url($street);
////                    $val -> trigger_id = 8;
////                    if (!$val -> save()) {
////                        var_dump($val -> getErrors());
////                        continue;
////                    }
////                    $dep = new TriggerValueDependency();
////                    $dep -> verbiage_child = $val -> verbiage;
////                    $dep -> verbiage_parent = $data['district'];
////                    if (!$dep -> save()) {
////                        var_dump($dep -> getErrors());
////                        continue;
////                    }
////
////                    echo "Saved: $i ".$val -> verbiage." to ".$dep -> verbiage_parent."<br/>".PHP_EOL;
////                    $i ++;
////                }
////            } else {
////                echo $data['district']." already has dependencies!";
////            }
//        }
//    }
    public function actionReloadCoordinates(){
        foreach($this -> getModule() -> getClinics($_GET) as $c){
            /**
             * @type clinics $c
             */
            $c -> parseCoords();
            $c -> setScenario('noPrices');
            if(!$c -> save()){
                echo $c->verbiage." ".$c->id.":<br/>";
                var_dump($c -> getErrors());
            }
        }
    }
    public function actionReloadDistricts(){
        $i = 0;
        foreach($this -> getModule() -> getClinics($_GET) as $c){
            $i++;
            /**
             * @type clinics $c
             */
            $toDelete = CHtml::giveAttributeArray($c -> giveTriggerValuesObjects()['district'],'id');
            $had = explode(';',$c -> triggers);
            $save = array_filter($had,function($val) use ($toDelete) {
                return !in_array($val, $toDelete);
            });
            $c -> triggers = implode(';',$save);
            $c -> parseDistricts();
            $c -> setScenario('noPrices');
            if(!$c -> save()){
                echo $c->verbiage." ".$c->id.":<br/>";
                var_dump($c -> getErrors());
            } else {
                echo $c->name."<br/>";
            }
            if (($i > $_GET['limit'])&&($_GET['limit'])) {
                break;
            }
        }
    }
    public function actionReloadMetros(){
        //foreach($this -> getModule() -> getClinics(['area'=>'msc']) as $c){
        foreach($this -> getModule() -> getClinics($_GET) as $c){
            /**
             * @type clinics $c
             */
            $c -> setScenario('noPrices');
            $c -> parseMetros();
            if(!$c -> save()){
                echo $c->verbiage." ".$c->id.":<br/>";
                var_dump($c -> getErrors());
            }
        }
    }
    public function actionParseSites(){
        require_once(Yii::getPathOfAlias('application.components.simple_html_dom') . '.php');
        foreach (clinics::model() -> findAll() as $clinic) {
            /**
             * @type simple_html_dom $html
             */
            if (!$clinic->external_link) {
                echo $clinic->name." no link!<br/>";
                continue;
            }
            try {
                @$html = file_get_html($clinic->external_link);
            } catch(Exception $e) {
                continue;
            }
            $string = (string)current($html -> find('.dl-horizontal'));
            $pos = strpos($string,'Сайт');
            if ($pos !== false) {
                $string = substr($string, $pos);
                $string = strip_tags('<dt>'.$string,'<dd>');
                $html2 = str_get_html($string);
                $site = current($html2 -> find('dd')) -> innerText();
                $clinic -> site = $site;
                $clinic -> setScenario('noPrices');
                $clinic -> save();
                echo $clinic -> name . ' ' . $site.'<br/>';
            }
        }
    }
    public function actionLoadAO(){
        $trigger = Triggers::model() -> findByPk(18);
        $mod = Yii::app() -> getModule('clinics');
        /**
         * @type ClinicsModule $mod
         * @type TriggerValues $ao
         */
        foreach ($trigger -> trigger_values as $ao) {
            echo $ao -> value.":<br/>";
            foreach ($ao -> dependencies as $dep) {
                $distr = $dep->parent;
                foreach ($mod->getClinics(['district' => $distr->verbiage]) as $c) {
                    //echo $c->name . " " . $c->triggers;
                    $c->addTriggerValue($ao -> id);
                    //echo " ".$c -> triggers."<br/>";
                    $c -> setScenario('noPrices');
                    $c -> save();
                }
            }
        }
    }
    public function actionParseMoscowStreets(){
        require_once(Yii::getPathOfAlias('application.components.simple_html_dom') . '.php');
        $districts = TriggerValues::model() -> findAllByAttributes(['trigger_id' => 7]);
        $distrs = [];
        foreach ($districts as $d) {
            if (current($d -> dependencies) -> parent -> verbiage == 'msc') {
                $distrs[mb_strtolower($d -> value)] = $d;
            }
        }
        $distrs['савёлки'] = $distrs['савёловский'];
        $distrs['хорошёво-мневники'] = $distrs['хорошёво-мнёвники'];
//        var_dump($distrs);
        $url = "http://mosopen.ru/streets";
        function curlGetUrl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $page = curl_exec($ch);
            curl_close($ch);
            return $page;
        }
        $page = curlGetUrl($url);
        $page = substr($page,strpos($page,'<table class='));
        $page = substr($page,0,strpos($page,'<div id="regions_by_dis'));
        $page = strip_tags($page,'<a>');
        //$html = str_get_html($page);
//        echo $page;
        preg_match_all('/(https?|ftp|telnet):\/\/((?:[a-z0-9@:.-]|%[0-9A-F]{2}){3,})(?::(\d+))?((?:\/(?:[a-z0-9-._~!$&\'()*+,;=:@]|%[0-9A-F]{2})*)*)(?:\?((?:[a-z0-9-._~!$&\'()*+,;=:\/?@]|%[0-9A-F]{2})*))?(?:#((?:[a-z0-9-._~!$&\'()*+,;=:\/?@]|%[0-9A-F]{2})*))?/i',$page, $matches);
//        var_dump($matches);
        foreach ($matches[0] as $m) {
            $string = curlGetUrl($m);
            $string = substr($string,strpos($string,'context_top'));

            $heading = substr($string,strpos($string,'<h1>'));
            $heading = substr($heading,0,strpos($string,'/h1>'));
            $html = str_get_html($heading);
            if ($html) {
                $distrName = current($html->find('h1'))->plaintext;
            } else {
                echo "Error in ".$heading;
            }
            $distrName = trim(mb_strtolower(str_replace(['район',"Район"],'',$distrName)));

            if ($distrs[$distrName]) {
                $this -> parseStreetsForDistrict($distrs[$distrName], $string);
                $found ++;
            } else {
                $notFound ++;
                echo "<p>Not found: ".$distrName."</p>";
            }
            //
            echo $distrName;
            break;
        }
        echo "<p>Found: $found and not found $notFound</p>";
        //var_dump($page);
    }
    public function parseStreetsForDistrict(TriggerValues $district, $string){
        $string = substr($string,strpos($string,'<div class="double_block clearfix">'));
        $string = substr($string,0,strpos($string,'<div class="separator">'));
        //$string = substr($string,0,strpos($string,''));
        $string = strip_tags($string,'<a>');
        $html = str_get_html('<html><body>'.$string.'</body></html>');
        foreach ($html -> find('a') as $link) {
            $val = new TriggerValues();
            $val -> value = $link -> plaintext;
            $val -> verbiage = str2url($val -> value);
            $val -> trigger_id = 8;
            $saved = false;
            if (!$val -> save()) {
                $val -> verbiage = $val -> verbiage . '2';
                $saved = true;
            }
            if ($saved || $val -> save()) {
                $dep = new TriggerValueDependency();
                $dep -> verbiage_child = $val -> verbiage;
                $dep -> verbiage_parent = $district -> verbiage;
                $dep -> save();
            }
            var_dump($val -> getErrors());
        }
        echo "<br/>";
    }
    public function actionReloadPrices(){
        $clinic = clinics::model() -> findByAttributes(['verbiage' => 'medem']);
        $clinic -> savePrices();
        $clinic = clinics::model() -> findByAttributes(['verbiage' => 'szmed']);
        $clinic -> savePrices();

//        foreach($this -> getModule() -> getClinics($_GET) as $c){
//            /**
//             * @type clinics $c
//             */
//            echo "<strong>$c->name</strong><br/>";
//            //$c -> setScenario('noPrices');
//            $c -> savePrices();
//        }
    }
}