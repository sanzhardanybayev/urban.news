<?php

namespace app\components\widget\floatingButton;
use app\components\widget\floatingButton\actions\AddEvent;
use app\components\widget\floatingButton\actions\NewsCreate;
use app\components\widget\floatingButton\actions\UserCreate;
use app\components\widget\floatingButton\actions\NotifyAllUsers;
use Yii;


class FloatingButton
{
  private function renderHeader(){

    $addUserButton = (Yii::$app->user->can('createuser')) ? '<li><a href="#modal2" class="btn-floating my">Добавить пользователя</a></li>' : '';
    $addNotifyAllUsersButton = (Yii::$app->user->can('createuser')) ? '<li><a href="#modal3" class="btn-floating my">Уведомить всех пользователей</a></li>' : '';
    $addEventButton = (Yii::$app->user->can('createuser')) ? '<li><a href="#modal4" class="btn-floating my">Добавить событие</a></li>' : '';
    $output = '
                <div class="fixed-action-btn horizontal">
                  <a class="btn-floating btn-large red">
                      <img src="/dist/img/pencil-edit-button.png" alt="Add">
                  </a>
                  <ul>
                    <li><a href="#modal1" class="btn waves-effect waves-light btn-floating my">Создать пост</a></li>
                    '. $addUserButton .'
                    '. $addNotifyAllUsersButton .'
                    '. $addEventButton .'
                  </ul>
                </div>';
    return $output;
  }

  public function run(){
    echo $this->renderHeader();
      $newsCreate = new NewsCreate();
      $newsCreate->render();
      if(\Yii::$app->user->can('createUser')){
        $userCreate = new UserCreate();
        $userCreate->render();
        $notifyAllUsers = new NotifyAllUsers();
        $notifyAllUsers->render();
        $addEvent = new AddEvent();
        $addEvent->render();
      }
  }

}