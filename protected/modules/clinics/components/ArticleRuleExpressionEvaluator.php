<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 15:51
 */
class ArticleRuleExpressionEvaluator extends aLogicalExpressionEvaluator {
    use tSeparatedStringExpressionEvaluator;

    const EVALUATING = 'beingEvaluated!';
    const SELF = 'self';

    private $_context;
    private static $_cached = [];
    private static $_allowedData;

    /**
     * ArticleRuleExpressionEvaluator constructor.
     * @param mixed[] $args triggers to evaluate rules
     * @param ArticleRule $context
     */
    public function __construct($args, ArticleRule $context) {
        parent::__construct();
        $this -> _args = $args;
        $this -> _context = $context;
    }

    /**
     * @param string $str
     * @return mixed
     * @throws ExpressionException
     */
    protected function getOperand($str) {
        if ($str === self::SELF) {
            if ($this -> _context instanceof ArticleRule) {
                return $this->_context->applyTriggers($this->_args);
            } else {
                throw new ExpressionException('No context specified');
            }
        } elseif (!isset(self::$_cached[$str])) {
            self::$_cached[$str] = self::EVALUATING;
            $a = ArticleRule::model() -> findByAttributes(['verbiage' => $str]);
            if ($a instanceof ArticleRule) {
                self::$_cached[$str] = $a->apply($this->_args);
            }
        } else {
            if (self::$_cached[$str] === self::EVALUATING) {
                throw new ExpressionCycleException('Cycle in evaluating '.$str);
            }
        }
        return self::$_cached[$str];
    }

    /**
     * @param string $str
     * @return bool
     */
    protected function isData($str){
        if (!isset(self::$_allowedData)) {
            self::$_allowedData = CHtml::giveAttributeArray(ArticleRule::model() -> findAll(), 'verbiage');
        }
        return in_array($str, self::$_allowedData);
    }
}