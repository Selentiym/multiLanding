<?php

/**
 * This is the model class for table "{{object_price}}".
 *
 * The followings are the available columns in table '{{object_price}}':
 * @property integer $id
 * @property integer $id_type
 * @property integer $id_block
 * @property string $name
 * @property string $name2
 * @property string $verbiage
 * @property integer $object_type
 * @property integer $id_article
 * @property integer $id_replace_price
 *
 * @property ObjectPriceBlock $block
 * @property PriceType $type
 * @property ObjectPrice $replacement
 */
class ObjectPrice extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{object_price}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_type, id_block, name, verbiage', 'required'),
			array('id_type, id_block, object_type', 'numerical', 'integerOnly'=>true),
			array('verbiage',
					'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
					'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_type, id_block, name, object_type', 'safe', 'on'=>'search'),
			array('id, id_type, id_block, name, name2,object_type, verbiage, id_article, id_replace_price', 'safe'),
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
			'type' => array(self::BELONGS_TO, 'PriceType', 'id_type'),
			'block' => array(self::BELONGS_TO, 'ObjectPriceBlock', 'id_block'),
			'values' => array(self::HAS_MANY, 'ObjectPriceValue','id_price'),
			'article' => array(self::BELONGS_TO, 'Article','id_article'),
			'replacement' => array(self::BELONGS_TO, 'ObjectPrice','id_replace_price'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_type' => 'Id Type',
			'id_block' => 'Id Block',
			'name' => 'Name',
			'name2' => 'Название на сайте-источнике',
			'object_type' => 'Object Type',
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
		$criteria->compare('id_type',$this->id_type);
		$criteria->compare('id_block',$this->id_block);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('object_type',$this->object_type);

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
	 * @return ObjectPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return Article|null
	 */
	public function getArticle() {
		return $this -> article;
	}
}
