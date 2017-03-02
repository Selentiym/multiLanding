<?php

/**
 * This is the model class for table "{{trigger_parameter_values}}".
 *
 * The followings are the available columns in table '{{trigger_parameter_values}}':
 * @property integer $id
 * @property integer $id_trigger_parameter
 * @property integer $id_trigger_value
 * @property string $value
 */
class TriggerParameterValue extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trigger_parameter_values}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_trigger_parameter, id_trigger_value', 'required'),
			array('id_trigger_parameter, id_trigger_value', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_trigger_parameter, id_trigger_value, value', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_trigger_parameter' => 'Id Trigger Parameter',
			'id_trigger_value' => 'Id Trigger Value',
			'value' => 'Value',
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
		$criteria->compare('id_trigger_parameter',$this->id_trigger_parameter);
		$criteria->compare('id_trigger_value',$this->id_trigger_value);
		$criteria->compare('value',$this->value,true);

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
	 * @return TriggerParameterValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
