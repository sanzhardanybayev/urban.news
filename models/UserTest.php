<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\components\EventTrigger;
use app\components\notifications\ModelNotification;
use app\components\utility;
use dektrium\user\Finder;
use dektrium\user\Mailer;
use dektrium\user\models\Account;
use dektrium\user\models\Profile;
use dektrium\user\Module;
use Yii;
use yii\web\Application as WebApplication;

use dektrium\user\models\User as BaseUser;
use app\events\user\UserEventsInterface;
use app\events\user\UserEvent;

class UserTest extends BaseUser implements UserEventsInterface
{
  /**
   * @param string $username
   */
  public function setUsername(string $username)
  {
    $this->username = $username;
  }

  /**
   * @param string $email
   */
  public function setEmail(string $email)
  {
    $this->email = $email;
  }
  /**
   * @return object
   */
  protected function getMailer()
  {
    return \Yii::$container->get(Mailer::className());
  }

  static function getGlobalMailer()
  {
    return \Yii::$container->get(Mailer::className());
  }

  /** @inheritdoc */
  public function beforeSave($insert)
  {

    return parent::beforeSave($insert);
  }

  public function register($crole = "")
  {
//    $this->on(UserEventsInterface::EVENT_ON_REGISTER,[$this, 'onRegister']);

    $role = $crole;
    if ($this->getIsNewRecord() == false) {
      throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
    }

    $transaction = $this->getDb()->beginTransaction();

    try {
      $this->confirmed_at = $this->module->enableConfirmation ? null : time();
      $this->password = $this->module->enableGeneratingPassword ? Password::generate(8) : $this->password;

      $this->trigger(self::BEFORE_REGISTER);

      if (!$this->save()) {
        $transaction->rollBack();
        return false;
      }


      if ($this->module->enableConfirmation) {
        /** @var Token $token */
        $token = \Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
        $token->link('user', $this);
      }

      $this->mailer->sendWelcomeMessage($this, isset($token) ? $token : null, $role);
      $this->trigger(self::AFTER_REGISTER);

      $transaction->commit();

      return true;
    } catch (\Exception $e) {
      $transaction->rollBack();
      \Yii::warning($e->getMessage());
      return false;
    }
  }

  public function onRegister(UserEvent $event)
  {
    $this->mailer->notifyAdminOnNewRegistraton($event->role, $event->registeredUser);
  }

  public function onUserCreate(UserEvent $event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Добавлен новый пользователь', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }

  public function onUserDelete($event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Удалился пользователь', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }

  public function onUserBlock($event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Заблокирован пользователь', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }

  public function onUsernameChange($event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Смена логина', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }

  public function onPasswordChange($event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Смена пароля', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }

  public function onEmailChange($event)
  {
    $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

    $eventTrigger = new EventTrigger($event_id, 'Смена почты', null, $event->event_type, $event->username, $event->user_id, null);

    $modelNotification = new ModelNotification();
    $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
  }


  public function onPasswordUpdate(UserEvent $event)
  {
    User::getGlobalMailer()->sendUserPasswordChanged($event->registeredUser);
  }


  public function getNotifications()
  {

    return $this->hasMany(Notifications::className(), ['user_id' => 'id']);

  }

  public static function getRoleName($user_id)
  {
    return AuthAssignment::find()->where(['user_id' => $user_id])->select('item_name')->one();
  }

  public function getauth_assignment()
  {
    return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
  }

}
