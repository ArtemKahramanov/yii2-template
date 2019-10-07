<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    public $js = [
        'script/wow.js',
        'script/script.js',
    ];
    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
