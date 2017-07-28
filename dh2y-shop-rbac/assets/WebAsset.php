<?php
/**
 * Created by dh2y.
 * bolg: http://blog.csdn.net/sinat_22878395
 * Date: 2017/7/28 14:42
 * functional: 功能说明
 */

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\View;

class WebAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'home/css/main.css',
        'home/css/red.css',
        'home/css/owl.carousel.css',
        'home/css/owl.transitions.css',
        'home/css/animate.min.css',
        'home/css/font-awesome.min.css'
    ];
    public $js = [
        'home/js/jquery-migrate-1.2.1.js',
        'home/js/gmap3.min.js',
        'home/js/bootstrap-hover-dropdown.min.js',
        'home/js/owl.carousel.min.js',
        'home/js/css_browser_selector.min.js',
        'home/js/echo.min.js',
        'home/js/jquery.easing-1.3.min.js',
        'home/js/bootstrap-slider.min.js',
        'home/js/jquery.raty.min.js',
        'home/js/jquery.prettyPhoto.min.js',
        'home/js/jquery.customSelect.min.js',
        'home/js/wow.min.js',
        'home/js/scripts.js',
        ['home/js/html5shiv.js','condition'=>'lte IE9','position'=>View::POS_HEAD],
        ['home/js/respond.min.js','condition'=>'lte IE9','position'=>View::POS_HEAD],
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',//只依赖了css
        'yii\bootstrap\BootstrapPluginAsset' //这个有js
    ];

}