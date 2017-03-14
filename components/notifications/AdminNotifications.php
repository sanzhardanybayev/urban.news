<?php
namespace app\components\notifications;


use app\components\EventTrigger;
use app\components\utility;
use app\models\Mailer;
use app\traits\CustomSQL;
use app\traits\SendPushNotificationTrait;
use Yii;

class AdminNotifications
{
  use CustomSQL;
  use SendPushNotificationTrait;


  private $adminNotificationType;
  private $receiverId;
  private $groupToSend;
  private $message;
  private $notificationTitle;
  public  $emailIsSent = 0;
  public  $browserIsSent = 0;

  /**
   * ModelNotification constructor.
   * @param $adminNotificationType
   * @param $receiverId
   * @param $groupToSend
   */
  public function __construct( $message, $notificationTitle, $adminNotificationType, $receiverId, $groupToSend)
  {
    $this->message = $message;
    $this->notificationTitle = $notificationTitle;
    $this->adminNotificationType = $adminNotificationType;
    $this->receiverId = $receiverId;
    $this->groupToSend = $groupToSend;
  }

  public function notifyViaEmailOrBrowser()
  {

    switch ($this->adminNotificationType) {
      case 'all' :
        $notificationChannel = 'private-global-channel';
        $users = $this->returnAllActiveUsers();
        $this->sendBrowserNotifications($notificationChannel);
        $this->sendEmailNotifications($users,'newArticleNotify');
        break;
      case 'groupOfPeople' :
        switch ($this->groupToSend) {
          case 'admin' :
            $notificationChannel = "private-admin-channel";
            $this->sendBrowserNotifications($notificationChannel);
            $admins = $this->returnUsersByGroup('admin');
            $this->sendEmailNotifications($admins,'newArticleNotify');
            break;
          case 'moderator':
            $notificationChannel = "private-moderator-channel";
            $this->sendBrowserNotifications($notificationChannel);
            $moderators = $this->returnUsersByGroup('moderator');
            $this->sendEmailNotifications($moderators,'newArticleNotify');
            break;
          case 'registeredUser' :
            $notificationChannel = "private-registeredUser-channel";
            $this->sendBrowserNotifications($notificationChannel);
            $registeredUsers = $this->returnUsersByGroup('registeredUser');
            $this->sendEmailNotifications($registeredUsers,'newArticleNotify');
            break;
        }
        break;
      case 'certainUser' :
        $notificationChannel = "private-personal-message-" . $this->receiverId;
        $this->sendBrowserNotifications($notificationChannel);
        $user = $this->returnUserById($this->receiverId);
        $this->sendEmailNotification($user,'newArticleNotify');
        break;
    }

  }

  protected function sendEmailNotification($user,$viewName){
    $mailer = new Mailer();

    //TODO Refactor -> add Exception
    $mailer->sendMessage(
        $user->email,
        $this->notificationTitle,
        $viewName,
        ['message' => $this->message]);


    $this->emailIsSent = 1;
  }
  protected function sendEmailNotifications($arrayOfRecepients, $viewName)
  {
    $mailer = new Mailer();
    foreach ($arrayOfRecepients as $user) {
      //TODO Refactor -> add Exception
      $mailer->sendMessage(
          $user['email'],
          $this->notificationTitle,
          $viewName,
          ['message' => $this->message]);

    }
    $this->emailIsSent = 1;
  }
  private function sendBrowserNotifications($notificationChannel)
  {
    if ($notificationChannel != '') {
      $this->delegateToPusher($notificationChannel, $this->notificationTitle, $this->message, "", Yii::$app->request->getHostInfo() . '/dist/img/icon.png');
    }
    $this->browserIsSent =1;
  }
  private function sendTelegramNotification(){}


}