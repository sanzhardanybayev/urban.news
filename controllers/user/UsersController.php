<?php

namespace app\controllers\user;

use app\components\EventController;
use app\components\utility;
use app\events\user\UserEvent;
use app\events\user\UserEventsInterface;
use app\models\AuthAssignment;
use app\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UsersController extends Controller implements UserEventsInterface
{
  use AjaxValidationTrait;
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                ['allow' => true, 'actions' => ['index'], 'roles' => ['admin']],
                ['allow' => true, 'actions' => ['block'], 'roles' => ['admin']],
                ['allow' => false, 'roles' => ['?','@'], 'denyCallback' =>
                    function ($rule, $action) {

                      \Yii::$app->session->setFlash(
                          'info',
                          'Вам нельзя просматривать эту страницу'
                      );

                      return $action->controller->redirect('/user/register');
                    }
                ]
            ],
        ]
    ];
  }

  /**
   * @return string
   */
  public function actionIndex()
  {

    $users = User::find()->where(['<>', 'id', \Yii::$app->user->identity->getId()])->all();

    return $this->render('index', [
        'users' => $users
    ]);

  }

  public function actionBlock($id = null){

    $eventController = new EventController('User', [UserEventsInterface::EVENT_ON_USER_BLOCK]);

    if($id != null){
      $user = User::findIdentity($id);
      if($user != null){
        switch ($user->isBlocked){
          case true:
            $user->unblock();
            //TODO :CHECK IT!

            \Yii::$app->response->format = Response::FORMAT_JSON;
            \Yii::$app->response->charset = 'UTF-8';
            \Yii::$app->response->data = "Пользователь разблокирован";
            \Yii::$app->response->setStatusCode(200, "Пользователь Разблокирован");
            \Yii::$app->response->send();
            \Yii::$app->end();
            break;
          case false:
            $user->block();

            //TODO :CHECK IT!
            $role = AuthAssignment::find()->where(['user_id' => $user->id])->one();
            if($role == null){
              $role = 'registeredUser';
            }else{
              $role = $role->item_name;
            }

            $userEvent = new UserEvent($role,$user->username,$user->username, UserEventsInterface::EVENT_ON_USER_BLOCK, 'USER_EVENT');
            $eventController->triggerEvent($userEvent->event_name, $userEvent);

            \Yii::$app->response->format = Response::FORMAT_JSON;
            \Yii::$app->response->charset = 'UTF-8';
            \Yii::$app->response->data = "Пользователь заблокирован";
            \Yii::$app->response->setStatusCode(200, "Пользователь Заблокирован");
            \Yii::$app->response->send();
            \Yii::$app->end();
            break;
        }

      }else{
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset = 'UTF-8';
        \Yii::$app->response->data = "Пользователь не найден";
        \Yii::$app->response->setStatusCode(404, "Пользователь не найден");
        \Yii::$app->response->send();
        \Yii::$app->end();
      }
    }

  }

}
