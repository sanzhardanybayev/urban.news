<?php

namespace app\models;

use dektrium\user\Finder;
use dektrium\user\Mailer;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use app\components\utility as Utility;

class NewsForm  extends  Model
{
    public $title;
    public $short_description;
    public $content;
    public $preview_img;
    public $author;
    protected $id;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

//    public function behaviors()
//    {
//        return [
//            TimestampBehavior::className(),
//        ];
//    }

    public function __construct( $config = [])
    {
        $this->mailer = new Mailer();
        $this->finder = new Finder();
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'active'], 'integer'],
            [['content', 'short_description','title'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'preview_img', 'title'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'short_description' => 'Краткое описание',
            'content' => 'Содержание новости',
            'preview_img' => 'Обложка новости',
            'author' => 'Автор',
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'News';
    }


    public function createArticle($file, $request)
    {

        if (!$this->validate()) {
            return false;
        }

        $file->preview_img = UploadedFile::getInstanceByName('News[preview_img]');

        // LOADING IMAGE

        if ($file->upload($this)) {

            $this->title = $request->post('News')['title'];
            $this->author = Yii::$app->user->identity->getId();
            $this->short_description = $request->post('News')['short_description'];
            $this->content = $request->post('News')['content'];
            $this->save();
            Yii::$app->session->setFlash('message', 'Пост успешно добавлен');
            return $this->redirect(['news/'.$this->id, 'model'=> $this]);
        }
        else{
            // if img loading fails - send error message
            Yii::$app->session->setFlash('message', 'Вышла ошибка при загрузке фото');
            return $this->redirect(['news/create']);
        }

//        $user = $this->finder->findUserByEmail($this->email);
//
//        if ($user instanceof User && !$user->isConfirmed) {
//            /** @var Token $token */
//            $token = \Yii::createObject([
//                'class' => Token::className(),
//                'user_id' => $user->id,
//                'type' => Token::TYPE_CONFIRMATION,
//            ]);
//            $token->save(false);
//            $this->mailer->sendConfirmationMessage($user, $token);
//        }
//
//        \Yii::$app->session->setFlash(
//            'info',
//            \Yii::t(
//                'user',
//                'Письмо было отправлено на Вашу почту. Оно содержит ссылку на страницу подтверждения.'
//            )
//        );
//
//        return true;
    }

}