<?php

namespace app\controllers;

use app\components\notifications\AdminNotifications;
use app\components\utility;
use app\events\news\NewsEventsInterface;
use app\models\AuthAssignment;
use app\models\EntryForm;
use app\models\News;

use app\models\WebsiteSettings;
use app\traits\AjaxReturnTrait;
use dektrium\user\models\User;
use Yii;
use yii\authclient\Collection;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
//use app\components\utility as Utility;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;


class SiteController extends Controller
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
            'only' => ['logout'],
            'rules' => [
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['post'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
                'notify' => ['post']
            ],
        ],
    ];
  }

  /**
   * @inheritdoc
   */
  public function actions()
  {
    return [
        'error' => [
            'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
            'class' => 'yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    $query = News::find()->where(['active' => 1])
        ->orderBy(['created_at' => SORT_DESC]);

    $countQuery = clone $query;
    $amountOfArticlesPerPage = WebsiteSettings::findOne(1)->amountOfNewsOnMainPage;
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $amountOfArticlesPerPage]);

    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

//        Utility::dd($pages);
    return $this->render('index', [
        'models' => $models,
        'pages' => $pages,
        'isGuest' => Yii::$app->user->isGuest,
    ]);
  }

  public function actionTest(){
    $query = News::find()->where(['active' => 1])
        ->orderBy(['created_at' => SORT_DESC]);

    $countQuery = clone $query;
    $amountOfArticlesPerPage = WebsiteSettings::findOne(1)->amountOfNewsOnMainPage;
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $amountOfArticlesPerPage]);

    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

    return $this->render('indextest', [
        'models' => $models,
        'pages' => $pages,
        'isGuest' => Yii::$app->user->isGuest,
        'test' => true
    ]);
  }

  /**
   * Login action.
   *
   * @return string
   */
  public function actionLogin()
  {

    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }
    return $this->render('login', [
        'model' => $model,
    ]);
  }

  /**
   * Signup action.
   *
   * @return string
   */
  public function actionSignup()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      $model->signup();
      return $this->goBack();
    }
    return $this->render('signup', [
        'model' => $model,
    ]);
  }

  /**
   * Logout action.
   *
   * @return string
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }

  /**
   * Displays contact page.
   *
   * @return string
   */
  public function actionContact()
  {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
    }
    return $this->render('contact', [
        'model' => $model,
    ]);
  }

  public function actionSay($message = "hello")
  {

    return $this->render('say', ['message' => $message]);
  }

  public function actionEntry()
  {
    $model = new EntryForm();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {

      return $this->render('entry-confirm', ['model' => $model]);
    } else {
      return $this->render('entry', ['model' => $model]);
    }
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    return $this->render('about');
  }

  public function actionNotify(){
    $post = Yii::$app->request->post();
    if(isset($post['message']) && isset($post['receivers']) && (isset($post['user_id']) || isset($post['group_name']))){
      $notifications = new AdminNotifications($post['message'],'Сообщение от администратора', $post['receivers'], $post['user_id'], $post['group_name']);
      $notifications->notifyViaEmailOrBrowser();
      if($notifications->emailIsSent && $notifications->browserIsSent){
        $this->returnAnswer(200, "Уведомление успешно отправлено!");
      }else{
        $this->returnAnswer(500, "Произошла ошибка при отправке уведомлений");
      }
    }
    else{
      $this->returnAnswer(400, "Добавьте текст сообщения и выберите кому его отправить");
    }
  }
}
