<?php

namespace app\assets;

use app\models\User;
use Yii;
use yii\web\AssetBundle;

class PushNotificationsAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';

  public $js = [
      '/js/notifications.js'
  ];

  public $depends = ['app\assets\AppAsset'];

}