<?php
/**
 * This is the model class for table "{{comments}}".
 *
 * The followings are the available columns in table '{{comments}}':
 * @property string $id
 * @property integer $id_object
 * @property string $text
 * @property integer $approved
 * @property string $created
 * @property integer $vk_id
 * @property integer $num
 *
 */
class Comment extends UVKCommentsModel
{
	public $api;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
			array('id_object, approved', 'numerical', 'integerOnly'=>true),
            array('created', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('text, vk_id, approved, api', 'safe'),
			array('id, approved, text', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return VkAccount
	 */
	public function getAccount() {
		return $this -> getModule() -> getAccount($this -> vk_id);
	}

    public function scopes() {
        return array(
            'approved'=>array('condition'=>"approved=1"),
            'pending_approval'=>array('condition'=>"approved=0"),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'object_id' => 'Клиника/Врач',
			'text' => 'Текст',
            'user_first_name' => 'Имя',
			'approved' => 'Одобрен/Отклонен',
			'create_at' => 'Создан',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return self the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return VKAccount
	 */
	public function getVKAccount(){
		$temp = $this -> getModule() -> getAccount($this -> vk_id);
		if (!$temp instanceof VKAccount) {
			$temp = $this -> getModule() -> getRandomAccount();
		}
		return $temp;
	}
	public function beforeSave() {
		if ((!$this -> vk_id)&&($this -> api)) {
			$vk = $this -> api;
			$vk = VKAccount::createByVkId($vk);
			$this -> vk_id = $vk -> id;
		}
		return $this->vk_id > 0 && parent::beforeSave();
	}
}
