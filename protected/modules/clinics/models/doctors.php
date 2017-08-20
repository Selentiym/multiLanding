<?php

/**
 * This is the model class for table "{{doctors}}" - it describes a standard Doctor
 *
 * The followings are the available columns in table '{{doctors}}':
 * @property integer $id
 * @property string $verbiage
 * @property string $name
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
 * @property integer $experience
 * @property string $rewards
 * @property string $curses
 * @property string $education
 * @property string $short
 *
 */
 
class doctors extends BaseModel
{
    public $metros_display;
    public $districts_display;
    public $triggers_display;
	public $additional;
	/**
	 * @var array clinicsInput - an array of clinic ids that are to be linked to this doctor
	 */
	public $clinicsInput;
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
	public function tableName()
	{
		return '{{doctors}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
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
			array('id, name, verbiage, phone, phone_extra, fax, address, address_extra, site, district, metro_station, working_days, working_hours, services, rating, triggers, map_coordinates, text, audio, video, title, keywords, description, experience, education, curses', 'safe', 'on'=>'search'),
			array('clinicsInput, rewards, short, text', 'safe')
		);
	}

    /**
     * @return array relational rules.
     */
     
    public function relations()
    {
        return parent::relations() + array(
            //'services' => array(self::HAS_MANY, 'Services', 'object_id'),
            'services' => array(self::HAS_MANY, 'Services', 'object_id', 'condition' => 'services.object_type = '.Objects::model() -> getNumber(get_class($this))),
            'comments' => array(self::HAS_MANY, 'Comments', 'object_id', 'condition' => 'comments.object_type = '.Objects::model() -> getNumber(get_class($this))),
            //'doctorfields' => array(self::HAS_MANY, 'ObjectsFields', 'object_id', 'with' => 'field'),
            'fields' => array(self::HAS_MANY, 'FieldsValue', 'object_id', 'with' => 'field', 'condition' => 'field.object_type = '.Objects::model() -> getNumber(get_class($this))),
			'clinics' => array(self::MANY_MANY, 'clinics', '{{employments}}(id_doctor, id_clinic)')
        );
    }


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => CHtml::encode('Имя'),
            'verbiage' => CHtml::encode('Имя в URL'),
			'phone' => CHtml::encode('Телефон'),
			'fax' => CHtml::encode('Факс'),
			'address' => CHtml::encode('Адрес'),
            'site' => CHtml::encode('Сайт'),
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
			'experience' => CHtml::encode('Стаж'),
			'curses' => CHtml::encode('Курсы повышения квалификации'),
			'rewards' => CHtml::encode('Статусы, награды. \<br\/\> для переноса на новую строку.'),
			'short' => CHtml::encode('Краткое описание (отображается на страничке клиники справа.)'),
			'education' => CHtml::encode('Образование')
		);
	}
    /** This is a standard search function (not in use)
     * 
     */
	public function search()
	{
		$criteria=new CDbCriteria;

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
		));
	}//*/

    // this is standard function for getting a model of the current class
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/** Function to determine which attribute will be used to name file folder.
	*
	*/
	public function FolderKey()
	{
		return 'verbiage';
	}
	
	/**
	*  EVENT HANDLERS
	*/
	
	/**
	* Function to be called after $model -> save() methods succeeds
	*/
	public function afterSave($noPrices = false)
	{
		parent::afterSave($noPrices = false);
		//Сохраняем изменения в массиве докторов
		if (!isset($this -> clinicsInput)) {
			$this -> clinicsInput = array();
		}
		//print_r($this -> clinicsInput);
		//avePropertyArrayChanges($ids, $objectClass, $propertyName, $PK, $PK_name, $PK_small, $PK_small_name);
		$this -> SavePropertyArrayChanges($this -> clinicsInput, 'Employment', 'clinics', 'id', 'id_doctor', 'id', 'id_clinic');
		//Если у модели клиники определены какие-то значения дополнительных полей, то сохраняем их.
		if (isset($this -> additional))
		{
			foreach ($this -> additional as $id => $value)
			{
				$current_field = FieldsValue::model()->findByPk(trim($id));
				$current_field -> value = $value;
				if (!$current_field -> save()) {
					new CustomFlash("error", 'DoctorFields', 'SaveField_id_'.$id, 'Не удалось сохранить поле врача с id '.$id, true) ;
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
	
	
	
	public function ReadData($data){}
	
	public function FillFieldsFromArray($model, $post_arr) {
		parent::FillFieldsFromArray($model, $post_arr);
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
		$model -> education = $post_arr['doctors']['education'];
		$model -> curses = $post_arr['doctors']['curses'];
	}
	/** Function that saves files to corresponding folders and updates model's file data.
	* it also tries to delete previous files if they exist.
	*/
	public function FilesOperationsFromArray($model, $files_arr) 
	{
		// logo and audio
		
		$files_filePath = $model -> giveFileFolderAbsoluteUrl(NULL, 'files');
		if (!file_exists($files_filePath))
		{
			mkdir($files_filePath);
		}
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		if (!file_exists($images_filePath))
		{
			mkdir($images_filePath);
		}
		if(!empty($files_arr['doctors']['name']['logo'])){
			$logo_old = $model->logo;
			$model->logo = CUploadedFile::getInstance($model,'logo');
			$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
			$fileName = $images_filePath . DIRECTORY_SEPARATOR . $image_unique_id;

			if ($model->validate()) {
				$model->logo->saveAs($fileName);
				$model->logo = $image_unique_id;
				if (strlen($logo_old) > 0) @unlink ($images_filePath. DIRECTORY_SEPARATOR .$logo_old);
			}
			else
				$model->logo = $logo_old;
		}

		if(!empty($files_arr['doctors']['name']['audio'])) {
			$audio_old = $model->audio;
			$model->audio = CUploadedFile::getInstance($model,'audio');
			//$fileName = Yii::app()->basePath.'/../files/doctors/'.$model->id . '/' . $model->audio;
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

	/*
	* Data transform functions ids <-> names
	*/
	public function giveSubwayNames($data = '') {
		if (strlen($data) == 0)
		{
			$data = $this -> metro_station;
		}
		$subway_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $subway_ids);
		return array_values(CHtml::listData(Metro::model()->findAll($criteria), 'id','name'));//костыль. переписать

	}
	public function giveDistrNames($data = ''){
		if (strlen($data == 0))
		{
			$data = $this -> district;
		}
		$distr_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $distr_ids);
		return array_values(CHtml::listData(Districts::model()->findAll($criteria), 'id','name'));//костыль. переписать
	}

	public function giveLogoUrl(){
		$saved = $this -> giveImageFolderAbsoluteUrl() . $this -> logo;
		if ((!file_exists($saved))||(!$this -> logo)) {
			return Yii::app() -> theme -> baseUrl .'/images/noImage.png';
		}
		return $this -> giveImageFolderRelativeUrl() . $this -> logo;
	}
}
