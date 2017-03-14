<?php

namespace app\models;


use app\components\EventTrigger;
use app\components\utility;
use app\events\news\NewsEvent;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\events\news\NewsEventsInterface;
use app\components\notifications\ModelNotification;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $content
 * @property string $preview_img
 * @property string $created_at
 * @property string $updated_at
 * @property integer $active
 * @property string $title
 * @property string $short_description
 *
 * @property User $user
 */
class News extends \yii\db\ActiveRecord  implements  NewsEventsInterface
{

  /**
   * @return object
   */

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['active'], 'integer'],
            [['content', 'short_description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'preview_img', 'title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'content' => 'Content',
            'preview_img' => 'Preview Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'active' => 'Active',
            'title' => 'Title',
            'short_description' => 'Short Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

  /**
   * @param NewsEvent $event
   */
  public function onArticleCreate(NewsEvent $event){

      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);
      $eventTrigger = new EventTrigger($event_id, 'Добавлена статья!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);
      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);

    }

    public function onArticleDelete(NewsEvent $event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Удалена статья!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
    }

    public function onArticlePublish(NewsEvent $event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Опубликована статья!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
    }

    public function onDescriptionChange($event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Обновлено описание статьи!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
    }

    public function onTitleChange($event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Обновлен заголовок статьи!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);

    }

    public function onContentChange($event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Обновлено содержание статьи!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
    }

    public function onPreviewChange($event){
      $event_id = Yii::$app->utility->returnEventIdByEventName($event->event_name);

      $eventTrigger = new EventTrigger($event_id, 'Обновлено фото статьи!', $event->author , $event->event_type, $event->article_name, $event->article_id, $event->article_img);

      $modelNotification = new ModelNotification();
      $modelNotification->notifyViaEmailOrBrowser($eventTrigger);
    }

}
