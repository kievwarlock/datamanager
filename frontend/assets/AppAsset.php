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
        //'https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css',
        //'css/crop/croppie.css',
        'css/layout/main.css',
        'css/layout/media.css',
    ];
    public $js = [
       // 'https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js',
       // 'js/crop/croppie.min.js',
        //'js/crop/croppie.min.js',
        //'js/upload-images.js',
        'js/group.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
