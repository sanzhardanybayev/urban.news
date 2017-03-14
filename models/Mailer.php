<?php

namespace app\models;


use app\components\utility;
use dektrium\user\Mailer as BaseMailer;
use Yii;

class Mailer extends BaseMailer
{

  static function getMailer()
  {
    return \Yii::$container->get(Mailer::className());
  }

  public function sendMessage($to, $subject, $view, $params = [])
  {
    /** @var \yii\mail\BaseMailer $mailer */
    $mailer = Yii::$app->mailer;
    $mailer->viewPath = $this->viewPath;
    $mailer->getView()->theme = Yii::$app->view->theme;

    if ($this->sender === null) {
      $this->sender = isset(Yii::$app->params['adminEmail']) ?
          Yii::$app->params['adminEmail']
          : 'no-reply@example.com';
    }

    return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
        ->setTo($to)
        ->setFrom($this->sender)
        ->setSubject($subject)
        ->send();
  }

  public function sendWelcomeMessage(User $user, Token $token = null, $role = 'admin', $showPassword = false)
  {

    return $this->sendMessage(
        $user->email,
        $this->getWelcomeSubject(),
        'welcome',
        ['user' => $user, 'token' => $token, 'role' => $role, 'module' => $this->module, 'showPassword' => $showPassword]
    );
  }


  public function notifyAdminOnNewRegistraton($role, User $registeredUser)
  {

    $admins = AuthAssignment::find()
        ->orWhere(['item_name' => 'admin'])
        ->all();

    foreach ($admins as $admin) {
      $user = User::findOne($admin->user_id);
      $this->sendMessage(
          $user->email,
          $this->getNewUserSubject(),
          'notifyAdmin',
          ['user' => $user, 'role' => $role, 'registeredUser' => $registeredUser]);
    }
    return true;
  }

  public function sendUserPasswordChanged(User $registeredUser)
  {
    $this->sendMessage(
        $registeredUser->email,
        $this->getPasswdChangedSubject(),
        'passwordChangedNotify',
        ['user' => $registeredUser]);
    return true;
  }

  /**
   * @param $notificationType
   * @param $event_type
   * @param $arrayOfRecepients
   * @param $event_id
   * @param null $roleToSend
   * @param $initiatorName
   * @param News|null $articleToBeReferenced
   * This function is final step of any Event trigger that is associated with email sending.
   * Depending on EVENT_TYPE, which are 3 overall, it determines what templates words to substitute with live ones.
   */
  public function sendEmailToGroupOfPeople($notificationType, $event_type, $arrayOfRecepients, $event_id, $roleToSend = null, $initiatorName, News $articleToBeReferenced = null)
  {
    switch ($event_type) {
      case "NEWS_EVENT":
        /*TODO Refactor variables below - Delete these variables after Unit Testing */
        $articleTitle = 'This is it';
        $articleLink = 'https://fixie.kz';

        $templateWords = ['$username', '$article_title[$articlelink]', '$article_title', '$author'];
        $templateWordsValues = ['$article_title' => 'This is it', '$author' => $initiatorName, '$article_title[$articlelink]' => '<a href="' . $articleLink . '" target="_blank">' . $articleTitle . '</a>'];

        $this->composeAndSend($notificationType, $event_id, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify');

        break;
      case "USER_EVENT":
        /*TODO Refactor variables below - Delete these variables after Unit Testing */
        $newUsername = 'Wenthworth Miller';
        $newUserLink = 'https://prison.break';

        $templateWords = ['$username', '$newUsername[$newUserLink]', '$newUsername', '$author'];
        $templateWordsValues = ['$newUsername' => $newUsername, '$author' => $initiatorName, '$newUsername[$newUserLink]' => '<a href="' . $newUserLink . '" target="_blank">' . $newUsername . '</a>'];

        $this->composeAndSend($notificationType, $event_id, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify');
        break;
      case "PROFILE_EVENT":
        /*TODO Refactor variables below - Delete these variables after Unit Testing */
        $profileUsername = 'Michael Jackson';
        $profileUserLink = 'https://michaeljackson.com';

        $templateWords = ['$username', '$profileUsername[$profileUserLink]', '$profileUsername', '$author'];
        $templateWordsValues = ['$newUsername' => $profileUsername, '$author' => $initiatorName, '$newUsername[$newUserLink]' => '<a href="' . $profileUserLink . '" target="_blank">' . $profileUsername . '</a>'];

        $this->composeAndSend($notificationType, $event_id, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, 'newArticleNotify');
        break;
    }
  }

  //TODO Delete when it's updated version is tested
  public function notifyAllUsersOnNewArticle(News $article, User $author)
  {
    $users = User::find()
        ->select('user.*')
        ->leftJoin('`notifications`', '`notifications`.`user_id` = `user`.`id`')
        ->where(['notifications.email' => 1])
        ->andWhere(['is not', 'confirmed_at', null])
        ->andWhere(['is', 'blocked_at', null])
        ->all();
    $host = Yii::$app->request->getHostInfo();

    foreach ($users as $user) {
      $this->sendMessage(
          $user->email,
          $this->getNewArticleAddedSubject(),
          'newArticleNotify',
          ['user' => $user,
              'article' => $article,
              'host' => $host,
              'author' => $author]);
    }

    return true;
  }

  public function getNewUserSubject()
  {
    return "Зарегистрирован новый пользователь";
  }

  public function getPasswdChangedSubject()
  {
    return "Пароль обновлен!";
  }

  public function getNewArticleAddedSubject()
  {
    return "Произошли изменения на сайте!";
  }

  private function composeAndSend($notificationType, $event_id, $roleToSend, $templateWords, $templateWordsValues, $arrayOfRecepients, $viewName)
  {
    switch ($notificationType) {
      case "email" :
        $eventMessage = NotificationsMessageTemplates::find()->where(['event_id' => $event_id])->andWhere(['role' => $roleToSend])->one()->emailMessage;

        $changedEventMessage = utility::replaceTemplateWordsWithContextWords($templateWords, $templateWordsValues, $eventMessage);

        foreach ($arrayOfRecepients as $user) {
          $this->sendMessage(
              $user->email,
              $this->getNewArticleAddedSubject(),
              $viewName,
              ['message' => str_replace('$username', $user->username, $changedEventMessage)]);
        }
        break;
      case "browser" :
        $eventMessage = NotificationsMessageTemplates::find()->where(['event_id' => $event_id])->andWhere(['role' => $roleToSend])->one()->browserMessage;

        $changedEventMessage = utility::replaceTemplateWordsWithContextWords($templateWords, $templateWordsValues, $eventMessage);

        foreach ($arrayOfRecepients as $user) {

          $this->sendMessage(
              $user->email,
              $this->getNewArticleAddedSubject(),
              $viewName,
              ['message' => str_replace('$username', $user->username, $changedEventMessage)]);
        }
    }

  }
}