<?php
return [
    'name' => 'RingBlog',
    'timeZone' => 'Asia/Hong_Kong',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'xunsearch' => [
            'class' => 'hightman\xunsearch\Connection', // 此行必须
            'iniDirectory' => '@common/data/xunsearch',    // 搜索 ini 文件目录，默认：@vendor/hightman/xunsearch/app
            'charset' => 'utf-8',   // 指定项目使用的默认编码，默认即时 utf-8，可不指定
        ],
    ],
];
