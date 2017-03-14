<?php

namespace app\components\notifications;


use app\components\EventTrigger;
use app\components\utility;
use app\models\Mailer;
use app\models\NotificationsManage;
use app\models\NotificationsMessageTemplates;
use app\traits\CustomSQL;
use app\traits\SendPushNotificationTrait;

class ModelNotification
{
  use SendPushNotificationTrait;
  use CustomSQL;

  public function notifyViaEmailOrBrowser(EventTrigger $eventTrigger)
  {
    /* Algorithm:
      1. Get notification settings
      2. Get to know who to notify (array of users)
      3. Iterate users
        3.1 Send Browser notification
        3.2 Send Email notification
    */
    // Getting permissions for particular event
    $sql = 'Select * from notifications_manage WHERE event_id=:event_id AND  (email="1" OR browser="1")';
    $notifications = NotificationsManage::findBySql($sql, [':event_id' => $eventTrigger->event_id])->all();

    foreach ($notifications as $notification) {
      switch ($notification['role']) {
        case 'admin':
          $eventNotificationTypes = $this->getEventNotificationTypes($eventTrigger->event_id, 'admin');
          if (!$eventNotificationTypes['browser'] && !$eventNotificationTypes['email']) {
            break;
          } else {
            // EAGER LOADING
            // Select all users that have role -> admin and allowed to send them email notifications
            $admins = $this->returnUsersWithNotificationsOnByGroup('admin');
            $this->determinEventType($eventTrigger, $admins, 'admin', $eventNotificationTypes);
            break;
          }
        case 'moderator':
          $eventNotificationTypes = $this->getEventNotificationTypes($eventTrigger->event_id, 'moderator');
          if (!$eventNotificationTypes['browser'] && !$eventNotificationTypes['email']) {
            break;
          } else {
            // EAGER LOADING
            // Select all users that have role -> moderator and allowed to send them email notifications
            $moderators = $this->returnUsersWithNotificationsOnByGroup('moderator');
            $this->determinEventType($eventTrigger, $moderators, 'moderator', $eventNotificationTypes);
            break;
          }
        case 'registeredUser':
          $eventNotificationTypes = $this->getEventNotificationTypes($eventTrigger->event_id, 'registeredUser');
          if (!$eventNotificationTypes['browser'] && !$eventNotificationTypes['email']) {
            break;
          } else {
            // EAGER LOADING
            // Select all users that have role -> registeredUser and allowed to send them email notifications
            $registeredUsers = $this->returnUsersWithNotificationsOnByGroup('registeredUser');
            $this->determinEventType($eventTrigger, $registeredUsers, 'registeredUser', $eventNotificationTypes);
          }
      }
    }
  }

  protected function determinEventType(EventTrigger $eventTrigger, $arrayOfRecepients, $roleToSend, $eventNotificationTypes)
  {
    switch ($eventTrigger->event_type) {
      case "NEWS_EVENT":

        $templateWords = ['$username', '$article_title[$articlelink]', '$article_title', '$author'];

        $templateWordsValues = [
            'email' => ['$article_title' => $eventTrigger->subject_name, '$author' => $eventTrigger->initiator_name, '$article_title[$articlelink]' => '<a href="' . $eventTrigger->notification_subject_url . '" target="_blank">' . $eventTrigger->subject_name . '</a>'],
            'browser' => ['$article_title' => $eventTrigger->subject_name, '$author' => $eventTrigger->initiator_name, '$article_title[$articlelink]' => $eventTrigger->subject_name]
        ];

        $this->composeAndSend($eventTrigger, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify', $eventNotificationTypes);

        break;
      case "USER_EVENT":

        $templateWords = ['$username', '$newUsername[$newUserLink]', '$newUsername', '$author'];

        $templateWordsValues = [
            'email' => ['$newUsername' => $eventTrigger->subject_name, '$newUsername[$newUserLink]' => '<a href="' . $eventTrigger->notification_subject_url . '" target="_blank">' . $eventTrigger->subject_name . '</a>'],
            'browser' => ['$newUsername' => $eventTrigger->subject_name, '$newUsername[$newUserLink]' => $eventTrigger->subject_name]
        ];

        $this->composeAndSend($eventTrigger, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify', $eventNotificationTypes);
        break;
      case "PROFILE_EVENT":

        $templateWords = ['$username', '$profileUsername[$profileUserLink]', '$profileUsername', '$author'];

        $templateWordsValues = [
            'email' => ['$newUsername' => $eventTrigger->subject_image, '$author' => $eventTrigger->initiator_name, '$profileUsername[$profileUserLink]' => '<a href="' . $eventTrigger->notification_subject_url . '" target="_blank">' . $eventTrigger->subject_name . '</a>'],
            'browser' => ['$newUsername' => $eventTrigger->subject_image, '$author' => $eventTrigger->initiator_name, '$profileUsername[$profileUserLink]' => $eventTrigger->subject_name]
        ];

        $this->composeAndSend($eventTrigger, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify', $eventNotificationTypes);
        break;
    }
  }

  /**
   * @param EventTrigger $eventTrigger
   * @param $roleToSend
   * @param $templateWords
   * @param $templateWordsValues
   * @param $arrayOfRecepients
   * @param $viewName
   * @param $eventNotificationTypes
   */
  protected function composeAndSend(EventTrigger $eventTrigger, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, $viewName, $eventNotificationTypes)
  {
    $emailEventMessage = '';
    $browserEventMessage = '';
    $notificationChannel = '';

    $mailer = null;

    foreach ($arrayOfRecepients as $user) {

      if ($user['emailNotification'] == 1 && $eventNotificationTypes['email']) {

        ($mailer == null) ? $mailer = new Mailer() : '';

        if ($emailEventMessage == '') {
          $emailEventMessage = NotificationsMessageTemplates::find()->where(['event_id' => $eventTrigger->event_id])->andWhere(['role' => $roleToSend])->one()->emailMessage;
        }

        if ($eventTrigger->initiator_name == $user['username']) {
          $templateWordsValues['email']['$author'] = "Вы ";
          $emailEventMessage = str_replace('добавил', 'добавили', $emailEventMessage);
        } else {
          $templateWordsValues['email']['$author'] = $eventTrigger->initiator_name;
        }


        $changedEmailEventMessage = utility::replaceTemplateWordsWithContextWords($templateWords, $templateWordsValues['email'], $emailEventMessage);

        //TODO Refactor -> add Exception
        // If notification for particular event is set
        if ($emailEventMessage != '') {
          $mailer->sendMessage(
              $user['email'],
              $mailer->getNewArticleAddedSubject(),
              $viewName,
              ['message' => str_replace('$username', $user->username, utility::replaceUsernameWithRealName($user['username'], $changedEmailEventMessage))]);
        }

      }

      if ($user['browser'] == 1 && $eventNotificationTypes['browser']) {

        if ($browserEventMessage == '') {
          $browserEventMessage = NotificationsMessageTemplates::find()->where(['event_id' => $eventTrigger->event_id])->andWhere(['role' => $roleToSend])->one()->browserMessage;
          // replace template words with real ones
          $changedBrowserEventMessage = utility::replaceTemplateWordsWithContextWords($templateWords, $templateWordsValues['browser'], $browserEventMessage);

          // Return channel name
          switch ($roleToSend) {
            case "admin":
              $notificationChannel = "private-admin-channel";
              break;
            case "moderator":
              $notificationChannel = "private-moderator-channel";
              break;
            case "registeredUser":
              $notificationChannel = "private-registeredUser-channel";
              break;
          }

          if ($notificationChannel != '') {
            $this->delegateToPusher($notificationChannel, $eventTrigger->event_name, $changedBrowserEventMessage, $eventTrigger->notification_subject_url, $eventTrigger->subject_image);
          }

        }

      }
      //TODO Add if statement for Mobile Push or Telegram notifications
    }
  }


  /**
   * Returns list of notification types [browser or email]
   */
  protected function getEventNotificationTypes($event_id, $role){
    return [
        'browser' => NotificationsManage::find()->where(['event_id' =>$event_id])->andWhere(['role' => $role])->one()->browser == 1,
        'email' => NotificationsManage::find()->where(['event_id' =>$event_id])->andWhere(['role' => $role])->one()->email == 1
    ];
  }
}

