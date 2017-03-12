<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 15:30
 */
trait tSeparatedStringExpressionEvaluator {
    private $_expression;
    private $_separator = ';';
    private $_instructions = [];
    /**
     * @return string
     */
    protected function getNextInstruction() {
        return array_shift($this -> _instructions);
    }

    /**
     * @param string $expr
     * @return mixed
     */
    public function setExpression($expr) {
        $this -> _expression = $expr;
        $this -> _instructions = array_filter(array_map('trim',explode($this -> _separator, $expr)));
    }

    /**
     * @return string $expr
     */
    public function getExpression() {
        return $this -> _expression;
    }
}