<?php

/**
 * This is the model class for table "{{price_value}}".
 *
 * The followings are the available columns in table '{{price_value}}':
 * @property integer $id_price
 * @property integer $id_object
 * @property double $value
 * @property integer $id
 *
 * @property ObjectPrice $price
 */
class ObjectPriceValue extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{price_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_price, id_object, value', 'required'),
			array('id_price, id_object', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_price, id_object, value, id', 'safe', 'on'=>'search'),
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
			'price' => array(self::BELONGS_TO, 'ObjectPrice', 'id_price'),
			'clinic' => [self::BELONGS_TO, 'clinics', 'id_object'],
			'doctor' => [self::BELONGS_TO, 'doctors', 'id_object'],
//			'doctor' => [self::BELONGS_TO, 'clinics', 'id_object', 'with' => ['price' => ['together' => true]], 'condition' => 'price.object_type='.Objects::getNumber('doctors')],
//			'doctor' => [self::BELONGS_TO, 'doctors', 'id_object']
		);
	}

	/**
	 * @return clinics|doctors
	 */
	public function getObject(){
		$name = Objects::getName($this -> price -> object_type);
		return $name::model() -> findByPk();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_price' => 'Id Price',
			'id_object' => 'Id Object',
			'value' => 'Value',
			'id' => 'ID',
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

		$criteria->compare('id_price',$this->id_price);
		$criteria->compare('id_object',$this->id_object);
		$criteria->compare('value',$this->value);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectPriceValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave() {
		//Если уже существует данная цена, то не создаем новую запись в таблице, а только обновляем старую.
		if (true) {
			if ($this -> isNewRecord) {
				$dupl = $this -> findByAttributes(['id_object' => $this -> id_object, 'id_price' => $this -> id_price]);
				if ($dupl) {
					if ($this -> getScenario() == 'noUpdateIfDup') {
						return false;
					}
					$dupl -> value = $this -> value;
					if ($dupl -> save()) {
						return false;
					} else {
						$err = $dupl -> getErrors();
					}
				}
			}
			return true;
		}
		return false;
	}

	private static function addSeparatedFieldCondition($field,CDbCriteria $criteria, $id){
		$criteria -> addCondition("$field LIKE '%;$id;%' OR $field LIKE '%;$id' OR $field LIKE '$id;%' OR $field = '$id'");
		return $criteria;
	}
	public static function searchPriceValues($triggers, CDbCriteria $criteria = null){
		$search = ClinicsModule::prepareTriggers($triggers);
		if (!is_a($criteria, 'CDbCriteria')) {
			$criteria = new CDbCriteria();
		}
		if (empty($criteria -> with)) $criteria -> with = [];
		if (empty($criteria -> params)) $criteria -> params = [];
		$search = array_filter($search);
		$criteria -> with = array_merge($criteria -> with, ['clinic' => ['select' => false]]);
		clinics::model() -> setAliasedCondition($search,$criteria,'clinic.');
		$m = ObjectPriceValue::model();
		return $m -> findAll($criteria);
	}
	public function __toString() {
		return (string)$this -> value;
	}
}
