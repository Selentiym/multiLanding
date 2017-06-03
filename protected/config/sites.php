<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 19:52
 */
$_SERVER['effectiveHost'] = str_replace('debug.','',$_SERVER['HTTP_HOST']);
return array(
    'mrktClinics' => array(
        'host' => array(
            'мр-кт-клиники-спб.рф',
            'www.мр-кт-клиники-спб.рф',
            'xn------ddd7aaambciht6ad1ah.xn--p1ai',
            'www.xn------ddd7aaambciht6ad1ah.xn--p1ai'

        ),
        'userAgent' => false,
    ),
    'goodDoctors' => array(
        'host' => array(
            'общество-добросовестных-докторов.рф',
            'www.общество-добросовестных-докторов.рф',
            'xn-----9kcbdcbmddf6dubfdcbafba7akgidonf9f3ewd.xn--p1ai',
            'www.xn-----9kcbdcbmddf6dubfdcbafba7akgidonf9f3ewd.xn--p1ai',
        ),
        'userAgent' => false,
    ),
    'spbDiagnostRF' => [
        'host' => [
            'спб-диагност.рф',
            'www.спб-диагност.рф',
            'xn----8sbbkdy1bibtjm.xn--p1ai',
            'www.xn----8sbbkdy1bibtjm.xn--p1ai',
        ],
        'userAgent' => false
    ],
    'allMrtKtClinicsRF' => [
        'host' => [
            'все-мрт-и-кт-клиники-спб.рф',
            'www.все-мрт-и-кт-клиники-спб.рф',
            'xn--------fweby3acaawbcnk0a6bgrrje.xn--p1ai',
            'www.xn--------fweby3acaawbcnk0a6bgrrje.xn--p1ai',
        ],
        'userAgent' => false
    ],
    'oMrt' => [
        'host' => [
            'о-мрт.рф',
            'xn----xtbekk.xn--p1ai',
        ],
        'userAgent' => false
    ],
    'mrtKtMozg' => [
        'host' => [
            'мрт-и-кт-головного-мозга.рф',
            'xn-------83dkgbb3bezphknobcbc1a0ce.xn--p1ai',
            'andrei.cq97848.tmweb.ru',
        ],
        'userAgent' => false
    ],
    'mrtKtSpine' => [
        'host' => [
            'мрт-и-кт-головного-мозга.рф',
            'xn------8cdj3aeeoentakcblm2be7i.xn--p1ai',
            'spine.cq97848.tmweb.ru',
        ],
        'userAgent' => false
    ],
    'newDesign' => [
        'host' => [
            'domain',
        ],
        'userAgent' => false
    ],
    'spbTomograf' => [
        'host' => [
            'spb-tomograf.ru',
            'www.spb-tomograf.ru',
        ],
        'userAgent' => false
    ],
    'libraryLanding' => [
        'host' => [
            'abc',
        ],
        'userAgent' => false
    ]
);