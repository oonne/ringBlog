<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SyntaxHighlighterAsset extends AssetBundle
{
    /**
     * UEditor路径
     * @var
     */
    public $sourcePath = '@crazydb/yii2-ueditor/assets';

    /**
     * UEditor加载需要的JS文件。
     * ueditor.config.js中是默认配置项，不建议直接引入。
     * @var array
     */
    public $js = [
        'third-party/SyntaxHighlighter/shCore.js',
    ];

    /**
     * UEditor加载需要的CSS文件。
     * UEditor 会自动加载默认皮肤，CSS这里不必指定
     *
     * @var array
     */
    public $css = [
        'third-party/SyntaxHighlighter/shCoreDefault.css',
    ];



}
