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
class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/fancybox/jquery.fancybox.css',
        'css/backend.css',
        'css/jquery.fileupload.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ];

    public $js = [
        'js/fancybox/jquery.fancybox.js',
        'js/jquery-ui.min.js',
        'js/jquery.fileupload.js',
        'js/backend/script.js',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
