<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:31
 */
class NOTOperator implements iOperator {

    /**
     * @param mixed[] $operands
     * @return mixed
     */
    public function evaluate($operands){
        return !array_pop($operands);
    }

    /**
     * @param mixed[] $operands
     * @return bool
     */
    public function validate($operands){
        return !empty($operands);
    }

    /**
     * @return int
     */
    public function numberOfOperands() {
        return 1;
    }
}