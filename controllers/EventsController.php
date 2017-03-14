<?php

namespace app\controllers;

use app\components\utility;
use app\models\AddEventForm;
use app\models\NotificationsManage;
use app\models\NotificationsMessageTemplates;
use app\traits\AjaxReturnTrait;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class EventsController extends Controller
{
  use AjaxReturnTrait;

  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index', 'templates'],
            'rules' => [
                [
                    'actions' => ['index', 'templates', 'savenotifications', 'savemessagetemplates', 'addevent'],
                    'allow' => true,
                    'roles' => ['createUser'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
                'savenotifications' => ['post'],
                'savemessagetemplates' => ['post'],
            ],
        ],
    ];
  }

  public function getViewPath()
  {
    return Yii::getAlias('@app/views/events-management');
  }

  public function actionIndex()
  {
    $newsModel = NotificationsManage::find()->where(['model_id' => 1])->all();
    $userModel = NotificationsManage::find()->where(['model_id' => 2])->all();
    $profileModel = NotificationsManage::find()->where(['model_id' => 3])->all();

    return $this->render('index', ['newsModel' => $newsModel,
        'userModel' => $userModel,
        'profileModel' => $profileModel]);
  }

  public function actionAddevent(){

    if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
          $addEventform = new AddEventForm();


        $addEventform->load(Yii::$app->request->post());
        $addEventform->save();
      } else {
          header('', true, 403);
          echo "Forbidden";
      }
  }


  public function actionTemplates()
  {
    $newsMessages = NotificationsMessageTemplates::find()->where(['model_id' => 1])->all();
    $userMessages = NotificationsMessageTemplates::find()->where(['model_id' => 2])->all();
//    Yii::$app->utility->dd($userMessages);
    $profileMessages = NotificationsMessageTemplates::find()->where(['model_id' => 3])->all();

    return $this->render('templates', ['newsMessages' => $newsMessages,
        'userMessages' => $userMessages,
        'profileMessages' => $profileMessages]);
  }

  public function actionSavenotifications()
  {
    if (Yii::$app->request->isAjax) {
      $notificationSettings = NotificationsManage::find()->where(['event_id' => Yii::$app->request->post('event_id')])
          ->andWhere(['role' => Yii::$app->request->post('role')])->one();
      if (sizeof($notificationSettings) > 0) {

        if (Yii::$app->request->post('message_type') == "email") {
          $notificationSettings->email = Yii::$app->request->post('value');
          $notificationSettings->save();

          $this->returnAnswer(200, "Данные успешно сохранены");

        } elseif (Yii::$app->request->post('message_type') == "browser") {
          $notificationSettings->browser = Yii::$app->request->post('value');
          $notificationSettings->save();

          $this->returnAnswer(200, "Данные успешно сохранены");
        }


      } else {
        $this->returnAnswer(500, "Произошла ошибка при сохранении роли");
      }
    }

  }

  public function actionSavemessagetemplates()
  {
    if (Yii::$app->request->isAjax) {
      $notificationSettings = NotificationsMessageTemplates::find()->where(['event_id' => Yii::$app->request->post('event_id')])->all();

      if (sizeof($notificationSettings) > 0 && sizeof($notificationSettings) == 3) {
        if (Yii::$app->request->post('message_type') == "email") {
          $notificationSettings[0]->emailMessage = Yii::$app->request->post('adminMessage');
          $notificationSettings[1]->emailMessage = Yii::$app->request->post('moderatorMessage');
          $notificationSettings[2]->emailMessage = Yii::$app->request->post('registeredUserMessage');

          if ($notificationSettings[0]->save() && $notificationSettings[1]->save() && $notificationSettings[2]->save()) {
            $this->returnAnswer(200, "Данные успешно сохранены");
          } else {
            $this->returnAnswer(500, "Произошла ошибка при сохранении данных");
          }

        } elseif (Yii::$app->request->post('message_type') == "browser") {
          $notificationSettings[0]->browserMessage = Yii::$app->request->post('adminMessage');
          $notificationSettings[1]->browserMessage = Yii::$app->request->post('moderatorMessage');
          $notificationSettings[2]->browserMessage = Yii::$app->request->post('registeredUserMessage');

          if ($notificationSettings[0]->save() && $notificationSettings[1]->save() && $notificationSettings[2]->save()) {
            $this->returnAnswer(200, "Данные успешно сохранены");
          } else {
            $this->returnAnswer(500, "Произошла ошибка при сохранении данных");
          }

        }
      } else {
        $this->returnAnswer(500, "Ошибка!");
      }
    } else {
      $this->returnAnswer(404, "Несуществует");
    }
  }

}