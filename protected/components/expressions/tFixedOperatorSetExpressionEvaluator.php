<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:08
 */
trait tFixedOperatorSetExpressionEvaluator {
    private $_operators = [];

    /**
     * @param iOperator[] $operators
     * @throws ExpressionException
     */
    public function setOperators($operators) {
        foreach ($operators as $key => $op) {
            if (!($op instanceof iOperator)) {
                ob_start();
                var_dump($op);
                $out = ob_get_contents();
                ob_end_clean();
                throw new ExpressionException("Variable $out is not an instance of iOperator");
            } else {
                $this -> _operators[$key] = $op;
            }
        }
    }
    /**
     * @param string $str
     * @return bool
     */
    protected function isOperator($str) {
        return boolval($this -> getOperator($str));
    }
    /**
     * @param string $str
     * @return iOperator
     */
    protected function getOperator($str) {
        return $this -> _operators[$str];
    }
}