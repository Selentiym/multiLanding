<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 11:30
 */
interface iRule {
    /**
     * @param mixed[] $args
     * @return bool
     */
    public function apply($args);
}