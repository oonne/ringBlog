<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author JAY
 */
class MetisMenuAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.
    public $sourcePath = '@vendor/onokumus/metismenu/dist';
    public $css = [
        'metisMenu.min.css',
    ];
    public $js = [
        'metisMenu.min.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}