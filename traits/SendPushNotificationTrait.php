<?php

namespace app\traits;


use Yii;

trait SendPushNotificationTrait
{

  public function delegateToPusher($notificationChannel, $notificationTitle, $notificationBody, $notificationURL = "", $notificationImg = "")
  {
    $data['notification']['title'] = $notificationTitle;
    $data['notification']['message'] = $notificationBody;
    $data['notification']['image'] = ($notificationImg != "") ? $notificationImg : Yii::$app->request->getHostInfo() . '/dist/img/icon.png';
    // It equals to null whenever article or user is deleted
    if($notificationURL != null){
      $data['notification']['url'] = $notificationURL;
    }else{
      $data['notification']['url'] = null;
    }

    \Yii::$app->pusher->trigger($notificationChannel, 'something-changed', $data);
  }
}