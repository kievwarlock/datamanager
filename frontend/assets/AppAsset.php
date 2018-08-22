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
        'image-upload/css/crop/croppie.css',
        'css/layout/main.css',
        'css/layout/media.css',
    ];
    public $js = [
       // 'https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js',
       // 'js/crop/croppie.min.js',
        //'js/crop/croppie.min.js',
        //'js/upload-images.js',
        'image-upload/js/crop/croppie.min.js',
        'image-upload/js/upload-images.js',

        'js/drag/Sortable.min.js',
        'js/drag/app.js',
        'js/group/group.js',
        'js/group/posts.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
