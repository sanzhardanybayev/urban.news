<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/all.css'
    ];

    public $js = [
        'dist/all.js',
        'js/yii.js',
        'js/yii.validation.js',
        'js/yii.activeForm.js',
    ];

    public $depends;


}
