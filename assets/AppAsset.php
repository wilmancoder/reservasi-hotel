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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      // 'css/site.css',
      'vendor/bootstrap/dist/css/bootstrap.min.css',
      'css/rajdhani.css',
      'vendor/font-awesome/css/font-awesome.min.css',
      'vendor/Ionicons/css/ionicons.min.css',
      'css/AdminLTE.css',
      'css/skins/_all-skins.min.css',
      // 'ext/datatables/dataTables.bootstrap.css',
      'ext/datatablesnew/jquery.dataTables.min.css',
      'ext/datepicker/datepicker3.css',
      'ext/select2/dist/css/select2.min.css',
      'css/custom.css',
    ];
    public $js = [
      'vendor/jquery/dist/jquery.min.js',
      'vendor/bootstrap/dist/js/bootstrap.min.js',
      'vendor/jquery-slimscroll/jquery.slimscroll.min.js',
      'vendor/fastclick/lib/fastclick.js',
      'js/adminlte.js',
      'js/demo.js',
      'js/sweetalert.min.js',
      // 'ext/datatables/jquery.dataTables.min.js',
      // 'ext/datatables/dataTables.bootstrap.min.js',
      'ext/datatablesnew/jquery.dataTables.min.js',
      'ext/datepicker/bootstrap-datepicker.js',
      'ext/jquerynumber/jquery.number.min.js',
      'ext/select2/dist/js/select2.min.js',
      'ext/countdowntimer/jquery.simple.timer.js',
      'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
