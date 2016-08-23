<?php

/**
 * This is the model class for table "{{views}}".
 *
 * The followings are the available columns in table '{{views}}':
 * @property integer $id
 * @property string $folder
 * @property string $date
 * @property string $agent
 * @property string $address
 * @property bool $newVisit
 * @property bool $robot
 */
class View extends UModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{views}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('folder', 'required'),
			array('folder', 'length', 'max'=>100),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, folder, date', 'safe', 'on'=>'search'),
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
			'folder' => 'Folder',
			'date' => 'Date',
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
		$criteria->compare('folder',$this->folder,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return View the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave() {
		$this -> robot = isBot($this -> agent);
		return parent::beforeSave();
	}
}
function isBot($userAgent, &$botname = ''){
	/* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
	$bots = array(
			'rambler','googlebot','aport','yahoo','msnbot','turtle','mail.ru','omsktele',
			'yetibot','picsearch','sape.bot','sape_context','gigabot','snapbot','alexa.com',
			'megadownload.net','askpeter.info','igde.ru','ask.com','qwartabot','yanga.co.uk',
			'scoutjet','similarpages','oozbot','shrinktheweb.com','aboutusbot','followsite.com',
			'dataparksearch','google-sitemaps','appEngine-google','feedfetcher-google',
			'liveinternet.ru','xml-sitemaps.com','agama','metadatalabs.com','h1.hrn.ru',
			'googlealert.com','seo-rus.com','yaDirectBot','yandeG','yandex',
			'yandexSomething','Copyscape.com','AdsBot-Google','domaintools.com',
			'Nigma.ru','bing.com','dotnetdotcom'
	);
	foreach($bots as $bot)
		if(stripos($userAgent, $bot) !== false){
			$botname = $bot;
			return true;
		}
	return false;
}