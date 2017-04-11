<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 21:44
 */
class SiteDispatcher
{
    const KEY = 'effectiveHost';
    // сохраняем найденный конфиг в сессию
    public static function setCurrentSiteConfig( $configName )
    {
        @session_start();
        $_SESSION['CURRENT_SITE_CONFIG'] = array(
            'host' => $_SERVER[self::KEY],
            'configName' => $configName
        );
        @session_write_close();
        @session_destroy();
    }

    // выбираем ранее заданный конфиг из сессии
    public static function getCurrentSiteConfig()
    {
        @session_start();
        $res = isset( $_SESSION['CURRENT_SITE_CONFIG'] )
            ? $_SESSION['CURRENT_SITE_CONFIG']
            : false;
        @session_write_close();
        @session_destroy();
        return $res;
    }

    public static function getConfigPath()
    {
        $arSites = self::getAvailableConfigs();

        $isLocal = $_SERVER['REMOTE_ADDR'] == '127.0.0.1';

        /*
        если в сессии есть выбранный сайт, то смотрим на совпадение хостов, если они совпали,
        то проверяем значение-имякконфига на валидность и возращем его или идём по правилам
        Если локалка, то хотим удобную смену между сайтами
        */
        if ( ($arCurrent = self::getCurrentSiteConfig())
            && (($arCurrent['host'] == $_SERVER[self::KEY])||($isLocal)) //На локалке проверка не по хосту
            && isset($arSites[$arCurrent['configName']])
            && ((!$_GET["configName"])||(!$isLocal))
        )
        {
            return self::selectedConfigName($arCurrent['configName']);
        }
        //Если мы находимся на локалхосте
        if ($isLocal) {
            $configName = self::getLocalConfigName($arSites);
            if ($configName) {
                return self::selectedConfigName($configName);
            }
        }

        foreach ( $arSites as $configName => $arSiteConfig )
        {
            $res = true;
            $res &= in_array( $_SERVER[self::KEY], $arSiteConfig['host'] );
            if ( $res && $arSiteConfig['userAgent'] && isset( $_SERVER['HTTP_USER_AGENT'] ) )
            {
                $m = false;
                $res &= preg_match( $arSiteConfig['userAgent'], $_SERVER['HTTP_USER_AGENT'], $m);
            }
            if ( $res )
            {
                return self::selectedConfigName($configName);
            }
        }

        if ($isLocal) {
            //Берем первый ключ массива
            $configName = current(array_keys($arSites));
            return self::selectedConfigName($configName);
        }

        error_log('Can\'t determine config to site: ' . var_export( array(
                'host' => $_SERVER[self::KEY],
                'userAgent' => $_SERVER[self::KEY],
            ), 1));
        //throw new Exception('Can\'t determine config to site');
        return false;
    }

    public static function getLocalConfigName($arSite){
        $param = $_GET["configName"];
        if ((isset($arSite[$param]))&&($param)) {
            self::setCurrentSiteConfig($param);
            return $param;
        }
        return false;
    }

    /**
     *
     * @static
     * @return mixed
     */
    protected static function getAvailableConfigs()
    {
        return require( dirname(dirname(__FILE__)) . '/config/sites.php' );
    }

    /**
     * @param $configName
     * @return string
     */
    private static function selectedConfigName($configName)
    {
        self::setCurrentSiteConfig($configName);
        return 'protected/config/' . $configName . '.php';
    }

    /**
     * Copy of CMap::mergeArray, which removes a value from resulting array
     * if the latest key corresponds to null
     * @param $a
     * @param $b
     * @return array|mixed
     */
    public static function mergeArray($a,$b)
    {
        $args=func_get_args();
        $res=array_shift($args);
        while(!empty($args))
        {
            $next=array_shift($args);
            foreach($next as $k => $v)
            {
                if ($v !== null) {
                    if (is_integer($k))
                        isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                    elseif (is_array($v) && isset($res[$k]) && is_array($res[$k]))
                        $res[$k] = self::mergeArray($res[$k], $v);
                    else
                        $res[$k] = $v;
                } else {
                    unset($res[$k]);
                }
            }
        }
        return $res;
    }

    /**
     * @return bool|string
     */
    public static function getFilesDir(){
        $id = Yii::app() -> params["siteId"];
        if ($id) {
            return Yii::getPathOfAlias("application.sites.$id");
        } else {
            return false;
        }
    }
}