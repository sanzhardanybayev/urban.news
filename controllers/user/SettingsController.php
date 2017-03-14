<?php


namespace app\controllers\user;

use app\components\EventController;
use app\components\utility;
use app\events\profile\ProfileEvent;
use app\events\profile\ProfileEventsInterface;
use app\events\user\UserEventsInterface;
use app\models\AuthAssignment;
use app\models\Notifications;
use app\models\UploadForm;
use app\models\WebsiteSettings;
use app\models\WebsiteSettingsForm;
use dektrium\user\Finder;
use app\models\Profile;
use dektrium\user\models\SettingsForm;
use app\models\User;
use dektrium\user\Module;
use app\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\user\SettingsForm as BaseSettingsForm;
use app\events\user\UserEvent;
use app\components\PusherCreator as Pusher;

//require ('../vendor/pusher/pusher-php-server/lib/Pusher.php');
/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends Controller implements UserEventsInterface, ProfileEventsInterface
{
  use AjaxValidationTrait;
  use EventTrait;

  /**
   * Event is triggered before updating user's profile.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_BEFORE_PROFILE_UPDATE = 'beforeProfileUpdate';

  /**
   * Event is triggered after updating user's profile.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_AFTER_PROFILE_UPDATE = 'afterProfileUpdate';

  /**
   * Event is triggered before updating user's account settings.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_BEFORE_ACCOUNT_UPDATE = 'beforeAccountUpdate';

  /**
   * Event is triggered after updating user's account settings.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_AFTER_ACCOUNT_UPDATE = 'afterAccountUpdate';

  /**
   * Event is triggered before changing users' email address.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

  /**
   * Event is triggered after changing users' email address.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_AFTER_CONFIRM = 'afterConfirm';

  /**
   * Event is triggered before disconnecting social account from user.
   * Triggered with \dektrium\user\events\ConnectEvent.
   */
  const EVENT_BEFORE_DISCONNECT = 'beforeDisconnect';

  /**
   * Event is triggered after disconnecting social account from user.
   * Triggered with \dektrium\user\events\ConnectEvent.
   */
  const EVENT_AFTER_DISCONNECT = 'afterDisconnect';

  /**
   * Event is triggered before deleting user's account.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_BEFORE_DELETE = 'beforeDelete';

  /**
   * Event is triggered after deleting user's account.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_AFTER_DELETE = 'afterDelete';

  /** @inheritdoc */
  public $defaultAction = 'profile';

  /** @var Finder */
  protected $finder;

  /**
   * @param string $id
   * @param \yii\base\Module $module
   * @param Finder $finder
   * @param array $config
   */
  public function __construct($id, $module, Finder $finder, $config = [])
  {
    $this->finder = $finder;
    parent::__construct($id, $module, $config);
  }

  /** @inheritdoc */
  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'disconnect' => ['post'],
                'delete' => ['post'],
                'websitesettings' => ['post'],
                'notifications' => ['post'],
            ],
        ],
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['profile', 'account', 'networks', 'disconnect', 'delete', 'saveprofile'],
                    'roles' => ['@', 'createUser'],
                ],
                [
                    'allow' => true,
                    'actions' => ['id'],
                    'roles' => ['createUser'],
                ],
                [
                    'allow' => true,
                    'actions' => ['notifications'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['websitesettings'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['saveidprofile', 'setrole'],
                    'roles' => ['createUser'],
                ],
                [
                    'allow' => true,
                    'actions' => ['confirm', 'pusher'],
                    'roles' => ['?', '@'],
                ],
            ],
        ],
    ];
  }

  /**
   * Shows profile settings form.
   *
   * @return string|\yii\web\Response
   */
  public function actionProfile()
  {
    $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());


    $this->view->params['profile_bar'] = $model;

    if ($model == null) {
      $model = \Yii::createObject(Profile::className());
      $model->link('user', \Yii::$app->user->identity);
    }

    $event = $this->getProfileEvent($model);

    $this->performAjaxValidation($model);

    $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
    if ($model->load(\Yii::$app->request->post()) && $model->save()) {
      \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
      $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
      return $this->refresh();
    }

    return $this->render('profile', [
        'model' => $model,
    ]);
  }

  /**
   * Shows profile settings form.
   *
   * @return string|\yii\web\Response
   */
  public function actionSaveprofile()
  {
    $eventController = new EventController('Profile', [ProfileEventsInterface::EVENT_ON_AVATAR_CHANGED,
        ProfileEventsInterface::EVENT_ON_NAME_CHANGED,
        ProfileEventsInterface::EVENT_ON_PUBLIC_EMAIL_CHANGED,
        ProfileEventsInterface::EVENT_ON_BIO_CHANGED,
        ProfileEventsInterface::EVENT_ON_WEBSITE_CHANGED]);

    $user = User::findIdentity(\Yii::$app->user->identity->getId());
    $model = Profile::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->one();

    $file = new UploadForm();

    $message = Yii::$app->session->getFlash('message');
    // Sending error message to main.php layout
    if ($message !== null) {
      $this->view->params['message'] = $message;
      $this->view->params['name'] = Yii::$app->user->identity->username;
    } else {
      $this->view->params['message'] = null;
      $this->view->params['name'] = null;
    }

    $this->view->params['profile_bar'] = $model;

    if ($model == null) {
      $model = \Yii::createObject(Profile::className());
      $model->link('user', \Yii::$app->user->identity);
    }

    $this->performAjaxValidation($model);
    $oldValues = clone $model;

    if ($model->load(\Yii::$app->request->post())) {
      $file->preview_img = UploadedFile::getInstanceByName('Profile[avatar]');
      $old_avatar = $model->avatar;
      // LOADING IMAGE
      if (!$file->uploadavatar($model) && $file->preview_img != null) {
        // if img loading fails - send error message
        Yii::$app->session->setFlash('message', 'Вышла ошибка при загрузке фото');
        return $this->redirect(['/user/settings/account#profile/', 'model' => $model]);
      } else {
        if ($file->preview_img != null) {

          $role = User::getRoleName($user->id);
          $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_AVATAR_CHANGED, 'PROFILE_EVENT');
          $eventController->triggerEvent($profileEvent->event_name, $profileEvent);

          @unlink($old_avatar);
        }
        $model->save();

        if ($oldValues->name != Yii::$app->request->post('Profile')['name']) {
          $role = User::getRoleName($user->id);
          $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_NAME_CHANGED, 'PROFILE_EVENT');
          $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
        }

        if ($oldValues->bio != Yii::$app->request->post('Profile')['bio']) {
          $role = User::getRoleName($user->id);
          $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_BIO_CHANGED, 'PROFILE_EVENT');
          $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
        }

        if ($oldValues->public_email != Yii::$app->request->post('Profile')['public_email']) {
          $role = User::getRoleName($user->id);
          $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_PUBLIC_EMAIL_CHANGED, 'PROFILE_EVENT');
          $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
        }

        if ($oldValues->website != Yii::$app->request->post('Profile')['website']) {
          $role = User::getRoleName($user->id);
          $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_WEBSITE_CHANGED, 'PROFILE_EVENT');
          $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
        }


//        $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
        return $this->redirect(['/user/settings/account/#profile/', 'model' => $model]);
      }
    }

    return $this->render('profile', [
        'model' => $model,
    ]);

  }

  public function actionSaveidprofile($id)
  {
    $eventController = new EventController('Profile', [ProfileEventsInterface::EVENT_ON_AVATAR_CHANGED,
        ProfileEventsInterface::EVENT_ON_NAME_CHANGED,
        ProfileEventsInterface::EVENT_ON_PUBLIC_EMAIL_CHANGED,
        ProfileEventsInterface::EVENT_ON_BIO_CHANGED,
        ProfileEventsInterface::EVENT_ON_WEBSITE_CHANGED]);
    $user = User::findOne($id);

    if ($user != null) {

      $model = $this->finder->findProfileById($user->id);
      $file = new UploadForm();

      $message = Yii::$app->session->getFlash('message');
      // Sending error message to main.php layout
      if ($message !== null) {
        $this->view->params['message'] = $message;
        $this->view->params['name'] = Yii::$app->user->identity->username;
      } else {
        $this->view->params['message'] = null;
        $this->view->params['name'] = null;
      }

      $this->view->params['profile_bar'] = $model;

      if ($model == null) {
        $model = \Yii::createObject(Profile::className());
        $model->link('user', \Yii::$app->user->identity);
      }

      $this->performAjaxValidation($model);
      $oldValues = clone $model;

      if ($model->load(\Yii::$app->request->post())) {
        $file->preview_img = UploadedFile::getInstanceByName('Profile[avatar]');
        $old_avatar = $model->avatar;
        // LOADING IMAGE
        if (!$file->uploadavatar($model) && $file->preview_img != null) {
          // if img loading fails - send error message
          Yii::$app->session->setFlash('message', 'Вышла ошибка при загрузке фото');
          return $this->redirect(['/user/settings/account#profile/', 'model' => $model]);
        } else {
          if ($file->preview_img != null) {

            $role = User::getRoleName($user->id);
            $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_AVATAR_CHANGED, 'PROFILE_EVENT');
            $eventController->triggerEvent($profileEvent->event_name, $profileEvent);

            @unlink($old_avatar);
          }
          $model->save();

          if ($oldValues->name != Yii::$app->request->post('Profile')['name']) {
            $role = User::getRoleName($user->id);
            $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_NAME_CHANGED, 'PROFILE_EVENT');
            $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
          }

          if ($oldValues->bio != Yii::$app->request->post('Profile')['bio']) {
            $role = User::getRoleName($user->id);
            $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_BIO_CHANGED, 'PROFILE_EVENT');
            $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
          }

          if ($oldValues->public_email != Yii::$app->request->post('Profile')['public_email']) {
            $role = User::getRoleName($user->id);
            $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_PUBLIC_EMAIL_CHANGED, 'PROFILE_EVENT');
            $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
          }

          if ($oldValues->website != Yii::$app->request->post('Profile')['website']) {
            $role = User::getRoleName($user->id);
            $profileEvent = new ProfileEvent($role, $user->id, $user->username, ProfileEventsInterface::EVENT_ON_WEBSITE_CHANGED, 'PROFILE_EVENT');
            $eventController->triggerEvent($profileEvent->event_name, $profileEvent);
          }


//        $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
          \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
          return $this->redirect(['/user/settings/id/'. $id .'/', 'model' => $model]);
        }
      }

      return $this->render('profile', [
          'model' => $model,
      ]);
    } else {
      return new NotFoundHttpException('Такого пользователя не существует');
    }

  }

  /**
   * Displays page where user can update account settings (username, email or password).
   *
   * @return string|\yii\web\Response
   */
  public function actionAccount()
  {
    /** @var SettingsForm $model */
    $model = \Yii::createObject(SettingsForm::className());

    if (Yii::$app->user->can('createUser')) {
      $websiteSettings = \Yii::createObject(WebsiteSettingsForm::className());
    } else {
      $websiteSettings = null;
    }

    //start
    $profile = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

    if ($profile == null) {
      $profile = \Yii::createObject(Profile::className());
      $profile->link('user', \Yii::$app->user->identity);
    }

    if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
      \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
      return $this->refresh();
    }

    if (\Yii::$app->request->post('external') != null) {
      $this->performAjaxValidationUpdate($model);
    } else {
      $this->performAjaxValidation($model);
    }


    $this->view->params['profile_bar'] = $this->finder->findProfileById(Yii::$app->user->identity->id);

    return $this->render('account', [
        'model' => $model,
        'profile' => $profile,
        'websiteSettingsForm' => $websiteSettings
//            'action' => $action
    ]);
  }


  public function actionId($id)
  {
    $chosenUser = User::findOne($id);

    if (Yii::$app->user->can('createUser')) {
      $websiteSettings = \Yii::createObject(WebsiteSettingsForm::className());
    } else {
      $websiteSettings = null;
    }


    if ($chosenUser != null) {
      /** @var SettingsForm $model */
      $model = \Yii::createObject(BaseSettingsForm::className(), [$chosenUser]);

      //start
      $profile = $this->finder->findProfileById($id);

      if ($profile == null) {
        $profile = \Yii::createObject(Profile::className());
        $profile->link('user', \app\models\User::findOne($id));
      }

      if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
        return $this->refresh();
      }

      if (\Yii::$app->request->post('external') != null) {
        $this->performAjaxValidationUpdate($model);
      } else {
        $this->performAjaxValidation($model);
      }

      $this->view->params['profile_bar'] = $profile;

      // Required to make this page re-usable with /user/settings/username page
      $action = Yii::$app->request->getUrl();

      return $this->render('account', [
          'model' => $model,
          'profile' => $profile,
          'action' => $action,
          'id' => $id,
          'websiteSettingsForm' => $websiteSettings
      ]);
    } else {
      throw  new NotFoundHttpException('User can not be find');
    }

  }

  /**
   * Attempts changing user's email address.
   *
   * @param int $id
   * @param string $code
   *
   * @return string
   * @throws \yii\web\HttpException
   */
  public function actionConfirm($id, $code)
  {
    $user = $this->finder->findUserById($id);

    if ($user === null || $this->module->emailChangeStrategy == Module::STRATEGY_INSECURE) {
      throw new NotFoundHttpException();
    }

    $event = $this->getUserEvent($user);

    $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
    $user->attemptEmailChange($code);
    $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

    return $this->redirect(['account']);
  }

  /**
   * Displays list of connected network accounts.
   *
   * @return string
   */
  public function actionNetworks()
  {
    return $this->render('networks', [
        'user' => \Yii::$app->user->identity,
    ]);
  }

  /**
   * Disconnects a network account from user.
   *
   * @param int $id
   *
   * @return \yii\web\Response
   * @throws \yii\web\NotFoundHttpException
   * @throws \yii\web\ForbiddenHttpException
   */
  public function actionDisconnect($id)
  {
    $account = $this->finder->findAccount()->byId($id)->one();

    if ($account === null) {
      throw new NotFoundHttpException();
    }
    if ($account->user_id != \Yii::$app->user->id) {
      throw new ForbiddenHttpException();
    }

    $event = $this->getConnectEvent($account, $account->user);

    $this->trigger(self::EVENT_BEFORE_DISCONNECT, $event);
    $account->delete();
    $this->trigger(self::EVENT_AFTER_DISCONNECT, $event);

    return $this->redirect(['networks']);
  }

  /**
   * Completely deletes user's account.
   *
   * @return \yii\web\Response
   * @throws \Exception
   */
  public function actionDelete($id = null)
  {
    $eventController = new EventController('User', [UserEventsInterface::EVENT_ON_USER_DELETE]);

    if (!$this->module->enableAccountDelete) {
      throw new NotFoundHttpException(\Yii::t('user', 'Not found'));
    }
    $user = User::findIdentity($id);
    $userEvent = new UserEvent($user->getRoleName($id), $user->username, $user->username, UserEventsInterface::EVENT_ON_USER_DELETE, 'USER_EVENT');
    $avatar = $user->profile->avatar;

    /** AJAX REQUEST */
    if (\Yii::$app->request->isAjax && $id != null) {

      $event = $this->getUserEvent($user);
      $this->trigger(self::EVENT_BEFORE_DELETE, $event);


      $user->delete();
      if(!empty($avatar)){
        @unlink($avatar);
      }
      $eventController->triggerEvent($userEvent->event_name, $userEvent);
      $oldRole = AuthAssignment::find()
          ->where(['user_id' => $id])
          ->one();



      $notificationSettings = Notifications::findOne($id);

      if ($notificationSettings != null) {
        $notificationSettings->delete();
      }

      if ($oldRole != null) {
        $oldRole->delete();
      }

      $this->trigger(self::EVENT_AFTER_DELETE, $event);

      $return_json = ['status' => 'success', 'message' => ' is successfully removed'];
      Yii::$app->response->format = Response::FORMAT_JSON;
      return $return_json;
    } else {
      /** @var User $user */
      $user = \Yii::$app->user->identity;
      $event = $this->getUserEvent($user);

      $copiedUser = $user;

      \Yii::$app->user->logout();

      $this->trigger(self::EVENT_BEFORE_DELETE, $event);

      $user->delete();
      if(!empty($avatar)){
        @unlink($avatar);
      }
      $this->trigger(self::EVENT_AFTER_DELETE, $event);

      $oldRole = AuthAssignment::find()
          ->where(['user_id' => $id])
          ->one();

      $oldProfile = Profile::find()
          ->where(['user_id' => $id])
          ->one();

      if ($oldProfile != null) {
        if(!empty($oldProfile->avatar)){
          @unlink($oldProfile->avatar);
        }
        $oldProfile->delete();
      }

      $notificationSettings = Notifications::findOne($id);

      if ($notificationSettings != null) {
        $notificationSettings->delete();
      }

      if ($oldRole != null) {
        $oldRole->delete();
      }

      $eventController->triggerEvent($userEvent->event_name, $userEvent);

      \Yii::$app->session->setFlash('info', \Yii::t('user', 'Your account has been completely deleted'));

      return $this->goHome();
    }
  }

  public function actionSetrole($id = null, $role = '')
  {

    if ($id == null) {
      throw new NotFoundHttpException(\Yii::t('user', 'Not found'));
    } else if (Yii::$app->request->isAjax) {
      $user = User::findIdentity($id);
      if ($user != null) {

        $oldRole = AuthAssignment::find()
            ->where(['user_id' => $id])
            ->one();

        if ($oldRole != null) {
          $oldRole->delete();
        }

        /** Assigning role to this user */
        $auth = Yii::$app->authManager;
        $newRole = $auth->getRole($role);
        $auth->assign($newRole, $user->id);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset = 'UTF-8';
        \Yii::$app->response->data = "Роль успешно обновлена!";
        \Yii::$app->response->send();
        \Yii::$app->end();

      } else {
        //TODO: Return error
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset = 'UTF-8';
        \Yii::$app->response->data = "Произошла ошибка при обновлении роли";
        \Yii::$app->response->setStatusCode(500, "Произошла ошибка при обновлении роли");
        \Yii::$app->response->send();
        \Yii::$app->end();
      }
    }
  }

  public function actionNotifications()
  {
    $id = \Yii::$app->request->post('user_id');
    $user = User::findIdentity($id);

    if ($user == null) {
      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset = 'UTF-8';
      \Yii::$app->response->data = "Пользователь не существует";
      \Yii::$app->response->setStatusCode(500, "Пользователь не существует");
      \Yii::$app->response->send();
      \Yii::$app->end();
    } else if (Yii::$app->request->isAjax) {
      $browserNotification = \Yii::$app->request->post('browser');
      $emailNotification = \Yii::$app->request->post('email');
      $notifications = Notifications::find()->where(['user_id' => $id])->one();

      if ($notifications == null) {
        $notifications = new Notifications();
        $notifications->user_id = $id;
        $notifications->browser = $browserNotification;
        $notifications->email = $emailNotification;
        $notifications->save();
      } else {
        $notifications->browser = $browserNotification;
        $notifications->email = $emailNotification;
        $notifications->save();
      }

      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset = 'UTF-8';
      \Yii::$app->response->data = "Данные сохранены!";
      \Yii::$app->response->send();
      \Yii::$app->end();

    } else {
      //TODO: Return error
      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset = 'UTF-8';
      \Yii::$app->response->data = "Произошла ошибка при обновлении данных";
      \Yii::$app->response->setStatusCode(500, "Произошла ошибка при обновлении данных");
      \Yii::$app->response->send();
      \Yii::$app->end();
    }
  }

  public function actionPusher()
  {
    if (!Yii::$app->user->isGuest) {

      $pusher = Yii::$app->pusher;
      $presence_data = array('name' => Yii::$app->user->identity->username);
      echo $pusher->_pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], Yii::$app->user->getId(), $presence_data);
    } else {
      header('', true, 403);
      echo "Forbidden";
    }

  }

  public function actionWebsitesettings()
  {
    $websiteSettings = new WebsiteSettingsForm();


    if (Yii::$app->request->post('remote') == null && Yii::$app->request->isAjax && $websiteSettings->load(Yii::$app->request->post())) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return $websiteSettings->validate();
    } else if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
      $websiteSettings = new WebsiteSettingsForm();
      $websiteSettings->load(Yii::$app->request->post());
      $websiteSettings->save();
    } else {
      header('', true, 403);
      echo "Forbidden";
    }
  }
}
