<?php
return [
    'language' => 'az',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'common\bootstrap\SetUp',
        'config',
    ],
    'components' => [
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LffDA4UAAAAAHF5pwAXA8paCVk3FFomsgxavjgw',
            'secret' => '6LffDA4UAAAAACI1LJWFzqFB6MZxxkiLeGk_37c4',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
            //'class' => 'yii\caching\MemCache',
            //'useMemcached' => true,
        ],
        'config' => [
            'class' => 'common\components\Config',
        ],
        'authManager' => [
            'class' => 'core\components\AuthManager',
            'defaultRoles' => ['user'],
            'itemFile'       => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile'       => '@common/components/rbac/rules.php'
        ],
    ],
];
