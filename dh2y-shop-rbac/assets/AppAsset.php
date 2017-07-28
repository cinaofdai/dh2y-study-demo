<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';  //@webroot别名  ：linux的物理路径
    public $baseUrl = '@web';       //   @web别名 /

    //原理：将web以外的没有权限的资源目录复制的web目录下
    //public $sourcePath = '\temp\src'; //资源目录
    /*public $publishOptions =[ //运行发布的目录
        'only' => [
            'css',
            'fonts',
        ],
    ];*/

    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $cssOptions=[
        'noscript' => true,
    ];

    public $jsOptions=[
        'condition' => 'lte IE9',   //小于ie9才加载，做兼容
        'position' => View::POS_HEAD,  //将js放到开头
    ];
}
