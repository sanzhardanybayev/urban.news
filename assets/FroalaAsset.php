<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii;

class FroalaAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
      'dist/css/froala.css'
  ];

  public $js = [
      'dist/js/vendor.js'
  ];

  public $depends = ['app\assets\AppAsset'];

}