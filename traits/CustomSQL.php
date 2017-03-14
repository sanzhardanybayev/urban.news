<?php

namespace app\traits;


use app\models\User;
use Yii;

trait CustomSQL
{
  //TODO Refactor -> try AND catch
  /**
   * @param $sql
   * @return array
   */
  public function processCustomSQL($sql)
  {
    $connection = Yii::$app->getDb();
    $sql = $connection->createCommand($sql);
    return $sql->queryAll();
  }


  public function returnAllActiveUsers()
  {
    return User::find()->where(['<>', 'confirmed_at', 'null'])->all();
  }


  public function returnUserById($id)
  {
    return User::find()->where(['id' => $id])->one();
  }

  public function returnUsersByGroup($groupName)
  {
    $connection = Yii::$app->getDb();
    $sql = $connection->createCommand("
                SELECT user.id,user.username,user.email  
                FROM user
                LEFT JOIN auth_assignment as ass ON ass.user_id = user.id
                WHERE ass.item_name LIKE '" . $groupName . "'
                AND (user.confirmed_at IS NOT NULL)");
    return $sql->queryAll();
  }

  public function returnUsersWithNotificationsOnByGroup($groupName)
  {
    $connection = Yii::$app->getDb();
    $sql = $connection->createCommand("
                SELECT user.id,user.username,user.email, nt.browser,nt.email as 'emailNotification'  
                FROM user
                LEFT JOIN auth_assignment as ass ON ass.user_id = user.id
                LEFT JOIN notifications as nt ON nt.user_id = user.id
                WHERE ass.item_name LIKE '" . $groupName . "'
                AND (nt.browser = 1 OR nt.email = 1)");
    return $sql->queryAll();
  }

  public function returnActiveNotificationsByEventId($event_id)
  {
    $connection = Yii::$app->getDb();
    $sql = $connection->createCommand("
                SELECT user.id,nt.role,nt.event_id, nt.model_id ,nt.email, nt.browser  
                FROM user
                LEFT JOIN notifications as nt ON nt.user_id = user.id
                WHERE nt.event_id = ". $event_id ."
                AND (nt.browser = 1 OR nt.email = 1)");
    return $sql->queryAll();
  }


}