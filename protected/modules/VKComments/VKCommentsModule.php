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
		return VKAccount::model() -> findByPk($id);
	}

	/**
	 * @param $id
	 * @return array|mixed|null
	 */
	public function getComment($id) {
		return Comment::model() -> findByPk($id);
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
	 * @return Comment
	 */
	public function addComment($objectId, $text, $else) {
		$c = new Comment();
		$c -> text = $text;
		$c -> id_object = $objectId;
		$c -> attributes = $else;
		$c -> save();
		return $c;
	}

	/**
	 * @param Comment $c
	 * @param $objectId
	 * @param $text
	 * @param $else
	 * @return Comment
	 */
	public function updateComment(Comment $c, $objectId, $text, $else) {
		$c -> text = $text;
		$c -> id_object = $objectId;
		$c -> attributes = $else;
		$c -> save();
		return $c;
	}

	/**
	 * @param Comment $comment
	 * @return bool
	 */
	public function deleteComment(Comment $comment) {
		return $comment -> delete();
	}
	/**
	 * @param Comment $model
	 * @return string html of the form
	 */
	public function commentForm(Comment $model = null){
		if (!$model) {
			$model = new Comment();
		}
		$acc = Yii::app() -> getController() -> renderPartial($this -> getId() . '.views.VKAccount',['model' => $model -> getAccount()],true);
		return Yii::app() -> getController() -> renderPartial($this -> getId() . '.views._form',['model' => $model, 'mod' => $this, 'acc' => $acc],true);
		//$this ->  -> renderPartial();
	}
}
