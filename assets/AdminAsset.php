<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii;

class AdminAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';


  public $js = [
      'js/admin.js'
  ];

  public $depends = ['app\assets\AppAsset','app\assets\PushNotificationsAsset'];

}
