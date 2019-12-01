<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetLogin extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/rajdhani.css',
        // 'css/site.css',
        'vendor/bootstrap/dist/css/bootstrap.min.css',
        'vendor/font-awesome/css/font-awesome.min.css',
        // 'css/AdminLTE.css',
        'admin_lte/css/AdminLTE.css',
        'css/custom.css',
        'ext/animated/animate.css',
        'ext/select2/dist/css/select2.min.css'
    ];
    public $js = [
        'vendor/bootstrap/dist/js/bootstrap.min.js',
        'ext/animated/wow.min.js',
        'ext/select2/dist/js/select2.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


}
