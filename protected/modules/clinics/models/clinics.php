<?php

/**
 * This is the model class for table "{{clinics}}" - it describes a standard Clinic
 *
 * The followings are the available columns in table '{{clinics}}':
 * @property integer $id
 * @property string $name
 * @property string $verbiage
 * @property string $phone
 * @property string $phone_extra
 * @property string $fax
 * @property string $email
 * @property string $address
 * @property string $address_extra
 * @property string $city
 * @property integer $district
 * @property integer $metro_station
 * @property string $working_days
 * @property string $working_hours
 * @property string $restrictions
 * @property string $services
 * @property double $rating
 * @property string $logo
 * @property string $triggers
 * @property string $pictures
 * @property string $map_coordinates
 * @property string $text
 * @property string $audio
 * @property string $video
 * @property string $keywords
 * @property string $description
 * @property string $sales
 * @property bool $partner
 * @property bool $ignore_clinic
 * @property bool $showIndividualNumber
 * @property string $path
 *
 *
 *
 * @property doctors[] $doctors
 *
 */
 
class clinics extends BaseModel {
	public static $createService = true;
    public $districts_display;
    public $triggers_display;
	public $additional;
	/**
	 * @var array doctorsInput - an array of doctor ids that are to be linked to this clinic
	 */
	public $doctorsInput;
	/**
	 * @var string encoding of export|import file
	 */
	public $exportFileEncoding = 'windows-1251';
	/**
	 * @var string encoding of file with the code
	 */
	public $codeFileEncoding = 'utf-8';
    protected $_DistrNames;
    protected $_SubwayNames;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {

		return '{{clinics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {

		return array(
			array('name, verbiage', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('rating, experience', 'numerical'),
			array('name', 'length', 'max'=>500),
            array('site', 'length', 'max'=>1000),
            array('logo', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1048576, 'allowEmpty'=>true),
            array('audio', 'file', 'types'=>'mp3', 'maxSize' => 209715200, 'allowEmpty'=>true),
            array('district, metro_station, phone, fax, triggers, map_coordinates, keywords, description', 'length', 'max'=>2000),
			array('verbiage, address, working_days, working_hours, video, title', 'length', 'max'=>255),
			array('*', 'safe'),
			array('id, name, verbiage, phone, phone_extra, fax, address, address_extra, site, district, metro_station, working_days, working_hours, services, rating, triggers, map_coordinates, text, audio, video, title, keywords, description, experience, partner', 'safe', 'on'=>'search'),
			array('doctorsInput, mrt, kt, external_link, restrictions, path, sales, showIndividualNumber', 'safe')
		);
	}
	protected function instantiate($attributes) {
		$serv = ['service','servicespb','servicemsc'];
		if (in_array($attributes['verbiage'],$serv)&&(self::$createService)) {
			return new Service(null);
		}
		return new clinics(null);
	}
    /**
     * @return array relational rules.
     */
     
    public function relations() {

        return parent::relations() + array(
            //'comments' => array(self::HAS_MANY, 'Comments', 'object_id', 'condition' => 'comments.object_type = '.Objects::model() -> getNumber(get_class($this))),
            //'approved_comments' => array(self::HAS_MANY, 'Comments', 'object_id','order'=> 'id DESC', 'condition' => 'approved_comments.object_type = '.Objects::model() -> getNumber(get_class($this)).' AND approved_comments.approved=1'),
            //'clinicfields' => array(self::HAS_MANY, 'ObjectsFields', 'object_id', 'with' => 'field'),
            'fields' => array(self::HAS_MANY, 'FieldsValue', 'object_id', 'with' => 'field','condition' => 'field.object_type = '.Objects::model() -> getNumber(get_class($this))),
			'doctors' => array(self::MANY_MANY, 'doctors', '{{employments}}(id_clinic, id_doctor)')
        );
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {

		return array(
			'id' => 'ID',
			'name' => CHtml::encode('Имя'),
            'verbiage' => CHtml::encode('Имя в URL'),
			'phone' => CHtml::encode('Телефон'),
			'fax' => CHtml::encode('Факс'),
			'address' => CHtml::encode('Адрес'),
            'site' => CHtml::encode('Сайт'),
            'path' => CHtml::encode('Как добраться'),
            'district' => CHtml::encode('Район'),
			'metro_station' => CHtml::encode('Метро'),
			'working_days' => CHtml::encode('Рабочие дни'),
			'working_hours' => CHtml::encode('Рабочие часы'),
			'rating' => CHtml::encode('Рейтинг'),
			'logo' => CHtml::encode('Логотип'),
			'triggers' => CHtml::encode('Триггеры'),
			'pictures' => CHtml::encode('Изображения'),
			'map_coordinates' => CHtml::encode('Координаты на карте'),
			'text' => CHtml::encode('Описание'),
			'audio' => CHtml::encode('Аудиофайл'),
			'video' => CHtml::encode('Видеофайл'),
            'title' => CHtml::encode('Title'),
			'keywords' => CHtml::encode('Keywords'),
			'description' => CHtml::encode('Description'),
			'mrt' => CHtml::encode('Информация об МРТ аппаратуре (кратко, <br/> для переноса строки.)'),
			'kt' => CHtml::encode('Информация о КТ аппаратуре (кратко, <br/> для переноса строки.)'),
			'experience' => CHtml::encode('Существует (лет)'),
			'restrictions' => CHtml::encode('Ограничения')
		);
	}
    /** This is a standard search function (not in use)
     * 
     */
	public function search() {

		$criteria=new CDbCriteria;
		$criteria -> order = 'partner DESC';
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('address',$this->address,true);
        $criteria->compare('site',$this->site,true);
        $criteria->compare('district',$this->district);
		$criteria->compare('metro_station',$this->metro_station);
		$criteria->compare('working_days',$this->working_days,true);
		$criteria->compare('working_hours',$this->working_hours,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('triggers',$this->triggers,true);
		$criteria->compare('pictures',$this->pictures,true);
		$criteria->compare('map_coordinates',$this->map_coordinates,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('audio',$this->audio,true);
		$criteria->compare('video',$this->video,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('description',$this->description,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination' => false,
		));
	}//*/

    // this is standard function for getting a model of the current class
	public static function model($className=__CLASS__) {

		return parent::model($className);
	}
	/** Function to determine which attribute will be used to name file folder.
	*
	*/
	public function FolderKey() {

		return 'verbiage';
	}
	
	/**
	*  EVENT HANDLERS
	*/
	
	/**
	* Function to be called after $model -> save() methods succeeds
	*/
	public function afterSave() {

		
		parent::afterSave();
		//Сохраняем изменения в массиве докторов
		//print_r($this -> doctorsInput);
		//echo "mbvnbv";
		//new CustomFlash("warning", 'Clinics', 'check', count($this -> doctorsInput), true);
		if (!isset($this -> doctorsInput)) {
			$this -> doctorsInput = array();
		}
		$this -> SavePropertyArrayChanges($this -> doctorsInput, 'Employment', 'doctors', 'id', 'id_clinic', 'id', 'id_doctor');

		//Если у модели клиники определены какие-то значения дополнительных полей, то сохраняем их.
		if (isset($this -> additional)) {

			foreach ($this -> additional as $id => $value) {

				$current_field = FieldsValue::model()->findByPk(trim($id));
				$current_field -> value = $value;
				if (!$current_field -> save()) {
					new CustomFlash("error", 'ClinicFields', 'SaveField_id_'.$id, 'Не удалось сохранить поле клиники с id '.$id, true) ;
					//echo "error_field".$id;
				}
			}
		}
	}
	
	
	/**
	* Getters and Setters
	*/
	
	/**
	* CUSTOM FUNCTIONS
	*/
	
	
	
	public function ReadData(){}
	
	public function FillFieldsFromArray($model, $post_arr) {
		$model->attributes=$post_arr[get_class($this)];
		$model -> text = $post_arr[get_class($this)]['text'];
		//print_r($post_arr[get_class($this)]);
		$model -> partner = $post_arr[get_class($this)]["partner"] > 0 ? 1 : 0;
		$model -> ignore_clinic = $post_arr[get_class($this)]["ignore_clinic"] > 0 ? 1 : 0;
		//metro
		if (!empty($post_arr['metro_station_array'])) {
			$metro = implode(';', $post_arr['metro_station_array']);
			$model->metro_station = $metro; //substr($metro, 0, strrpos($metro, ';'));
		} else {
			$model -> metro_station = '';
		}

		//districts
		if (!empty($post_arr['district_array'])) {
			$district = implode(';', $post_arr['district_array']);
			$model->district = $district;//substr($district, 0, strrpos($district, ';'));
		} else {
			$model -> district = '';
		}

		//triggers
		if (!empty($post_arr['triggers_array'])) {
			$triggers = implode(';', $post_arr['triggers_array']);
			$model->triggers = $triggers;//substr($triggers, 0, strrpos($triggers, ';'));
		} else {
			$model -> triggers = '';
		}
		//additional fields
		if (isset($post_arr[get_class($this)]['Additional']) && !empty($post_arr[get_class($this)]['Additional'])) {
			$model -> additional = $post_arr[get_class($this)]['Additional'];
		}
	}
	/** Function that saves files to corresponding folders and updates model's file data.
	* it also tries to delete previous files if they exist.
	*/
	public function FilesOperationsFromArray($model, $files_arr) {
		// logo and audio
		
		$files_filePath = $model -> giveFileFolderAbsoluteUrl(NULL, 'files');
		if (!file_exists($files_filePath)) {

			@mkdir($files_filePath);
		}
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		if (!file_exists($images_filePath)) {

			@mkdir($images_filePath);
		}
		if(!empty($files_arr[get_class($this)]['name']['logo'])){
			$logo_old = $model->logo;
			$model->logo = CUploadedFile::getInstance($model,'logo');
			$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
			$fileName = $images_filePath . $image_unique_id;

			if ($model->validate()) {
				$model->logo->saveAs($fileName);
				$model->logo = $image_unique_id;
				if (strlen($logo_old) > 0) @unlink ($images_filePath. DIRECTORY_SEPARATOR .$logo_old);
			}
			else
				$model->logo = $logo_old;
		}

		if(!empty($files_arr[get_class($this)]['name']['audio'])) {
			$audio_old = $model->audio;
			$model->audio = CUploadedFile::getInstance($model,'audio');
			//$fileName = Yii::app()->basePath.'/../files/clinics/'.$model->id . '/' . $model->audio;
			$fileName = $files_filePath . $model->audio;
			if ($model->validate())
				$model->audio->saveAs($fileName);
			if (strlen($audio_old) > 0) @unlink ($files_filePath. DIRECTORY_SEPARATOR .$audio_old);
			else
				$model->audio = $audio_old;

		} 
		if(!empty($files_arr['images'])){
			$images_old = (trim($model->pictures) == '')? '': $model->pictures . ';'; 
			
			$pictures = '';
			$images = CUploadedFile::getInstancesByName('images');
			if ($model->validate()){
				foreach($images as $image) {
					$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$image->extensionName;
					$fileName = $images_filePath . $image_unique_id;
					$image->saveAs($fileName);
					$pictures .= $image_unique_id . ';';
				}                     
				$pictures_all = $images_old . $pictures;   
				$model->pictures = substr($pictures_all, 0, strrpos($pictures_all, ';'));
			} else {
				$model->pictures = $images_old;
			}
		}
	}
	public function giveSubwayNames($data = '') {

		if (strlen($data) == 0) {

			$data = $this -> metro_station;
		}
		$subway_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $subway_ids);
		return array_values(CHtml::listData(Metro::model()->findAll($criteria), 'id','name'));//костыль. переписать

	}
	public function giveDistrNames($data = '') {
		if (strlen($data == 0)) {

			$data = $this -> district;
		}
		$distr_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $distr_ids);
		return array_values(CHtml::listData(Districts::model()->findAll($criteria), 'id','name'));//костыль. переписать
	}
	public function modelFromImportArray($array, $header = array()){
		$model = new self;
		if (!empty($array)) {
			if (!empty($header)) {
				$enc = 'utf-8';
				$key = array_flip(array_map(function ($key) use ($enc) {
					return (mb_strtolower(trim($key),$enc));
				},$header));
				$model -> name = $array[$key['название']];
				//Название почему-то не хочет выбираться.
				//$model -> name = $array[0];
				
				$model -> site = $array[$key['сайт']];
				$model -> verbiage = $array[$key['код']];
				
				//Если эта клиника уже есть в базе, то выходим.
				if ($model -> findByAttributes(array('verbiage' => $model -> verbiage))) {
					return;
				}
				
				$model -> address = $array[$key['адрес']];
				
				$distr_ids = $model -> giveDistrictIdsByNameString($array[$key['район']]);
				$model -> district = implode(';', $distr_ids);
				
				$model -> phone = $array[$key['телефон']];
				
				$model -> email = $array[$key['email']];
				
				$model -> mrt = $array[$key['модель мрт']];
				
				$model -> kt = $array[$key['модель кт']];
				
				$model -> working_hours = $array[$key['часы работы']];
				$toAddPrices = array();
				$toAddPrices['МРТ головного мозга'] = $array[$key['цена мрт головного мозга']];
				$toAddPrices['МРТ Поясничного отдела позвоночника'] = $array[$key['цена мрт поп']];
				$toAddPrices['МРТ шейного отдела позвоночника'] = $array[$key['мрт шоп']];
				$toAddPrices['МРТ брюшно полости'] = $array[$key['цена мрт брюшной полости']];
				$toAddPrices['МРТ коленного сустава'] = $array[$key['цена мрт коленного сустава']];
				$toAddPrices['КТ грудной полости'] = $array[$key['цена кт грудной полости']];
				$toAddPrices['КТ головного мозга'] = $array[$key['цена кт головного мозга']];
				$toAddPrices['КТ поясничного отдела позвоночника'] = $array[$key['цена кт поп']];
				$toAddPrices['КТ сосудов головного мозга'] = $array[$key['цена кт сосудов головного мозга']];
				//echo $array[$key['цена мрт головного мозга']];
				
				//print_r($toAddPrices);
				//echo $array[$key['тригеры']];
				$temp = str_replace(' ',',',$array[$key['тригеры']]);
				$temp = str_replace('profy','Лучшие врачи', $temp);
				$temp = str_replace('kid','Детские исследования', $temp);
				$temp = str_replace('open','Открытый томограф', $temp);
				$temp = str_replace('ht','3тл', $temp);
				//echo $temp;
				$triggerString = $temp;
				if ($array[$key['мрт']] == 'да') {
					$triggerString .= ',МРТ';
				}
				if ($array[$key['кт']] == 'да') {
					$triggerString .= ',КТ';
				}
				if ($array[$key['узи']] == 'да') {
					$triggerString .= ',Узи';
				}
				if ($array[$key['маммография']] == 'да') {
					$triggerString .= ',Маммография';
				}
				if ($array[$key['пэт']] == 'да') {
					$triggerString .= ',пэт';
				}
				if ($array[$key['ангиография']] == 'да') {
					$triggerString .= ',Ангиография';
				}
				if ($array[$key['частная?']] == 'да') {
					$triggerString .= ',частная клиника';
				} else {
					$triggerString .= ',государственная клиника';
				}
				$trigger_ids = $this -> giveTriggersByNameString($triggerString);
				$model -> triggers = implode(';',$trigger_ids);
				//print_r($trigger_ids);
				//echo $triggerString;
				//Добавляем цены.
				/*foreach($toAddPrices as $priceName => $priceValue){
					$price = new Pricelist;
					$price -> object_type = Objects::model() -> getNumber(get_class($this));
					$price -> object_id = $object -> id;
					$price -> name = $priceName;
					$price -> price = $priceValue;
					if (!$price -> save()) {
						echo $price -> name." ".$price -> object_id." not saved<br/>";
					}
				}*/
				
				
				
				//Пробую сохранить.
				if ($model -> save()) {
					//Добавляем цены.
					foreach($toAddPrices as $priceName => $priceValue){
						$price = new Pricelist;
						$price -> object_type = Objects::model() -> getNumber(get_class($model));
						$price -> object_id = $model -> id;
						$price -> name = $priceName;
						$price -> price = $priceValue;
						if (!$price -> save()) {
							echo $price -> name." ".$price -> object_id." not saved<br/>";
							echo print_r($price -> getErrors());
						}
					}
					
				}
			}
		} else {
			return false;
		}
	}
	/**
	 * @param mixed[] $search a search array that specifies what is being searched
	 * @param CDbCriteria $criteria
	 * @param string $order
	 * @return CDbCriteria
	 */
	public function SFilter($search, $criteria, $order =''){
		$criteria = parent::SFilter($search, $criteria);
		if (($order)&&($search['research'])) {
			$sortArr = array('priceUp' => 'ASC','priceDown' => 'DESC');
			if ($modifier = $sortArr[$order]) {
				if ($criteria->order) {
					$criteria->order .= ", pr.value $modifier";
				} else {
					$criteria->order = "pr.value $modifier";
				}
			}
		}
		return $criteria;
	}
	/**
	 * @return iPhoneComponent
	 */
	public function getPhoneObject(){
		if (($this -> showIndividualNumber)||(!$this -> partner)) {
			$phone = new Phone($this -> phone);
		} else {
			if ($this->getFirstTriggerValue('area')->verbiage == 'msc') {
				$phone = Yii::app()->phoneMSC;
			} else {
				$phone = Yii::app()->phone;
			}
		}
		return $phone;
	}
}
