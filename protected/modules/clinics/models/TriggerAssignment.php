<?php

/**
 * This is the model class for table "{{clinic_trigger_assignments}}".
 *
 * The followings are the available columns in table '{{clinic_trigger_assignments}}':
 * @property string $id
 * @property integer $id_object
 * @property integer $id_trigger_value
 *
 * @property BaseModel $object
 * @property TriggerValues $value
 */
abstract class TriggerAssignment extends UModel {

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
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'object' => array(self::BELONGS_TO, $this -> getObjectName(), 'id_object'),
            'value' => array(self::BELONGS_TO, 'TriggerValues', 'id_value')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_object' => 'Id of the object',
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
     * @return TriggerAssignment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string;
     */
    abstract public function getObjectName();
}
