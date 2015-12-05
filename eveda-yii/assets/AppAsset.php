<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'js/fancybox/jquery.fancybox.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Oxygen:400,300,700',
    ];

    public $js = [
        'js/jquery.browser.js',
        'js/jquery-ui.min.js',
        'js/jquery.plugins.min.js',
        'js/jquery.fadethis.min.js',
        'js/fancybox/jquery.fancybox.js',
        'js/jquery.cycle2.min.js',
        'js/doubletaptogo.min.js',
        'js/modernizr.min.js',
        'https://www.google.com/recaptcha/api.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
