<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:29
 */
trait tBinaryOperator {
    /**
     * @param mixed[] $operands
     * @return bool
     */
    public function validate($operands){
        if(empty($operands)) {
            return false;
        }
        return count($operands) > 1;
    }
    public function numberOfOperands() {
        return 2;
    }
}