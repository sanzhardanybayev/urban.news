<?php

namespace app\controllers;

use app\components\EventController;
use app\events\news\NewsEventsInterface;
use app\models\NewsForm as NewsForm;
use app\models\User;
use app\models\WebsiteSettings;
use app\traits\AjaxValidationTrait;
use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\Response;
use yii\web\Session;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\assets\utility;
use app\components\utility as Utilities;
use app\events\news\NewsEvent;


/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller implements NewsEventsInterface
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
                ['allow' => true, 'actions' => ['view'], 'roles' => ['@']],
                ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                ['allow' => true, 'actions' => ['updateone'], 'roles' => ['@']],
                ['allow' => false, 'roles' => ['?'], 'denyCallback' =>
                    function ($rule, $action) {

                      \Yii::$app->session->setFlash(
                          'info',
                          'Чтобы получить доступ к новостям, Вам нужно пройти регистрацию'
                      );

                      return $action->controller->redirect('/user/register');
                    },],
                ['allow' => true, 'actions' => ['show'], 'roles' => ['@']],
                ['allow' => true, 'actions' => ['create'], 'roles' => ['moderator', 'admin']],
                ['allow' => true, 'actions' => ['update'], 'roles' => ['moderator', 'admin']],
                ['allow' => true, 'actions' => ['delete'], 'roles' => ['moderator', 'admin']],
                ['allow' => true, 'actions' => ['publish'], 'roles' => ['moderator', 'admin']],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
                'publish' => ['POST'],
            ],
        ],
    ];
  }

  /**
   * Lists all News models.
   * @return mixed
   */
  public function actionIndex()
  {
    $query = News::find()->where(['active' => 1]);
    $countQuery = clone $query;
    $amountOfArticles = WebsiteSettings::findOne(1)->amountOfNewsOnNewsPage;
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $amountOfArticles]);

    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

    return $this->render('index', [
        'models' => $models,
        'pages' => $pages,
    ]);


  }

  /**
   * Displays a single News model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    $article = News::findOne($id);

    $message = Yii::$app->session->getFlash('message');

    // Sending error message to main.php layout
    if ($message !== null) {
      $this->view->params['message'] = $message;
      $this->view->params['name'] = Yii::$app->user->identity->username;
      $this->view->params['success'] = true;
    } else {
      $this->view->params['message'] = null;
      $this->view->params['name'] = null;
      $this->view->params['success'] = null;
    }

    // making sure that requested article exists
    if ($article === null) {
      throw new \yii\web\HttpException(404, 'Данная новость не сущестует.');
    } else {

      if (Yii::$app->user->can('updateOwnPost', ['news' => $article])) {
        Yii::$app->session->addFlash('allowToUpdate', true);
      }
      return $this->render('view', [
          'model' => $article,
      ]);
    }

  }

  public function actionMynews()
  {
    $searchModel = new NewsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Creates a new News model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */

//    TODO: Make sure that request is not sent twice, which implies creating another DB instance
  /**
   * @return string|Response
   */
  public function actionCreate()
  {
    $eventsController = new EventController('News', [NewsEventsInterface::EVENT_ON_NEW_ARTICLE_ADDED]);

    $file = new UploadForm();
    $newsModel = new News();
    $request = Yii::$app->request;

    if ($request->post()) {
      $file->preview_img = UploadedFile::getInstanceByName('News[preview_img]');

      // LOADING IMAGE
      if ($file->upload()) {
        $newsModel->load($request->post());

        $newsModel->preview_img = $file::$url;

        $newsModel->save();

        /** Send notifications to all users about new article */
        $authorName = User::findIdentity($newsModel->user_id)->username;

        $event = new NewsEvent($newsModel->id, $newsModel->title, NewsEventsInterface::EVENT_ON_NEW_ARTICLE_ADDED, $authorName, $newsModel->preview_img);

        $eventsController->triggerEvent($event->event_name, $event);

        Yii::$app->session->setFlash('message', 'Пост успешно добавлен');
        return $this->redirect(['news/' . $newsModel->id, 'model' => $newsModel]);
      } else {
        // if img loading fails - send error message
        Yii::$app->session->setFlash('message', 'Вышла ошибка при загрузке фото');
        return $this->redirect(['news/create']);
      }


    } else {
      $model = new News();
      return $this->render('create', [
          'model' => $model,
      ]);
    }
  }

  /**
   * Is used whenever admins edits someone else's article. Updates an existing News model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($user_id = null, $post_id = null)
  {
    $eventsController = new EventController('News', [NewsEventsInterface::EVENT_ON_TITLE_CHANGED,
        NewsEventsInterface::EVENT_ON_DESCRIPTION_CHANGED,
        NewsEventsInterface::EVENT_ON_CONTENT_CHANGED,
        NewsEventsInterface::EVENT_ON_PREVIEW_CHANGED]);

    $model = $this->findModel($post_id);
    $user_id = ($user_id) ? $user_id : Yii::$app->user->identity->getId();

    //TODO: move to filter
    if (!(Yii::$app->user->can('updateOwnPost', ['news' => $model]))) {
      throw  new ForbiddenHttpException('Вам нельзя редактировать чужие новости');
    }


    $this->view->params['crud'] = true;

    $message = Yii::$app->session->getFlash('message');

    // Sending error message to main.php layout
    if ($message !== null) {
      $this->view->params['message'] = $message;
      $this->view->params['name'] = Yii::$app->user->identity->username;
    } else {
      $this->view->params['message'] = null;
      $this->view->params['name'] = null;
    }

    $request = Yii::$app->request;

    if($request->isPost && $model->active == 1){
      if ($model->title != $request->post('News')['title']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_TITLE_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }

      if ($model->short_description != $request->post('News')['short_description']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_DESCRIPTION_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }

      if ($model->content != $request->post('News')['content']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_CONTENT_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }
    }


    if ($model->load(Yii::$app->request->post())) {

      $file = new UploadForm();
      $request = Yii::$app->request;

      $file->preview_img = UploadedFile::getInstanceByName('News[preview_img]');

      $authorName = User::findIdentity($model->user_id)->username;
      // LOADING IMAGE
      if ($file->preview_img != null) {
        if (!$file->upload($model)) {
          Yii::$app->session->setFlash('message', 'Произошла ошибка при обновлении обложки статьи');
          return $this->redirect(['view', 'id' => $model->id]);
        } else {
          /** Send email to all users about new article */
          if($model->active == 1) {
            $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_PREVIEW_CHANGED, $authorName, $model->preview_img);
            $eventsController->triggerEvent($event->event_name, $event);
          }
        }
      }
      if ($file->preview_img) {
        @unlink($model->preview_img);
        $model->preview_img = $file::$url;
      }
      $model->preview_img = $model->preview_img;
      $model->save();
      Yii::$app->session->setFlash('message', 'Пост успешно обновлен');
      return $this->redirect(['view', 'id' => $model->id]);


    } else {
      return $this->render('update', [
          'id' => Yii::$app->user->id,
          'model' => $model,
      ]);
    }
  }

  public function actionUpdateone($id = null)
  {

    $eventsController = new EventController('News', [NewsEventsInterface::EVENT_ON_TITLE_CHANGED,
        NewsEventsInterface::EVENT_ON_DESCRIPTION_CHANGED,
        NewsEventsInterface::EVENT_ON_CONTENT_CHANGED,
        NewsEventsInterface::EVENT_ON_PREVIEW_CHANGED]);


    $model = $this->findModel($id);
    $user_id = Yii::$app->user->identity->getId();

    if (!(Yii::$app->user->can('updateOwnPost', ['news' => $model]))) {
      throw  new ForbiddenHttpException('Вам нельзя редактировать чужие новости');
    }

    $this->view->params['crud'] = true;

    $message = Yii::$app->session->getFlash('message');

    // Sending error message to main.php layout
    if ($message !== null) {
      $this->view->params['message'] = $message;
      $this->view->params['name'] = Yii::$app->user->identity->username;
    } else {
      $this->view->params['message'] = null;
      $this->view->params['name'] = null;
    }

    $request = Yii::$app->request;

    if($request->isPost && $model->active == 1){
      if ($model->title != $request->post('News')['title']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_TITLE_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }

      if ($model->short_description != $request->post('News')['short_description']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_DESCRIPTION_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }

      if ($model->content != $request->post('News')['content']) {
        /** Send email to all users about new article */
        $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_CONTENT_CHANGED, $authorName, $model->preview_img);
        $eventsController->triggerEvent($event->event_name, $event);
      }
    }



    if ($model->load(Yii::$app->request->post())) {

      $file = new UploadForm();

      $file->preview_img = UploadedFile::getInstanceByName('News[preview_img]');

      $authorName = User::findIdentity($model->user_id)->username;
      // LOADING IMAGE
      if ($file->preview_img != null) {
        if (!$file->upload($model)) {
          Yii::$app->session->setFlash('message', 'Произошла ошибка при обновлении обложки статьи');
          return $this->redirect(['view', 'id' => $model->id]);
        } else {
          /** Send email to all users about new article */
          if($model->active == 1) {
            $event = new NewsEvent($model->id, $model->title, NewsEventsInterface::EVENT_ON_PREVIEW_CHANGED, $authorName, $model->preview_img);
            $eventsController->triggerEvent($event->event_name, $event);
          }
        }
      }

      if ($file->preview_img) {
        @unlink($model->preview_img);
        $model->preview_img = $file::$url;
      }
      $model->preview_img = $model->preview_img;
      $model->save();

      Yii::$app->session->setFlash('message', 'Пост успешно обновлен');
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
          'id' => Yii::$app->user->id,
          'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing News model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $eventController = new EventController('News', [NewsEventsInterface::EVENT_ON_ARTICLE_DELETED]);

    $article = $this->findModel($id);
    $authorName = User::findIdentity($article->user_id)->username;
    $articleTitle = $article->title;
    $articleImg = "";

    if(!empty($article->preview_img)){
      @unlink($article->preview_img);
    }

    $article->delete();

    $something = true;
    $return_json = ['status' => 'error'];
    if ($something == true) {
      $return_json = ['status' => 'success', 'message' => ' is successfully deleted'];
    }

    $event = new NewsEvent(null, $articleTitle, NewsEventsInterface::EVENT_ON_ARTICLE_DELETED, $authorName, $articleImg);
    $eventController->triggerEvent($event->event_name, $event);

    Yii::$app->response->format = Response::FORMAT_JSON;

    /** Send email to all users about new article */

//    $event = new NewsEvent();
//    $event->article = $article;
//    $event->author = User::findIdentity($article->user_id);
//    $this->trigger(NewsEventsInterface::EVENT_ON_NEW_ARTICLE_ADDED, $event);

    return $return_json;

  }

  /**
   * Publishes an existing News model.
   * @param integer $id
   * @return mixed
   */
  public function actionPublish($id)
  {
    $eventController = new EventController('News', [NewsEventsInterface::EVENT_ON_ARTICLE_PUBLISHED]);

    $article = $this->findModel($id);
    $article->active = (Yii::$app->request->post('status') == "true") ? 1 : 0;
    $article->save();
    if ($article->active == 1) {
      $authorName = User::findIdentity($article->user_id)->username;
      $event = new NewsEvent($article->id, $article->title, NewsEventsInterface::EVENT_ON_ARTICLE_PUBLISHED, $authorName, $article->preview_img);
      $eventController->triggerEvent($event->event_name, $event);
    }
    $allow = true;
    $return_json = ['status' => 'error'];

    if ($allow) {
      $return_json = ['status' => 'success', 'message' => ' is successfully published'];
    }

    Yii::$app->response->format = Response::FORMAT_JSON;
    return $return_json;

  }

  /**
   * Finds the News model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return News the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = News::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
