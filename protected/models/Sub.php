<?php

/**
 * This is the model class for table "{{sub}}".
 *
 * The followings are the available columns in table '{{sub}}':
 * @property string $utm
 * @property string $val1
 * @property string $val2
 * @property string $val3
 */
class Sub extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sub}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('utm', 'required'),
			array('utm', 'length', 'max'=>330),
			array('val1, val2, val3', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('utm, val1, val2, val3', 'safe', 'on'=>'search'),
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
			'price' => array(self::BELONGS_TO, 'Price', 'id_price'),
			'tel' => array(self::BELONGS_TO, 'Tel', 'id_tel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'utm' => 'Utm',
			'val1' => 'Val1',
			'val2' => 'Val2',
			'val3' => 'Val3',
		);
	}
	/**
	 * Function to be used in ViewModel action to have more flexibility
	 * @arg mixed arg - the argument populated from the controller.
	 */
	public function customFind($arg = false, $ext_data){
		$criteria = new CDbCriteria;
		$criteria -> compare('utm',$ext_data['utm']);
		if (!$rez = $this -> find($criteria)) {
			$rez = $this -> findByAttributes(array('utm' => 'empty'));
		}
		return $rez;
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

		$criteria->compare('utm',$this->utm,true);
		$criteria->compare('val1',$this->val1,true);
		$criteria->compare('val2',$this->val2,true);
		$criteria->compare('val3',$this->val3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sub the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
