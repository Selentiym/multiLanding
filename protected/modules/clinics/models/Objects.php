<?php

/**
 * This is the model class for table "{{objects}}".
 *
 * The followings are the available columns in table '{{objects}}':
 * @property integer $id
 * @property string $name
 */
class Objects extends CTModel {
	private static $_substitute = ['Service' => 'clinics'];
	private static $_data;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{objects}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => CHtml::encode('Тип объекта'),
			'name' => CHtml::encode('Название объекта'),
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
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returnes the number corresponding to the given modelName
	 * @arg string modelName - class name of a model which interests us
	 * @return integer
	 */
	public static function getNumber($modelName){
		$modelName = self::$_substitute[$modelName] ? self::$_substitute[$modelName] : $modelName;
		$temp = array_flip(self::getData());
		return $temp[$modelName];
	}
	/**
	 * Returnes the name corresponding to the given id of the object type
	 * @arg integer number - id of an object type
	 * @return string - corresponding modelName
	 */
	public static function getName($number){
		return self::getData()[$number];
	}
	public static function getData(){
		if (empty(self::$_data)) {
			$temp = [];
			foreach (Objects::model()->findAll() as $o) {
				$temp[$o -> id] = $o -> name;
			}
			self::$_data = $temp;
		}
		return self::$_data;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
