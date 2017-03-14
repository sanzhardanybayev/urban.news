<?php

namespace app\components\widget;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class HeaderWidget extends Widget
{

    public function init()
    {
      if(!Yii::$app->user->isGuest){
        $view = $this->view;
        $view->registerJs("var user_id = ". Yii::$app->user->getId() .";",$view::POS_HEAD);
      }
      parent::init();
    }

    public function run()
    {
      $guestBlock = '';
      $userBlock = '';

      if (Yii::$app->user->isGuest) {
        $guestBlock = '<li><a href="/user/register">Регистрация</a></li>
                          <li><a href="/user/login"><i class="fa fa-sign-in" aria-hidden="true"></i>Войти</a></li>';
      } else {

        $username = Yii::$app->user->identity->username;
        $avatar = (Yii::$app->user->identity->profile->avatar) ? Yii::$app->user->identity->profile->avatar : "dist/img/default.png";
        $csrf_token = Yii::$app->request->getCsrfToken();
        $usersLink = '';
        if(Yii::$app->user->can('createUser')){
          $usersLink = '<li><a href="/users/">Пользователи</a></li>';
          $usersLink .= '<li>
                            <a class="dropdown-button" data-activates=\'dropdownEvents\'>События</a>
                              <ul id=\'dropdownEvents\' class=\'dropdown-content\'>
                                <li><a class="black-text" href="/events/">События</a></li>
                                <li><a class="black-text" href="/events/templates/">Шаблоны текста</a></li>
                              </ul>
                         </li>
                            ';

        }

        $userBlock = $usersLink.
                         '<li><a href="/news">Новости</a></li>
                         <li><a href="/user/settings/account">Настройки</a></li>
                         <li>
                              <a href="/user/'. (Yii::$app->user->identity->username) .'"
                                 class="dropdown-button  center_content"
                                 data-activates="dropdown1">'. $username .'
                                  <div class="ava_mini"
                                       style="background: url(/'. $avatar .')"></div>
                              </a>
                              <ul id="dropdown1" class="dropdown-content">
                                  <li><a href="/user/'. $username .'"
                                         class="black-text">Профиль</a></li>
                                  <li><a href="#!" class="black-text noPadding center">
                                          <form action="/user/security/logout/" method="POST">
                                              <input type="hidden" name="_csrf"
                                                     value="'. $csrf_token .'"/>
                                              <button type="submit">
                                                  <i class="fa fa-sign-out" aria-hidden="true"></i>Выйти
                                              </button>
                                          </form>
                                      </a>
                                  </li>
                                </ul >
                         </li >';
        }

      $output = '<div class="navbar-fixed">
                      <nav class=" z-depth-1 nav" role="navigation">
                          <div class="nav-wrapper container">
                              <a href="' . Yii::$app->homeUrl . '" class="brand-logo">Urban News</a>
                              <ul id="nav-mobile" class="right">
                                '. $guestBlock .'
                                '. $userBlock .'
                               </ul>
                           </div>
                       </nav>
                   </div>';

       return  Html::decode($output);

    }

}