<?php
return [
    'version' => '2.0.1',
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'zcms_db_master',
        'port' => '3306',
        'schema' => 'public',
        'log' => 0,
        'charset' => 'utf8'
    ],
    'website' => [
        'baseUri' => '',
        'direction' => 'ltr',
        'language' => 'en-GB',
        'metaDesc' => 'ZCMS Power by Phalcon 2!',
        'metaKey' => 'zcms, phalcon 2',
        'siteName' => 'ZCMS',
        'systemName' => 'ZCMS SYSTEM',
        'timezone' => 'America/Los_Angeles'
    ],
    'auth' => [
        'salt' => 'uOrk7P8majuly8TZy7R0gg',
        'lifetime' => 3600
    ],
    'social' => [
        'facebook' => [
            'appId' => '',
            'appSecret' => '',
            'defaultGraphVersion' => 'v2.4',
            'permissions' => [
                'email',
            ]
        ],
        'google' => [
            'appId' => '1'
        ]
    ],
    'backendTemplate' => [
        'compileTemplate' => 1,
        'defaultTemplate' => 'default'
    ],
    'frontendTemplate' => [
        'compileTemplate' => 1,
        'defaultTemplate' => 'default'
    ],
    'mail' => [
        'mailName' => 'ZCMS',
        'mailFrom' => '',
        'mailType' => 'sendMail',//smtp
        'sendMail' => '/usr/sbin/sendmail',
        'smtpUser' => '',
        'smtpHost' => 'smtp.gmail.com',
        'smtpPass' => '',
        'smtpSecure' => 'ssl',
        'smtpPort' => 465,
        'smtpAuth' => 0
    ],
    'pagination' => [
        'feedLimit' => 15,
        'limit' => 15,
        'mediaLimit' => 12
    ],
    'viewCache' => [
        'lifetime' => 1800,
        'dir' => '/cache/web/'
    ],
    'cachePrefix' => 'ZCMS_',
    'fileCache' => [
        'lifetime' => 1,
        'cacheDir' => '/cache/fileCache/',
        'status' => true
    ],
    'apcCache' => [
        'lifetime' => 1800,
        'status' => true
    ],
    'memCache' => [
        'host' => 'localhost',
        'lifetime' => 1800,
        'port' => 11211,
        'status' => true
    ],
    'redisCache' => [
        'host' => 'localhost',
        'port' => 6379,
        'lifetime' => 1800,
        'auth' => 'ZCMS',
        'persistent' => false,
        'status' => true
    ],
    'modelMetadataCache' => [
        'status' => true,
        'lifetime' => 1800,
        'type' => 'files'
    ],
    'debug' => 0,
    'logError' => 0,
    'debugType' => 'var_dump'
];
