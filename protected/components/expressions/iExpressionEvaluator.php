<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:05
 */
interface iExpressionEvaluator {
    /**
     * @param string $expr
     * @return mixed
     */
    public function setExpression($expr);
    /**
     * @return string $expr
     */
    public function getExpression();
    /**
     * @return bool
     */
    public function validate();

    /**
     * @return mixed
     */
    public function evaluate();
}