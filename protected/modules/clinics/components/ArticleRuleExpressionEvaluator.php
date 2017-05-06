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
            $rez = $this -> evaluateSpecialOperand($str);
            if ($rez === null) {
                $a = ArticleRule::model()->findByAttributes(['verbiage' => $str]);
                if ($a instanceof ArticleRule) {
                    self::$_cached[$str] = $a->apply($this->_args);
                }
            } else {
                self::$_cached[$str] = $rez;
            }
        } else {
            if (self::$_cached[$str] === self::EVALUATING) {
                throw new ExpressionCycleException('Cycle in evaluating '.$str);
            }
        }
        return self::$_cached[$str];
    }

    protected function evaluateSpecialOperand($str) {
        if (in_array($str,['mrtResearch','ktResearch'])) {
            /**
             * @type ObjectPrice $price
             */
            $price = ObjectPrice::model() -> findByAttributes(['verbiage' => $this -> _args['research']]);
            if (! $price instanceof ObjectPrice) {
                return false;
            }
            return strstr($str, $price -> type -> alias);
        }
        return null;
    }

    /**
     * @param string $str
     * @return bool
     */
    protected function isData($str){
        if (!isset(self::$_allowedData)) {
            self::$_allowedData = CHtml::giveAttributeArray(ArticleRule::model() -> findAll(), 'verbiage');
        }
        return in_array($str, self::$_allowedData)||in_array($str,['mrtResearch','ktResearch',self::SELF]);
    }
}