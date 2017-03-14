<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use app\components\widget\user\UserInfoWidget;
use app\components\widget\user\CRUDUserWidget;


/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
  <div class="col s12 m12">
    <div class="row">
      <?php
      if(empty($users)){
        echo "<h5 class='col s12'> Нет пользователей </h5>";
      }
      else{
        $i=0;
        $arrayLength = sizeof($users);

        echo '<h5 class="col s12">Пользователи</h5>';

        foreach ($users as $user) {
          $avatar = ($user->profile->avatar) ? $user->profile->avatar : 'dist/img/default.png';
          if($i==0 || $i%3 ==0) { echo "<div class='row'>"; }
          echo '<div class="col s12 l4">
                <div class="card userCard  col s12">
                    <div class="row col s12">
                      <a href="/user/'. $user->username .'/" target="_blank">
                        <div class="avatar" style="background:url(/'. $avatar .')"> </div>
                      </a>
                      '. UserInfoWidget::widget(['username' => $user->username,
                              'location' => $user->profile->location,
                              'website' => $user->profile->website,
                              'public_email' => $user->profile->public_email,
                              'created_at' => $user->created_at,
                              'bio' => $user->profile->bio]) .'
                      '. CRUDUserWidget::widget(['id' => $user->id, 'blocked' => $user->isBlocked]) .'
                        </div>
                  </div>
                </div>';
          if(($i+1)%3==0 || $i+1==$arrayLength) { echo "</div>"; }
          $i++;
        }

      }
      ?>

    </div>
  </div>
</div>
