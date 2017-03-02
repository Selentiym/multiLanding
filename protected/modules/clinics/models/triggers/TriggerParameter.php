<?php

/**
 * This is the model class for table "{{trigger_parameters}}".
 *
 * The followings are the available columns in table '{{trigger_parameters}}':
 * @property integer $id
 * @property string $name
 * @property string $verbiage
 * @property integer $id_trigger
 * @property string $defaultValue
 *
 * @property Triggers $trigger
 */
class TriggerParameter extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trigger_parameters}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verbiage, id_trigger', 'required'),
			array('id_trigger', 'numerical', 'integerOnly'=>true),
			array('name, defaultValue, verbiage', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, verbiage, defaultValue, id_trigger', 'safe', 'on'=>'search'),
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
			'trigger' => array(self::BELONGS_TO, 'Triggers', 'id_trigger'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'verbiage' => 'Verbiage',
			'id_trigger' => 'Id Trigger',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('id_trigger',$this->id_trigger);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->dbClinics;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerParameter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param $get
	 * @throws CDbException
	 * @throws Exception
	 */
	public function readData($get) {
		$this -> id_trigger = $get['id'];
		if (!$get['id']) {
			throw new Exception('No trigger ID specified!');
		}
		$this -> getRelated('trigger',true);
		parent::readData($get);
	}

	public function customFind($arg, $external = false, $scenario = false) {
		switch($this -> getScenario()) {
			case 'list':
				return $this;
				break;
			case 'create':
				return $this;
				break;
			default:
				if ($arg) {
					return $this -> findByPk($arg);
				}
				break;
		}
		return parent::customFind($arg, $external, $scenario);
	}
}
