<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 11:49
 */
abstract class aLogicalExpressionEvaluator extends aReversedExpressionEvaluator implements iExpressionEvaluator {
    use tFixedOperatorSetExpressionEvaluator;
    public function __construct() {
        $this -> setOperators([
            '&' => new ANDOperator(),
            '||' => new OROperator(),
            '!' => new NOTOperator(),
        ]);
    }
}