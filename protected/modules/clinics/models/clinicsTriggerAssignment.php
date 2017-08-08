<?php

/**
 * This is the model class for table "{{clinic_trigger_assignments}}".
 *
 * The followings are the available columns in table '{{clinic_trigger_assignments}}':
 * @property string $id
 * @property integer $id_object
 * @property integer $id_trigger_value
 */
class clinicsTriggerAssignment extends TriggerAssignment
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clinics_trigger_assignments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_object, id_trigger_value', 'required'),
			array('id_object, id_trigger_value', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_object, id_trigger_value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_object' => 'Id Clinic',
			'id_trigger_value' => 'Id Trigger Value',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_object',$this->id_object);
		$criteria->compare('id_trigger_value',$this->id_trigger_value);

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
	 * @return clinicsTriggerAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string;
	 */
	public function getObjectName() {
		return 'clinics';
	}
}
