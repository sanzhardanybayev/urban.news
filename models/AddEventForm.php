<?php
/**
 * Created by PhpStorm.
 * User: Sanzhar
 * Date: 14.03.2017
 * Time: 16:32
 */

namespace app\models;


use app\components\utility;
use yii\base\Model;

class AddEventForm extends  Model
{
    public $model_id;
    public $models;
    public $event_name;

    public function rules()
    {
        return [
            [['model_id', 'event_name'], 'required'],
            ['model_id', 'integer', 'min' => 1, 'max' => 100],
            ['event_name', 'string', 'max' => 100],
        ];
    }


    /** @inheritdoc */
    public function __construct($config = [])
    {
        $this->setAttributes([
            'models' => Models::find()->all()
        ], false);
        parent::__construct($config);
    }

    public function attributeLabels()
    {
        return [
            'model_id' => 'Модель',
            'event_name' => 'Название события',
        ];
    }


    public function formName()
    {
        return 'addEventForm';
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }
        $event = new Events();
        $event->model_id = $this->model_id;

        $event->name = $this->event_name;
        $event->save();


        $notifications = new NotificationsManage();
        $notifications->event_id = $event->id;
        $notifications->email = 1;
        $notifications->browser = 1;
        $notifications->role = 'admin';
        $notifications->model_id = $event->model_id;
        $notifications->save();

        $notifications = new NotificationsManage();
        $notifications->event_id = $event->id;
        $notifications->email = 1;
        $notifications->browser = 1;
        $notifications->role = 'moderator';
        $notifications->model_id = $event->model_id;
        $notifications->save();

        $notifications = new NotificationsManage();
        $notifications->event_id = $event->id;
        $notifications->email = 1;
        $notifications->browser = 1;
        $notifications->role = 'registeredUser';
        $notifications->model_id = $event->model_id;
        $notifications->save();


        $messageTemplate = new NotificationsMessageTemplates();
        $messageTemplate->event_id = $event->id;
        $messageTemplate->emailMessage = 'Уважаемый $username, ...';
        $messageTemplate->browserMessage = '$author только что ...';
        $messageTemplate->role = 'admin';
        $messageTemplate->model_id = $event->model_id;
        $messageTemplate->save();

        $messageTemplate = new NotificationsMessageTemplates();
        $messageTemplate->event_id = $event->id;
        $messageTemplate->emailMessage = 'Уважаемый $username, ...';
        $messageTemplate->browserMessage = '$author ...';
        $messageTemplate->role = 'moderator';
        $messageTemplate->model_id = $event->model_id;
        $messageTemplate->save();

        $messageTemplate = new NotificationsMessageTemplates();
        $messageTemplate->event_id = $event->id;
        $messageTemplate->emailMessage = 'Уважаемый $username, ...';
        $messageTemplate->browserMessage = '$author ...';
        $messageTemplate->role = 'registeredUser';
        $messageTemplate->model_id = $event->model_id;
        $messageTemplate->save();

        \Yii::$app->response->redirect('/events/');

    }
}