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
class TourAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'tour/css/wreck360.css',
        'tour/css/threesixty.css'
    ];

    public $cssOptions = ['position' => \yii\web\View::POS_BEGIN];

    public $js = [
        'tour/js/markers.js',
        'tour/js/threesixty.js',
        'tour/js/foot-scripts.js'
    ];
    
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AppAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
