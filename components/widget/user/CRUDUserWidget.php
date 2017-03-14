<?php

namespace app\components\widget\user;

use app\components\utility;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class CRUDUserWidget extends Widget
{
  public $id;
  public $blocked;

  public function init()
  {
    parent::init();
  }

  public function run(){

    $roles = [
              'registeredUser' => (\Yii::$app->authManager->getRolesByUser($this->id)['registeredUser']->name == "registeredUser") ? "checked" : "",
              'moderator' => (\Yii::$app->authManager->getRolesByUser($this->id)['moderator']->name == "moderator") ? "checked" : "",
              'admin' => (\Yii::$app->authManager->getRolesByUser($this->id)['admin']->name == "admin") ? "checked" : "",
             ];
    $blocked =  ($this->blocked) ? 'checked' : '';
    $output = '<div class="border-top">
                  <div class="roles col s12 noPadding">
                        <p class="col noPadding">
                          <input class="userRoleValue with-gap"  '. $roles['registeredUser'] .' value="registeredUser" name="'. $this->id .'" type="radio" id="test1'. $this->id .'" />
                          <label for="test1'. $this->id .'"><small>Читатель</small></label>
                        </p>
                        <p class="col noPadding">
                          <input class="userRoleValue with-gap" '. $roles['moderator'] .' value="moderator" name="'. $this->id .'" type="radio" id="test2'. $this->id .'" />
                          <label for="test2'. $this->id .'"><small>Модератор </small></label>
                        </p>
                        <p class="col noPadding">
                          <input class="userRoleValue with-gap" '. $roles['admin'] .' value="admin"  name="'. $this->id .'" type="radio" id="test3'. $this->id .'"  />
                          <label for="test3'. $this->id .'"><small>Админ</small></label>
                        </p>
                  </div>
                  <div class=\'switch publish\'>
                         Забанить
                        <label>
                          
                          <input '. $blocked .'   class="ban" name="publish" type="checkbox" user_id="'. $this->id .'" / ">
                          <span class=\'lever\'></span>
                          
                        </label>
                   </div>
                  <div class="user-actions border-top">
                    <button  onclick="window.open(\'/user/settings/id/'. $this->id .'/\');" class="btn editUser  blue"> <img src="/dist/img/pencil-edit-button.png" alt="Редактировать" /> </button>
                    <button type="button" user-id="'. $this->id .'" class="btn deleteUser    red"><img src="/dist/img/close.png" alt="Удалить" /></button>
                  </div>
                </div>';
    return Html::decode($output);
  }
}