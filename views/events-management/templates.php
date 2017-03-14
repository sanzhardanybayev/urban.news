<?php

use app\components\utility;


use app\assets\AdminAsset;
AdminAsset::register($this);  // $this represents the view object
?>
<div class="row">
  <ul class="collapsible" data-collapsible="accordion">
   <li>
     <div class="collapsible-header"><i class="fa fa-book" aria-hidden="true"></i> Правила</div>
     <div class="collapsible-body">

         <ol class="">
           <li>Чтобы вставить в сообщение ключевые слова, относящиеся к моделям, используйте слова подставновки, указанные ниже</li>
           <li>Если тело сообщения пустое, то соответствующее событие не будет отправлено</li>
           <li>Браузерные сообщения не могут содержать слово подстановки - $username. Они должны быть короткими. </li>
         </ol>
         <p>Слова подстановки для модели "Новости"</p>
         <ol class="">
             <li>$username - имя получателя (<bold>   Только для E-mail сообщений </bold>)</li>
           <li>$article_title - заголовок статьи</li>
           <li>$article_title[$article_link] - ссылка на статью</li>
         </ol>
         <p>Слова подстановки для модели "Пользователь"</p>
         <ol>
             <li>$username - имя получателя (<bold> Только для E-mail сообщений </bold>)</li>
             <li>$newUsername - имя недавно появившегося пользователя</li>
             <li>$newUsername[$newUserLink] - Ссылка на надавно зарегистрированного пользователя</li>
         </ol>

         <p>Слова подстановки для модели "Профиль"</p>
         <ol>
             <li>$username - имя получателя (<bold> Только для E-mail сообщений </bold>)</li>
             <li>$profileUsername - имя пользователя, чьи данные были обновлены</li>
             <li>$profileUsername[$profileUserLink] - ссылка на пользователя, чьи данные были изменены</li>
         </ol>
     </div>
   </li>
 </ul>

  <div class="col s12">
    <ul class="tabs">
      <li class="tab col s12 m4 active "><a class="blue-text" href="#news">Модель "Новости"</a></li>
      <li class="tab col s12 m4"><a class="blue-text"  href="#user">Модель "Пользователь"</a></li>
      <li class="tab col s12 m4"><a class="blue-text"  href="#profile">Модель "Профиль"</a></li>
    </ul>
  </div>

  <!-- NEWS MODEL -->
  <div id="news" class="row col s12">
    <div class="card s12">
      <table class="col s12 striped centered" model="news">
        <thead>
        <tr>
          <th data-field="events">Событие</th>
          <th data-field="Email">Email сообщение</th>
          <th data-field="Email">Browser сообщение</th>
        </tr>
        </thead>

        <tbody>

        <?php for ($i=0; $i < (sizeof($newsMessages)-2) ; $i+=3) { ?>
            <tr event-id="<?= $newsMessages[$i]->event_id ?>">

          <td><?= (utility::$events_names[$newsMessages[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $newsMessages[$i]->event_id])->one()->name : utility::$events_names[$newsMessages[$i]->event_id]  ?></td>
          <td message-type="email">
            <div class="input-field col s10">
              <textarea role="admin" id="createArticleReader<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i]->emailMessage ?></textarea>
              <label for="createArticleReader<?= $newsMessages[$i]->event_id ?>">Для Админов</label>
            </div>
            <div class="input-field col s10">
              <textarea role="moderator" id="createArticleModerator<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i+1]->emailMessage ?></textarea>
              <label for="createArticleModerator<?= $newsMessages[$i]->event_id ?>">Для модераторов</label>
            </div>
            <div class="input-field col s10">
              <textarea role="registeredUser" id="createArticleAdmin<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i+2]->emailMessage ?></textarea>
              <label for="createArticleAdmin<?= $newsMessages[$i]->event_id ?>">Для читателей</label>
            </div>
            <button class="saveMessageTemplate btn" type="button" name="button">Сохранить</button>
          </td>

          <td message-type="browser">
            <div class="input-field col s10">
              <textarea role="admin" id="createArticleReader<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i]->browserMessage ?></textarea>
              <label for="createArticleReader<?= $newsMessages[$i]->event_id ?>">Для админов</label>
            </div>
            <div class="input-field col s10">
              <textarea role="moderator" id="createArticleModerator<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i+1]->browserMessage ?></textarea>
              <label for="createArticleModerator<?= $newsMessages[$i]->event_id ?>">Для модераторов</label>
            </div>
            <div class="input-field col s10">
              <textarea role="registeredUser" id="createArticleAdmin<?= $newsMessages[$i]->event_id ?>" class="materialize-textarea"><?= $newsMessages[$i+2]->browserMessage ?></textarea>
              <label for="createArticleAdmin<?= $newsMessages[$i]->event_id ?>">Для читателей</label>
            </div>
            <button class="saveMessageTemplate btn browser" type="button" name="button">Сохранить</button>
          </td>

        </tr>
        <?php } ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- USER MODEL -->
  <div id="user" class="row col s12">
    <div class="card s12">
      <table class="col s12 striped centered" model="news">
        <thead>
        <tr>
            <th data-field="events">Событие</th>
            <th data-field="Email">Email сообщение</th>
            <th data-field="Email">Browser сообщение</th>
        </tr>
        </thead>

        <tbody>

        <?php for ($i=0; $i < (sizeof($userMessages)-2) ; $i+=3) { ?>
            <tr event-id="<?= $userMessages[$i]->event_id ?>">
                <td><?= (utility::$events_names[$userMessages[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $userMessages[$i]->event_id])->one()->name : utility::$events_names[$userMessages[$i]->event_id]  ?></td>
                <td message-type="email">
                    <div class="input-field col s10">
                        <textarea role="admin" id="createArticleReader<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i]->emailMessage ?></textarea>
                        <label for="createArticleReader<?= $userMessages[$i]->event_id ?>">Для Админов</label>
                    </div>
                    <div class="input-field col s10">
                        <textarea role="moderator" id="createArticleModerator<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i+1]->emailMessage ?></textarea>
                        <label for="createArticleModerator<?= $userMessages[$i]->event_id ?>">Для модераторов</label>
                    </div>
                    <div class="input-field col s10">
                        <textarea role="registeredUser" id="createArticleAdmin<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i+2]->emailMessage ?></textarea>
                        <label for="createArticleAdmin<?= $userMessages[$i]->event_id ?>">Для читателей</label>
                    </div>
                    <button class="saveMessageTemplate btn" type="button" name="button">Сохранить</button>
                </td>

                <td message-type="browser">
                    <div class="input-field col s10">
                        <textarea role="admin" id="createArticleReader<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i]->browserMessage ?></textarea>
                        <label for="createArticleReader<?= $userMessages[$i]->event_id ?>">Для админов</label>
                    </div>
                    <div class="input-field col s10">
                        <textarea role="moderator" id="createArticleModerator<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i]->browserMessage ?></textarea>
                        <label for="createArticleModerator<?= $userMessages[$i]->event_id ?>">Для модераторов</label>
                    </div>
                    <div class="input-field col s10">
                        <textarea role="registeredUser" id="createArticleAdmin<?= $userMessages[$i]->event_id ?>" class="materialize-textarea"><?= $userMessages[$i]->browserMessage ?></textarea>
                        <label for="createArticleAdmin<?= $userMessages[$i]->event_id ?>">Для читателей</label>
                    </div>
                    <button class="saveMessageTemplate btn browser" type="button" name="button">Сохранить</button>
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
        <table class="col s12 striped centered" model="news">
          <thead>
          <tr>
              <th data-field="events">Событие</th>
              <th data-field="Email">Email сообщение</th>
              <th data-field="Email">Browser сообщение</th>
          </tr>
          </thead>

          <tbody>

          <?php for ($i=0; $i < (sizeof($profileMessages)-2) ; $i+=3) { ?>
              <tr event-id="<?= $profileMessages[$i]->event_id ?>">
                  <td><?= (utility::$events_names[$profileMessages[$i]->event_id] == null) ? \app\models\Events::find()->where(['id' => $profileMessages[$i]->event_id])->one()->name : utility::$events_names[$profileMessages[$i]->event_id]  ?></td>
                  <td message-type="email">
                      <div class="input-field col s10">
                          <textarea role="admin" id="createArticleReader<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i]->emailMessage ?></textarea>
                          <label for="createArticleReader<?= $profileMessages[$i]->event_id ?>">Для Админов</label>
                      </div>
                      <div class="input-field col s10">
                          <textarea role="moderator" id="createArticleModerator<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i+1]->emailMessage ?></textarea>
                          <label for="createArticleModerator<?= $profileMessages[$i]->event_id ?>">Для модераторов</label>
                      </div>
                      <div class="input-field col s10">
                          <textarea role="registeredUser" id="createArticleAdmin<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i+2]->emailMessage ?></textarea>
                          <label for="createArticleAdmin<?= $profileMessages[$i]->event_id ?>">Для читателей</label>
                      </div>
                      <button class="saveMessageTemplate btn" type="button" name="button">Сохранить</button>
                  </td>

                  <td message-type="browser">
                      <div class="input-field col s10">
                          <textarea role="admin" id="createArticleReader<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i]->browserMessage ?></textarea>
                          <label for="createArticleReader<?= $profileMessages[$i]->event_id ?>">Для админов</label>
                      </div>
                      <div class="input-field col s10">
                          <textarea role="moderator" id="createArticleModerator<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i+1]->browserMessage ?></textarea>
                          <label for="createArticleModerator<?= $profileMessages[$i]->event_id ?>">Для модераторов</label>
                      </div>
                      <div class="input-field col s10">
                          <textarea role="registeredUser" id="createArticleAdmin<?= $profileMessages[$i]->event_id ?>" class="materialize-textarea"><?= $profileMessages[$i+2]->browserMessage ?></textarea>
                          <label for="createArticleAdmin<?= $profileMessages[$i]->event_id ?>">Для читателей</label>
                      </div>
                      <button class="saveMessageTemplate btn browser" type="button" name="button">Сохранить</button>
                  </td>

              </tr>
          <?php } ?>

          </tbody>
        </table>
      </div>
    </div>

</div>
