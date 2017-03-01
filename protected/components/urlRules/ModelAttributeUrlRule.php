<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.03.2017
 * Time: 17:30
 */
class ModelAttributeUrlRule extends CUrlRule implements iCallFunc{
    use tCallFunc;
    private $_inited = false;

    public $modelClass;
    public $attribute;
    public $route;
    public $pattern;
    public $attributeInPattern = false;
    /**
     * ModelAttributeUrlRule constructor.
     * Does nothing, cause parent constructer needs arguments which I am ot able to pass before configuring
     * parent::__construct() is to be called in init with all needed parameters later!
     */
    public function __construct(){
        return;
    }

    /**
     * @throws CException
     * Analog to ordinary __construct
     */
    public function init()
    {
        if ($this -> _inited) {
            return;
        }
        $this -> _inited = true;
        parent::__construct($this -> route, $this -> pattern);
        return;
    }
    public function createUrl($manager,$route,$params,$ampersand)
    {
        $this -> init();
        if($this->parsingOnly)
            return false;
        if($manager->caseSensitive && $this->caseSensitive===null || $this->caseSensitive)
            $case='';
        else
            $case='i';
        $tr=array();
        if($route!==$this->route)
        {
            if($this->routePattern!==null && preg_match($this->routePattern.$case,$route,$matches))
            {
                foreach($this->references as $key=>$name)
                    $tr[$name]=$matches[$key];
            }
            else
                return false;
        }
        foreach($this->defaultParams as $key=>$value)
        {
            if(isset($params[$key]))
            {
                if($params[$key]==$value)
                    unset($params[$key]);
                else
                    return false;
            }
        }
        foreach($this->params as $key=>$value)
            if(!isset($params[$key]))
                return false;
        if($manager->matchValue && $this->matchValue===null || $this->matchValue)
        {
            foreach($this->params as $key=>$value)
            {
                if(!preg_match('/\A'.$value.'\z/u'.$case,$params[$key]))
                    return false;
            }
        }
        foreach($this->params as $key=>$value)
        {
            $tr["<$key>"]=urlencode($params[$key]);
            unset($params[$key]);
        }
        $suffix=$this->urlSuffix===null ? $manager->urlSuffix : $this->urlSuffix;
        $url=strtr($this->template,$tr);
        if($this->hasHostInfo)
        {
            $hostInfo=Yii::app()->getRequest()->getHostInfo();
            if(stripos($url,$hostInfo)===0)
                $url=substr($url,strlen($hostInfo));
        }
        if(empty($params))
            return $url!=='' ? $url.$suffix : $url;
        if($this->append)
            $url.='/'.$manager->createPathInfo($params,'/','/').$suffix;
        else
        {
            if($url!=='')
                $url.=$suffix;
            $url.='?'.$manager->createPathInfo($params,'=',$ampersand);
        }
        return $url;
    }
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        $this -> init();
        if($this->verb!==null && !in_array($request->getRequestType(), $this->verb, true))
            return false;
        if($manager->caseSensitive && $this->caseSensitive===null || $this->caseSensitive)
            $case='';
        else
            $case='i';
        if($this->urlSuffix!==null)
            $pathInfo=$manager->removeUrlSuffix($rawPathInfo,$this->urlSuffix);
        // URL suffix required, but not found in the requested URL
        if($manager->useStrictParsing && $pathInfo===$rawPathInfo)
        {
            $urlSuffix=$this->urlSuffix===null ? $manager->urlSuffix : $this->urlSuffix;
            if($urlSuffix!='' && $urlSuffix!=='/')
                return false;
        }
        if($this->hasHostInfo)
            $pathInfo=strtolower($request->getHostInfo()).rtrim('/'.$pathInfo,'/');
        $pathInfo.='/';
        if(preg_match($this->pattern.$case,$pathInfo,$matches))
        {
            //Check, whether the attribute value is allowed
            if (!$this -> checkParameterValidity($matches)) {
                return false;
            }
            //end modifications
            foreach($this->defaultParams as $name=>$value)
            {
                if(!isset($_GET[$name]))
                    $_REQUEST[$name]=$_GET[$name]=$value;
            }
            $tr=array();
            foreach($matches as $key=>$value)
            {
                if(isset($this->references[$key]))
                    $tr[$this->references[$key]]=$value;
                elseif(isset($this->params[$key]))
                    $_REQUEST[$key]=$_GET[$key]=$value;
            }
            if($pathInfo!==$matches[0]) // there're additional GET params
                $manager->parsePathInfo(ltrim(substr($pathInfo,strlen($matches[0])),'/'));
            if($this->routePattern!==null)
                return strtr($this->route,$tr);
            else
                return $this->route;
        }
        else
            return false;
    }

    /**
     * @param $params
     * @return bool whether the ActiveRecord parameter has allowed value
     */
    public function checkParameterValidity($params){
        $patternName = $this -> attributeInPattern ? $this -> attributeInPattern : $this -> attribute;
        $val = $params[$patternName];
        try {
            $modelClass = $this->getAttribute('modelClass');
        } catch (AccessException $e) {
            return false;
        }
        $modelClass = $modelClass instanceof CActiveRecord ? $modelClass : CActiveRecord::model($modelClass);
        if ($modelClass instanceof CActiveRecord) {
            $model = $modelClass -> findByAttributes([$this -> attribute => $val]);
            if ($model) return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function _isAllowedToEvaluate($name) {
        return true;
    }
}