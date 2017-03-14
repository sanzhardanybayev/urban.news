<?php

namespace app\models;

use app\traits\CustomSQL;
use Yii;

/**
 * This is the model class for table "notifications_manage".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $model_id
 * @property integer $email
 * @property integer $browser
 * @property string $role
 *
 * @property Models $model
 * @property AuthItem $role0
 */
class NotificationsManage extends \yii\db\ActiveRecord
{
    use CustomSQL;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications_manage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'model_id'], 'required'],
            [['event_id', 'model_id', 'email', 'browser'], 'integer'],
            [['role'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'browser' => 'Browser',
            'role' => 'Role',
        ];
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
