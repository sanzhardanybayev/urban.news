<?php

use app\components\utility;


use app\assets\AdminAsset;
AdminAsset::register($this);  // $this represents the view object
?>

<div class="row">
  <div class="col s12">
    <ul class="tabs">
      <li class="tab col s12 m4 active "><a class="blue-text" href="#news">Модель "Новости"</a></li>
      <li class="tab col s12 m4"><a class="blue-text"  href="#user">Модель "Пользователь"</a></li>
      <li class="tab col s12 m4"><a class="blue-text" href="#profile">Модель "Профиль"</a></li>
    </ul>
  </div>


  <!-- NEWS MODEL -->
  <div id="news" class="row col s12">
    <div class="card s12">
      <table class="col s12 striped centered" model="news">
        <thead>
        <tr>
          <th data-field="events">Событие</th>
          <th data-field="Email">Email уведомления</th>
          <th data-field="Browser">Browser уведомления</th>
        </tr>
        </thead>

        <tbody>

        <?php for ($i=0; $i < (sizeof($newsModel)-2) ; $i+=3) { ?>
            <tr event-id="<?= $newsModel[$i]->event_id ?>">
                <td><?= (utility::$events_names[$newsModel[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $newsModel[$i]->event_id])->one()->name : utility::$events_names[$newsModel[$i]->event_id]  ?></td>
                <td>
                    <p class="col s12">
                        <input type="checkbox" class="notification-manage" message-type="email" role="admin" <?= ($newsModel[$i]->email == 1 && $newsModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i]->event_id ?>EmailAdmin" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i]->event_id ?>EmailAdmin">Админ</label>
                    </p>
                    <p class="col s12">
                        <input type="checkbox" class="notification-manage" message-type="email" role="moderator" <?= ($newsModel[$i+1]->email == 1 && $newsModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i+1]->event_id ?>EmailModerator" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i+1]->event_id ?>EmailModerator">Модератор</label>
                    </p>
                    <p class="col s12">
                        <input type="checkbox" class="notification-manage" message-type="email" role="registeredUser" <?= ($newsModel[$i+2]->email == 1 && $newsModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i+2]->event_id ?>EmailUser" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i+2]->event_id ?>EmailUser">Читатель</label>
                    </p>
                </td>
                <td>
                    <p class="col s12">
                      <input type="checkbox" class="notification-manage" message-type="browser" role="admin" <?= ($newsModel[$i]->browser == 1 && $newsModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i]->event_id ?>BrowserAdmin" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i]->event_id ?>BrowserAdmin">Админ</label>
                    </p>
                    <p class="col s12">
                        <input type="checkbox" class="notification-manage" message-type="browser" role="moderator" <?= ($newsModel[$i+1]->browser == 1 && $newsModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i+1]->event_id ?>BrowserModerator" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i+1]->event_id ?>BrowserModerator">Модератор</label>
                    </p>
                    <p class="col s12">
                        <input type="checkbox" class="notification-manage" message-type="browser" role="registeredUser" <?= ($newsModel[$i+2]->browser == 1 && $newsModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $newsModel[$i+2]->event_id ?>BrowserUser" event="onArticleCreate" />
                        <label  for="<?= $newsModel[$i+2]->event_id ?>BrowserUser">Читатель</label>
                    </p>
                </td>
            </tr>

        <?php } ?>



        </tbody>
      </table>
    </div>
  </div>

  <!-- USERS MODEL -->
  <div id="user" class="row col s12">
        <div class="card s12">
            <table class="col s12 striped centered" model="news">
                <thead>
                <tr>
                    <th data-field="events">Событие</th>
                    <th data-field="Email">Email уведомления</th>
                    <th data-field="Browser">Browser уведомления</th>
                </tr>
                </thead>

                <tbody>

                <?php for ($i=0; $i < (sizeof($userModel)-2) ; $i+=3) { ?>

                    <tr event-id="<?= $userModel[$i]->event_id ?>">
                        <td><?= (utility::$events_names[$userModel[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $userModel[$i]->event_id])->one()->name : utility::$events_names[$userModel[$i]->event_id]  ?></td>
                        <td>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="admin" <?= ($userModel[$i]->email == 1 && $userModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i]->event_id ?>EmailAdmin" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i]->event_id ?>EmailAdmin">Админ</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="moderator" <?= ($userModel[$i+1]->email == 1 && $userModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i+1]->event_id ?>EmailModerator" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i+1]->event_id ?>EmailModerator">Модератор</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="registeredUser" <?= ($userModel[$i+2]->email == 1 && $userModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i+2]->event_id ?>EmailUser" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i+2]->event_id ?>EmailUser">Читатель</label>
                            </p>
                        </td>
                        <td>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="admin" <?= ($userModel[$i]->browser == 1 && $userModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i]->event_id ?>BrowserAdmin" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i]->event_id ?>BrowserAdmin">Админ</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="moderator" <?= ($userModel[$i+1]->browser == 1 && $userModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i+1]->event_id ?>BrowserModerator" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i+1]->event_id ?>BrowserModerator">Модератор</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="registeredUser" <?= ($userModel[$i+2]->browser == 1 && $userModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $userModel[$i+2]->event_id ?>BrowserUser" event="onArticleCreate" />
                                <label  for="<?= $userModel[$i+2]->event_id ?>BrowserUser">Читатель</label>
                            </p>
                        </td>
                    </tr>

                <?php } ?>



                </tbody>
            </table>
        </div>
    </div>

  <!-- PROFILE MODEL -->
  <div id="profile" class="row col s12">
        <div class="card s12">
            <table class="col striped s12 centered" model="news">
                <thead>
                <tr>
                    <th data-field="events">Событие</th>
                    <th data-field="Email">Email уведомления</th>
                    <th data-field="Browser">Browser уведомления</th>
                </tr>
                </thead>

                <tbody>

                <?php for ($i=0; $i < (sizeof($profileModel)-2) ; $i+=3) { ?>
                    <tr event-id="<?= $profileModel[$i]->event_id ?>">
                        <td><?= (utility::$events_names[$profileModel[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $profileModel[$i]->event_id])->one()->name : utility::$events_names[$profileModel[$i]->event_id]  ?></td>
                        <td>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="admin" <?= ($profileModel[$i]->email == 1 && $profileModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i]->event_id ?>EmailAdmin" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i]->event_id ?>EmailAdmin">Админ</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="moderator" <?= ($profileModel[$i+1]->email == 1 && $profileModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i+1]->event_id ?>EmailModerator" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i+1]->event_id ?>EmailModerator">Модератор</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="email" role="registeredUser" <?= ($profileModel[$i+2]->email == 1 && $profileModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i+2]->event_id ?>EmailUser" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i+2]->event_id ?>EmailUser">Читатель</label>
                            </p>
                        </td>
                        <td>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="admin" <?= ($profileModel[$i]->browser == 1 && $profileModel[$i]->role == 'admin') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i]->event_id ?>BrowserAdmin" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i]->event_id ?>BrowserAdmin">Админ</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="moderator" <?= ($profileModel[$i+1]->browser == 1 && $profileModel[$i+1]->role == 'moderator') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i+1]->event_id ?>BrowserModerator" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i+1]->event_id ?>BrowserModerator">Модератор</label>
                            </p>
                            <p class="col s12">
                                <input type="checkbox" class="notification-manage" message-type="browser" role="registeredUser" <?= ($profileModel[$i+2]->browser == 1 && $profileModel[$i+2]->role == 'registeredUser') ? addslashes("checked") : addslashes("") ?> id="<?= $profileModel[$i+2]->event_id ?>BrowserUser" event="onArticleCreate" />
                                <label  for="<?= $profileModel[$i+2]->event_id ?>BrowserUser">Читатель</label>
                            </p>
                        </td>
                    </tr>

                <?php } ?>



                </tbody>
            </table>
        </div>
    </div>



</div>
