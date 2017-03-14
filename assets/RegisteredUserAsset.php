<?php


namespace app\assets;

use yii\web\AssetBundle;
use yii;

class RegisteredUserAsset  extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';


  public $js = [
      'js/registeredUser.js'
  ];

  public $depends = ['app\assets\AppAsset','app\assets\PushNotificationsAsset'];
}