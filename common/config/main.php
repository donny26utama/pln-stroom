<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['stroom'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'class' => '\common\components\ZeedFormatter',
            'locale' => 'id-ID',
            // 'timeZone' => 'Asia/Jakarta',
            'defaultTimeZone' => 'Asia/Jakarta',
            'dateFormat' => 'php:j M Y',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'Rp ',
            'nullDisplay' => '<em style="color:#d8d8d8">null</em>',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
        ],
        'stroom' => [
            'class' => '\common\components\AppHelper',
        ],
    ],
];
