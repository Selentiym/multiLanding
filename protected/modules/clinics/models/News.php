<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $id
 * @property integer $id_object
 * @property integer $id_price
 * @property integer $object_type
 * @property string $heading
 * @property string $text
 * @property string $validFrom
 * @property string $validTo
 * @property string $published
 * @property string $saleSize
 *
 *
 * @property BaseModel $object
 * @property ObjectPrice $research
 */
class News extends UModel {
	/**
	 * @var BaseModel $_object
	 */
	protected $_object;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_object, object_type, text', 'required'),
			array('id_object, object_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_object, object_type, text, heading, validFrom, validTo, published, id_price, saleSize', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'clinic' => [self::BELONGS_TO, 'clinics', 'id_object'],
			'research' => [self::BELONGS_TO, 'ObjectPrice', 'id_price'],
		);
	}

	/**
	 * @return BaseModel
	 */
	public function getObject() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		if (!isset($this -> _object)) {
			$name = Objects::getName($this -> object_type);
			$this -> _object = $name::model() -> findByPk($this -> id_object);
		}
		return $this -> _object;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_object' => 'Id Object',
			'object_type' => 'object_type',
			'text' => 'Text',
			'heading' => 'Заголовок',
			'validFrom' => 'validFrom',
			'validTo' => 'validTo',
			'published' => 'Published',
			'saleSize' => 'Величина скидки',
			'id_price' => 'Связанная цена',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_object',$this->id_object);
		$criteria->compare('object_type',$this->object_type);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('heading',$this->heading,true);
		$criteria->compare('validFrom',$this->validFrom,true);
		$criteria->compare('validTo',$this->validTo,true);
		$criteria->compare('published',$this->published,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection() {
		return Yii::app()->dbClinics;
	}

	protected function beforeSave() {
		switch($this -> getScenario()){
			case 'create':
				if ($this -> isNewRecord) {
					if (!$this -> published) {
						unset($this -> published);
					}
					$keys = ['published', 'validFrom', 'validTo'];
					foreach ($keys as $key) {
						if (strtotime($this -> $key) < 10000) {
							unset($this -> $key);
						}
					}
				}
				break;
		}
		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return int
	 */
	public function getTimeAttr($attr){
		$time = strtotime($this -> $attr);
		if ($time < 10000) {
			return 0;
		}
		return $time;
	}
	public static function newsPageByCriteria($data, $criteria = null){
		if (! $criteria instanceof CDbCriteria) {
			$criteria = new CDbCriteria();
		}
		//Сначала самые поздние
		$criteria -> order = 'published DESC';
		//Только активные акции
		$criteria -> addCondition('validTo > FROM_UNIXTIME('.(time()-1024).') or (not validTo > 0)');
		$criteria -> with = ['clinic'];
		//По Питеру или Москве
		if (in_array($data['area'], ['spb','msc'])) {
			$search = ClinicsModule::prepareTriggers(['area' => $data['area']]);
			clinics::model() -> setAliasedCondition($search,$criteria,'clinic.');
		}
		return News::model() -> findAll($criteria);
	}
	public function customFind($arg, $external = false, $scenario = false){
		switch($this -> getScenario()) {
			case 'view':
				return self::model() -> findByPk($_GET['id']);
			break;
			default:
				return self::model() -> findByPk($arg);
			break;
		}
	}
}
