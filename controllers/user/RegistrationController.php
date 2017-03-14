<?php


namespace app\controllers\user;

use app\components\EventController;
use app\components\utility;
use app\events\user\UserEvent;
use app\events\user\UserEventsInterface;
use app\models\Notifications;
use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use app\models\ResendForm;
use app\models\User;
use app\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * RegistrationController is responsible for all registration process, which includes registration of a new account,
 * resending confirmation tokens, email confirmation and registration via social networks.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationController extends Controller implements UserEventsInterface
{
  use AjaxValidationTrait;
  use EventTrait;

  /**
   * Event is triggered after creating RegistrationForm class.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_BEFORE_REGISTER = 'beforeRegister';

  /**
   * Event is triggered after successful registration.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_AFTER_REGISTER = 'afterRegister';

  /**
   * Event is triggered before connecting user to social account.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_BEFORE_CONNECT = 'beforeConnect';

  /**
   * Event is triggered after connecting user to social account.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_AFTER_CONNECT = 'afterConnect';

  /**
   * Event is triggered before confirming user.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

  /**
   * Event is triggered before confirming user.
   * Triggered with \dektrium\user\events\UserEvent.
   */
  const EVENT_AFTER_CONFIRM = 'afterConfirm';

  /**
   * Event is triggered after creating ResendForm class.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_BEFORE_RESEND = 'beforeResend';

  /**
   * Event is triggered after successful resending of confirmation email.
   * Triggered with \dektrium\user\events\FormEvent.
   */
  const EVENT_AFTER_RESEND = 'afterResend';

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
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                ['allow' => true, 'actions' => ['register', 'connect'], 'roles' => ['?', '@']],
                ['allow' => true, 'actions' => ['confirm', 'resend'], 'roles' => ['?', '@']],
            ],
        ],
    ];
  }

  /**
   * Displays the registration page.
   * After successful registration if enableConfirmation is enabled shows info message otherwise
   * redirects to home page.
   *
   * @return string
   * @throws \yii\web\HttpException
   */
  public function actionRegister($role = 'registeredUser')
  {
    $eventController = new EventController('User', [UserEventsInterface::EVENT_ON_USER_CREATE]);

    if ($role != 'registeredUser') {
      $roles = ['moderator', 'admin'];
      if (!in_array($role, $roles)) {
        throw new NotFoundHttpException();
      }
    }

    if (!$this->module->enableRegistration) {
      throw new NotFoundHttpException();
    }

    /** @var RegistrationForm $model */
    $model = \Yii::createObject(RegistrationForm::className());
    $event = $this->getFormEvent($model);

    $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

    if (\Yii::$app->request->post('remote') == null) {
      $this->performAjaxValidation($model);
    }

    if ($model->load(\Yii::$app->request->post()) && $model->register($role)) {

      $this->trigger(self::EVENT_AFTER_REGISTER, $event);

      $userId = User::find()->where(['email' => $model->email])->one()->id;

      //Turn of notification for just created user
      $notifications = new Notifications();
      $notifications->user_id = $userId;
      $notifications->browser = '1';
      $notifications->email = '1';
      $notifications->save();

      $userEvent = new UserEvent($role, $userId , $model->username, UserEventsInterface::EVENT_ON_USER_CREATE, 'USER_EVENT');
      $eventController->triggerEvent($userEvent->event_name, $userEvent);

      if (\Yii::$app->request->isAjax) {
        $return_json = ['status' => 'success', 'message' => ' is successfully added'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return_json;
      } else {
        return $this->render('/message', [
            'title' => \Yii::t('user', 'Your account has been created'),
            'module' => $this->module,
        ]);
      }
    }

    return $this->render('register', [
        'model' => $model,
        'module' => $this->module,
    ]);
  }

  /**
   * Displays page where user can create new account that will be connected to social account.
   *
   * @param string $code
   *
   * @return string
   * @throws NotFoundHttpException
   */
  public function actionConnect($code)
  {
    $account = $this->finder->findAccount()->byCode($code)->one();

    if ($account === null || $account->getIsConnected()) {
      throw new NotFoundHttpException();
    }

    /** @var User $user */
    $user = \Yii::createObject([
        'class' => User::className(),
        'scenario' => 'connect',
        'username' => $account->username,
        'email' => $account->email,
    ]);

    $event = $this->getConnectEvent($account, $user);

    $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

    if ($user->load(\Yii::$app->request->post()) && $user->create()) {
      $account->connect($user);
      $this->trigger(self::EVENT_AFTER_CONNECT, $event);
      \Yii::$app->user->login($user, $this->module->rememberFor);
      return $this->goBack();
    }

    return $this->render('connect', [
        'model' => $user,
        'account' => $account,
    ]);
  }

  /**
   * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
   * shows error message.
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

    if ($user === null || $this->module->enableConfirmation == false) {
      throw new NotFoundHttpException();
    }

    $event = $this->getUserEvent($user);

    $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

    $user->attemptConfirmation($code);

    $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

    return $this->render('/message', [
        'title' => \Yii::t('user', 'Account confirmation'),
        'module' => $this->module,
    ]);
  }

  /**
   * Displays page where user can request new confirmation token. If resending was successful, displays message.
   *
   * @return string
   * @throws \yii\web\HttpException
   */
  public function actionResend()
  {


    if ($this->module->enableConfirmation == false) {
      throw new NotFoundHttpException();
    }

    /** @var ResendForm $model */
    $model = \Yii::createObject(ResendForm::className());

    $event = $this->getFormEvent($model);


    $this->trigger(self::EVENT_BEFORE_RESEND, $event);

    global $responseMessage;
    global $statusCode;
    $responseMessage = '';
    $statusCode = '';

    $this->performAjaxValidationAndSending($model);

    if ($model->load(\Yii::$app->request->post()) && $model->resend()) {
      $this->trigger(self::EVENT_AFTER_RESEND, $event);

      return $this->render('/message', [
          'title' => \Yii::t('user', 'A new confirmation link has been sent'),
          'module' => $this->module,
      ]);
    }

    return $this->render('resend', [
        'model' => $model,
    ]);
  }
}
