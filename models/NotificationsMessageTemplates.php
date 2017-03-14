<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications_message_templates".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $model_id
 * @property string $emailMessage
 * @property string $browserMessage
 * @property string $role
 *
 * @property Events $event
 * @property Models $model
 * @property AuthItem $role0
 */
class NotificationsMessageTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications_message_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'model_id'], 'required'],
            [['event_id', 'model_id'], 'integer'],
            [['emailMessage', 'browserMessage'], 'string'],
            [['role'], 'string', 'max' => 255],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Models::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'model_id' => 'Model ID',
            'emailMessage' => 'Email Message',
            'browserMessage' => 'Browser Message',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Models::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'role']);
    }
}
