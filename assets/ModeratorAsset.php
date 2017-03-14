<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii;


class ModeratorAsset  extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';


  public $js = [
      'js/moderator.js'
  ];

  public $depends = ['app\assets\AppAsset','app\assets\PushNotificationsAsset'];
}