<?php

/**
 * This is the model class for table "{{clinic_trigger_assignments}}".
 *
 * The followings are the available columns in table '{{clinic_trigger_assignments}}':
 * @property string $id
 * @property integer $id_object
 * @property integer $id_trigger_value
 */
class doctorsTriggerAssignment extends TriggerAssignment
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{doctors_trigger_assignments}}';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return doctorsTriggerAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string;
	 */
	public function getObjectName() {
		return 'doctors';
	}
}
