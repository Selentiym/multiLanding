<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 12:14
 */
abstract class aReversedExpressionEvaluator implements iExpressionEvaluator {
    /**
     * @var mixed[] operands stack
     */
    protected $_stack = [];
    /**
     * @param string $str
     * @return iOperator
     */
    abstract protected function getOperator($str);

    /**
     * @param string $str
     * @return mixed
     */
    abstract protected function getOperand($str);
    /**
     * @param string $str
     * @return bool
     */
    abstract protected function isOperator($str);
    /**
     * @param string $str
     * @return bool
     */
    abstract protected function isData($str);
    /**
     * @return string
     */
    abstract protected function getNextInstruction();
    /**
     * @param iOperator $op
     * @return bool
     */
    protected function validateOperator(iOperator $op) {
        return $op -> validate($this -> _stack);
    }

    /**
     * @param iOperator $op
     * @return mixed
     */
    protected function evaluateOperator(iOperator $op) {
        return $op -> evaluate($this -> _stack);
    }

    /**
     * @return bool
     */
    public function validate() {
        $this -> _stack = [];
        if (!$this -> getExpression()) {
            return false;
        }
        while ($i = $this -> getNextInstruction()) {
            if ($this -> isOperator($i)) {
                $op = $this -> getOperator($i);
                if (!$op) {
                    return false;
                }
                if (!$op -> validate($this -> _stack)) {
                    return false;
                }
                $this -> prepareOperator($op);
            } elseif ($this -> isData($i)) {
                array_push($this -> _stack, $i);
            } else {
                return false;
            }
        }
        if (count($this -> _stack) != 1) {
            return false;
        }
        return true;
    }
    public function evaluate() {
        $this -> _stack = [];
        while ($instr = $this -> getNextInstruction()) {
            if ($this -> isOperator($instr)) {
                $op = $this -> getOperator($instr);
                $args = $this -> prepareOperator($op);
                array_push($this -> _stack, $op -> evaluate($args));
            } elseif ($this -> isData($instr)) {
                array_push($this -> _stack, $this -> getOperand($instr));
            } else {
                throw new ExpressionException('Could not translate "'.$instr.'"');
            }
        }
        return array_pop($this -> _stack);
    }

    /**
     * @param iOperator $op
     * @return mixed[]
     */
    protected function prepareOperator(iOperator $op) {
        $args = [];
        for ($j = 0; $j < $op -> numberOfOperands(); $j ++) {
            array_push($args, array_pop($this -> _stack));
        }
        return $args;
    }
}