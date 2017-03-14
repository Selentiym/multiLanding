<?php
class VKCommentsModule extends UWebModule implements iCommentPool{
	/**
	 * @var string $bankConfig a string to be used in Yii::app() -> getComponent to get
	 * the database connection to the pool with VkAccount's
	 */
	public $bankConfig;

	public function init() {
		parent::init();
		//Необходимо для работы VKAPI
		require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
		$this->setImport(array(
			$this -> getId().'.models.*',
			//'VKComments.components.*',
		));
		$temp = $this -> getAttribute('bankConfig');
		if (!($temp instanceof CDbConnection)) {
			$temp = Yii::app() -> getComponent($temp);
		}
		if (!($temp instanceof CDbConnection)) {
			throw new CDbException("Could not establish connection in module ". get_class($this));
		}
		VKAccount::setDbConnection($temp);
	}

	/**
	 * @param integer $id of the object whose comments to get
	 * @param CDbCriteria|null $criteria
	 * @return Comment[]
	 */
	public function getComments($id,CDbCriteria $criteria = null){
		Comment::setModule($this);
		if (!$criteria instanceof CDbCriteria) {
			$criteria = new CDbCriteria();
		}
		$criteria -> compare('id_object', $id);
		return Comment::model() -> findAll($criteria);
	}

	/**
	 * @param integer $id
	 * @return VkAccount
	 */
	public function getAccount($id){
		VKAccount::model() -> findByPk($id);
	}
	/**
	 * @return VKAccount
	 */
	//abstract public function getRandomAccount();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function _isAllowedToEvaluate($name) {
		return parent::_isAllowedToEvaluate($name) || in_array($name, ['bankConfig']);
	}

	/**
	 * @return array|bool
	 */
	public function randomPerson() {
		$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5');
		$temp = current($vk->request('users.get', [
				'user_ids' => [rand(1000000,1000000*100)],
				"fields" => "photo_50, domain"
		])->getResponse());
		if ($temp -> deactivated) {
			return $this -> randomPerson();
		}
		return $temp;
	}

	/**
	 * @param integer $objectId
	 * @param string $text
	 * @param mixed[] $else
	 * @return bool successful or not
	 */
	public function addComment($objectId, $text, $else) {
		$c = new Comment();
		$c -> text = $text;
		$c -> id_object = $objectId;
		$c -> attributes = $else;
		if (!$else['vk_id']) {
			$vk = $else['api'];
			$vk = VKAccount::createByVkId($vk);
			$c -> vk_id = $vk -> id;
		}
		return $c -> save();
	}
}
