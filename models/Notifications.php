<?php

namespace app\models;


/**
 * This is the model class for table "notifications".
 *
 * @property integer $user_id
 * @property resource $email
 * @property resource $browser
 *
 * @property User $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'browser'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'browser' => 'Browser',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUsers(){
      return $this->hasMany(User::className(), ['id' => 'user_id']);
    }


    public function getauth_assignment()
    {
      return $this->hasOne(AuthAssignment::className(), ['user_id' => 'user_id']);
    }
}
