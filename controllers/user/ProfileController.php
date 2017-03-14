<?php

namespace app\controllers\user;

use app\models\News;
use dektrium\user\Finder;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\ForbiddenHttpException;
use app\components\utility as Utility;

/**
 * ProfileController shows users profiles.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class ProfileController extends Controller
{
    /** @var Finder */
    protected $finder;

    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param Finder           $finder
     * @param array            $config
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
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['showit'], 'roles' => ['@','?']],
                ],
            ],
        ];
    }

    /**
     * Redirects to current user's profile.
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {

        return $this->redirect(['show', 'id' => \Yii::$app->user->getId()]);
    }

    /**
     * Shows user's profile.
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($id)
    {
        $profile = $this->finder->findProfileById($id);
        $this->view->params['profile_bar'] = $profile;
//	Yii::$app->utility->dd($profile);
        // make sure that he sees only his content
        if($id != Yii::$app->user->identity->getId())
        {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to see this page'));
        }

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $query = News::find()->where(['user_id' => $id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        return $this->render('show', [
            'models' => $models,
            'pages' => $pages,
            'profile' => $profile
        ]);

    }

    /**
     * Shows user's profile by it's username.
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShowit($username)
    {

        $user = $this->finder->findUserByUsername($username);
        $this->view->params['profile_bar'] = $user->profile;
//	Yii::$app->utility->dd($user->profile->user_id);
        $crud = false;

        if ($user === null) {
            throw new NotFoundHttpException();
        }

        // make sure that he sees only his content
        if((Yii::$app->user->can('createPost') && $user->id == Yii::$app->user->identity->getId()) || Yii::$app->user->can('createUser') ){
            $crud = true;
        }
        $query = News::find()->where(['user_id' => $user->id]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('show', [
            'models' => $models,
            'pages' => $pages,
            'profile' => $user->profile,
            'crud' => $crud
        ]);

    }
}
