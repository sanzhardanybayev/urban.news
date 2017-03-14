<?php

namespace app\components\widget\floatingButton\actions;

use app\models\User;
use Yii;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;


class NotifyAllUsers extends Widget implements FloatingActionInterface
{
  private function initSelectAuthorDropDown($form,$news){
    $authorInput = '';
    $authors = array();
    $users = User::find()->where(['<>', 'id', \Yii::$app->user->identity->getId()])->all();

    foreach ($users as $user) {
      $user = User::findOne($user->id);
      $userAvatar = ($user->profile->avatar) ? $user->profile->avatar : "dist/img/default.png";
      $authorValue = '<option  value="' . $user->id . '" data-icon="/' . $userAvatar . '" class="left circle">' . $user->username . '</option>';
      array_push($authors, $authorValue);
    }

    if(Yii::$app->user->can('createUser')){
      $authorInput = '
                        <div class="row">
                                <div class="input-field col s12 m5 push-m3">
                                  <select class="icons" id="userId" name="News[user_id]" required>
                                    <option value="" disabled selected>Выберите автора</option>
                                    '. implode($authors) .'
                                  </select>
                                  <label>Выберите автора</label>
                                </div>
                        </div>';
    }else {
      $news->user_id = Yii::$app->user->identity->id;
      $authorInput =  $form->field($news, 'user_id')->hiddenInput()->label(false);
    }

    return $authorInput;

  }
  public function render()
  {

    echo '<div id="modal3" class="modal">
                <h4>Массовое уведомление пользователей</h4>
                <div class="modal-content">
                    <div class="col-md-12 flex space-between">
                                      <p>
                                        <input class="whoToSent with-gap" checked name="receivers" type="radio" value="certainUser" id="certainUser" />
                                        <label for="certainUser">Определенному пользователю</label>
                                      </p>  
                                      <p>
                                        <input class="whoToSent with-gap" name="receivers" type="radio" value="groupOfPeople" id="groupOfPeople" />
                                        <label for="groupOfPeople">Группе пользователей</label>
                                      </p>
                                      <p>
                                        <input class="whoToSent with-gap" name="receivers" type="radio" value="all" id="all"  />
                                        <label for="all">Всем</label>
                                      </p>
                    </div>
                    <div class="flex flex-column justify-center align-center">
                        <form class="notifyUsers">
                            <div id="animationContainer">
                              <div class="input-field col animated s12" id="userSelection">
                                  '. $this->initSelectAuthorDropDown() .'
                              </div>
                              <div class="input-field col animated s12" id="groupSelection" style="display:none">
                           <div class="row">
                                <div class="input-field col s12 m5 push-m3">
                                  <select id="groupName" class="icons" name="News[user_id]" required>
                                    <option value="" disabled selected>Выберите группу пользователей</option>
                                    <option value="admin">Администраторы</option>
                                    <option value="moderator">Модераторы</option>
                                    <option value="registeredUser">Зарегистрированные читатели</option>
                                  </select>
                                  <label>Выберите группу пользователей</label>
                                </div>
                        </div>
                        </div>
                            </div>
                         <div class="input-field col s12">
                          <textarea id="messageFromAdmin" name="message" class="materialize-textarea"></textarea>
                          <label for="messageFromAdmin">Сообщение</label>
                        </div>
                         <div class="form-group row col s12">
                            <button class="airPlane btn btn-primary btn-block col s12" type="button">
                                  <span>
                                      <div class="hide sk-fading-circle">
                                          <div class="sk-circle1 sk-circle"></div>
                                          <div class="sk-circle2 sk-circle"></div>
                                          <div class="sk-circle3 sk-circle"></div>
                                          <div class="sk-circle4 sk-circle"></div>
                                          <div class="sk-circle5 sk-circle"></div>
                                          <div class="sk-circle6 sk-circle"></div>
                                          <div class="sk-circle7 sk-circle"></div>
                                          <div class="sk-circle8 sk-circle"></div>
                                          <div class="sk-circle9 sk-circle"></div>
                                          <div class="sk-circle10 sk-circle"></div>
                                          <div class="sk-circle11 sk-circle"></div>
                                          <div class="sk-circle12 sk-circle"></div>
                                      </div>
                                      <span class="send">Отправить</span>
                                  </span>
                                  <span class="fa fa-paper-plane steady"></span>
                            </button>
                         </div>
                  </form>   
                    </div>
                </div>
          </div>';
  }


}