<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2017
 * Time: 21:40
 */
interface iCommentPool {
    /**
     * @param integer $id of the object whose comments to get
     * @param CDbCriteria|null $criteria
     * @return Comment[]
     */
    public function getComments($id,CDbCriteria $criteria = null);
    /**
     * @param integer $objectId
     * @param string $text
     * @param mixed[] $else
     * @return bool successful or not
     */
    public function addComment($objectId, $text, $else);
}