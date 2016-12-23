<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 21:44
 */
class SiteDispatcher
{
    // сохраняем найденный конфиг в сессию
    public static function setCurrentSiteConfig( $configName )
    {
        @session_start();
        $_SESSION['CURRENT_SITE_CONFIG'] = array(
            'host' => $_SERVER['HTTP_HOST'],
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
            && (($arCurrent['host'] == $_SERVER['HTTP_HOST'])||($isLocal)) //На локалке проверка не по хосту
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
            $res &= in_array( $_SERVER['HTTP_HOST'], $arSiteConfig['host'] );
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
                'host' => $_SERVER['HTTP_HOST'],
                'userAgent' => $_SERVER['HTTP_HOST'],
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

}