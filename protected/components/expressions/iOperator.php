<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:20
 */
interface iOperator {
    /**
     * @param mixed[] $operands
     * @return mixed
     */
    public function evaluate($operands);

    /**
     * @param mixed[] $operands
     * @return bool
     */
    public function validate($operands);

    /**
     * @return int
     */
    public function numberOfOperands();
}