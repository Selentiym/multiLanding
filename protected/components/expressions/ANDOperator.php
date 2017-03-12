<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:22
 */
class ANDOperator implements iOperator {
    use tBinaryOperator;
    /**
     * @param mixed[] $operands
     * @return mixed
     */
    public function evaluate($operands) {
        return array_pop($operands) && array_pop($operands);
    }
}