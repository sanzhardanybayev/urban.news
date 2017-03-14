<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model dektrium\user\models\SettingsForm
 */

$this->title = Yii::t('user', 'Настройки аккаунта');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col s11 m12">
        <ul class="tabs">
            <?php if(Yii::$app->user->can('createUser')) { $wider=false; ?>
                <li class="tab col s3"><a class="active blue-text" href="#website">Настройки сайта</a></li>
            <?php } else { $wider=true; } ?>
            <li class="tab col <?= ($wider) ? 's4' : 's3'?>"><a class="active blue-text" href="#account">Настройки аккаунта</a></li>
            <li class="tab col <?= ($wider) ? 's4' : 's3'?>"><a href="#profile" class="blue-text">Настройки профиля</a></li>
            <li class="tab col <?= ($wider) ? 's4' : 's3'?>"><a href="#notifications" class="blue-text">Настройки уведомлений</a></li>
        </ul>
    </div>

    <?php if(Yii::$app->user->can('createUser')) {  ?>
        <div class="card col s11 m10 offset-m1 visible" id="website">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title">Настройки сайта</h5>
            </div>
            <div class="panel-body">
              <?php $form = ActiveForm::begin([
                  'id' => 'websiteSettingsForm',
                  'action' => '/user/settings/websitesettings/',
                  'options' => ['class' => 'form-horizontal'],
                  'enableAjaxValidation' => true,
                  'method' => 'POST',
                  'enableClientValidation' => true,
                  'layout' => 'horizontal',
                  'fieldConfig' => [
                      'options' => ['class' => 'form-group col s12'],
                      'template' => "<div class='row'>
                                            <div class=\"input-field col s12\">
                                                {input}\n
                                                {label}\n
                                                <div class=\"form-control-focus\"> </div>
                                                <span class=\"red-text text-darken-4\"> {error}</span>
                                             
                                            </div>
                                        </div>",
                      'horizontalCssClasses' => [
                          'label' => [],
                          'offset' => 'col-sm-offset-4',
                          'wrapper' => 'col-sm-10',
                          'error' => 'has-error',
                          'hint' => 'help-block',
                      ],
                  ]
              ]); ?>

              <?= $form->field($websiteSettingsForm, 'amountOfNewsOnMainPage')->dropDownList([
                  '3' => '3',
                  '4' => '4',
                  '5' => '5',
                  '6' => '6',
                  '7' => '7',
                  '8' => '8',
                  '9' => '9',
                  '10' => '10',
                  '11' => '11',
                  '12' => '12',
                  '13' => '13',
                  '14' => '14',
                  '15' => '15'
              ], ['id' => 'amountOfNewsOnMainPage', 'required' => 'required', 'class' => '\'form-control validate input-field col s12']) ?>

              <?= $form->field($websiteSettingsForm, 'amountOfNewsOnNewsPage')->dropDownList([
                  '3' => '3',
                  '4' => '4',
                  '5' => '5',
                  '6' => '6',
                  '7' => '7',
                  '8' => '8',
                  '9' => '9',
                  '10' => '10',
                  '11' => '11',
                  '12' => '12',
                  '13' => '13',
                  '14' => '14',
                  '15' => '15'
              ], ['id' => 'amountOfNewsOnNewsPage', 'required' => 'required', 'class' => '\'form-control validate input-field col s12']) ?>

                <div class="form-group">
                    <div class="row col s12">
                        <button type="button" class="airPlane btn btn-primary btn-block col s12" id="saveWebsiteSettings">
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
                              <span class="send">Сохранить</span>
                          </span>
                          <span class="fa fa-paper-plane steady"></span>
                        </button>
                        <br>
                    </div>
                </div>

              <?php ActiveForm::end(); ?>
            </div>
        </div>

      <?php if (!$model->module->enableAccountDelete): ?>
          <div class="panel panel-danger">
              <div class="panel-heading">
                  <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
              </div>
              <div class="panel-body">
                  <p>
                    <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                    <?= Yii::t('user', 'It will be deleted forever') ?>.
                    <?= Yii::t('user', 'Please be certain') ?>.
                  </p>
                <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post',
                    'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                ]) ?>
              </div>
          </div>
      <?php endif ?>
    </div>
    <?php } ?>

    <div class="card col s11 m10 offset-m1" id="account">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title"><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="panel-body">
              <?php $form = ActiveForm::begin([
                  'id' => 'account-form',
//                    'action'      =>  $action,
                  'options' => ['class' => 'form-horizontal'],
                  'enableAjaxValidation' => true,
                  'enableClientValidation' => true,
                  'layout' => 'horizontal',
                  'fieldConfig' => [
                      'options' => ['class' => 'form-group col s12'],
                      'template' => "<div class='row'>
                                            <div class=\"input-field col s12\">
                                                {input}\n
                                                {label}\n
                                                <div class=\"form-control-focus\"> </div>
                                                \n{error}\n
                                            </div>
                                        </div>",
                      'horizontalCssClasses' => [
                          'label' => [],
                          'offset' => 'col-sm-offset-4',
                          'wrapper' => 'col-sm-10',
                          'error' => 'has-error',
                          'hint' => 'help-block',
                      ],
                  ]
              ]); ?>

              <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'required' => 'required', 'type' => 'email', 'class' => '\'form-control validate input-field col s12'])->label('Email', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>


              <?= $form->field(
                  $model,
                  'username',
                  ['inputOptions' => ['autofocus' => 'autofocus', 'type' => 'text', 'class' => 'form-control validate input-field col s12', 'tabindex' => '1']]
              )->label('Логин', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>


              <?= $form->field($model, 'new_password')->passwordInput()->label('Новый пароль(минимум 6 знаков)') ?>

              <?= $form->field($model, 'current_password')->passwordInput()->label((Yii::$app->user->can('createUser') ? 'Текущий пароль' : 'Текущий пароль(обязательно)')) ?>

                <div class="form-group">
                    <div class="row col s12">
                      <?= Html::button(Yii::t('user', '<span><div class="hide sk-fading-circle">
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
                      </div><span class="send">Сохранить</span></span><span class="fa fa-paper-plane steady"></span>'), ['id' => "saveAccountInfo", 'class' => 'airPlane btn btn-primary btn-block col s12']) ?>
                        <br>
                    </div>
                </div>

              <?php ActiveForm::end(); ?>
            </div>
        </div>

      <?php if (!$model->module->enableAccountDelete): ?>
          <div class="panel panel-danger">
              <div class="panel-heading">
                  <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
              </div>
              <div class="panel-body">
                  <p>
                    <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                    <?= Yii::t('user', 'It will be deleted forever') ?>.
                    <?= Yii::t('user', 'Please be certain') ?>.
                  </p>
                <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post',
                    'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                ]) ?>
              </div>
          </div>
      <?php endif ?>
    </div>

    <div class="card col s11 m10 offset-m1" id="profile">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title">Настройки профиля</h5>
            </div>
            <div class="panel-body">
              <?php $form = ActiveForm::begin([
                  'id' => 'profile-form',
                  'action' => '' . ($id) ? '/user/settings/saveprofile/' . $id . '/' : '/user/settings/saveprofile/',
                  'options' => ['class' => 'form-horizontal',
                      'enctype' => 'multipart/form-data'],
                  'enableAjaxValidation' => true,
                  'enableClientValidation' => true,
                  'layout' => 'horizontal',
                  'fieldConfig' => [
                      'options' => ['class' => 'form-group col s12'],
                      'template' => "<div class='row'>
                                            <div class=\"input-field col s12\">
                                                {input}\n
                                                {label}\n
                                                <div class=\"form-control-focus\"> </div>
                                                \n{error}\n
                                            </div>
                                        </div>",
                      'horizontalCssClasses' => [
                          'label' => [],
                          'offset' => 'col-sm-offset-4',
                          'wrapper' => 'col-sm-10',
                          'error' => 'has-error',
                          'hint' => 'help-block',
                      ],
                  ]
              ]); ?>

              <?= $form->field(
                  $profile,
                  'name',
                  ['inputOptions' => ['autofocus' => 'autofocus', 'type' => 'text', 'class' => 'form-control validate input-field col s12', 'tabindex' => '1']]
              )->label('Имя', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>

                <div class='row'>
                    <div class="input-field col s12">
                      <?= $form->field($profile, 'public_email')->textInput(['autofocus' => true, 'type' => 'email', 'class' => '\'form-control validate input-field col s12'])->label('Email', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>
                    </div>
                </div>

                <div class='row'>
                    <div class=\"input-field col s12\
                    ">
                  <?= $form->field(
                      $profile,
                      'website',
                      ['inputOptions' => ['autofocus' => 'autofocus', 'type' => 'text', 'class' => 'form-control validate input-field col s12', 'tabindex' => '1']]
                  )->label('Сайт', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>
                </div>
            </div>
            <div class='row'>
                <div class=\"input-field col s12\
                ">
              <?= $form->field(
                  $profile,
                  'location',
                  ['inputOptions' => ['autofocus' => 'autofocus', 'type' => 'text', 'class' => 'form-control validate input-field col s12', 'tabindex' => '1']])->label('Страна', ['class' => '', 'data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>
            </div>
        </div>

        <div class='row'>
            <div class=\"input-field col s12\
            ">
          <?= $form->field($profile, 'bio')->textarea(['class' => 'materialize-textarea']) ?>
        </div>
    </div>

    <div class="row">
        <h5>Аватарка</h5>

      <?php if (!$profile->isNewRecord) { ?>
          <img class="materialboxed col s12 m4" src="/<?= ($profile->avatar) ? $profile->avatar : 'dist/img/default.png' ?>">
      <?php } ?>

        <div class="file-field input-field col s12 <?= ($profile->isNewRecord) ? '' : 'm6' ?>">
            <div class="btn blue">
                <span><?= ($profile->isNewRecord) ? 'Загрузить аватарку' : 'Обновить аватарку' ?> </span>
                <input type="file" name="Profile[avatar]" value="">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row col s12">
          <?= Html::submitButton(Yii::t('user', '<span>
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
                    <span class="send">Сохранить</span></span><span class="fa fa-paper-plane steady"></span>'), ['id' => "saveProfileInfo", 'class' => 'airPlane btn btn-primary btn-block col s12']) ?>
            <br>
        </div>
    </div>
  <?php ActiveForm::end(); ?>
</div>
</div>
</div>
<div class="card col s11 m10 offset-m1" id="notifications">
    <div class="panel panel-default">
        <div class="panel-heading col s12">
            <h5 class="panel-title">Укажите какие уведомления Вы хотите получать</h5>
        </div>
        <div class="panel-body">
          <?php $form = ActiveForm::begin(['action' => '/user/settings/notifications']); ?>
            <input type="hidden" name="user_id_notify" value="<?= $model->user->id; ?>">
            <div class="row" id="notifications_settings">
                <p>
                    <input class="notificationChoice" name="notifications"
                           type="checkbox" <?= ($model->user->notifications != null && $model->user->notifications[0]->email == 1) ? addslashes("checked") : addslashes("") ?>
                           value="emailNotification" id="emailNotification"/>
                    <label for="emailNotification">Email</label>
                </p>
                <p>
                    <input class="notificationChoice" name="notifications"
                           type="checkbox" <?= ($model->user->notifications != null && $model->user->notifications[0]->browser == 1) ? addslashes("checked") : addslashes("") ?>
                           value="browserNotification" id="browserNotification"/>
                    <label for="browserNotification">В браузере</label>
                </p>
            </div>

          <?php ActiveForm::end(); ?>
        </div>
    </div>


  <?php if (!$model->module->enableAccountDelete): ?>
      <div class="panel panel-danger">
          <div class="panel-heading">
              <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
          </div>
          <div class="panel-body">
              <p>
                <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                <?= Yii::t('user', 'It will be deleted forever') ?>.
                <?= Yii::t('user', 'Please be certain') ?>.
              </p>
            <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                'class' => 'btn btn-danger',
                'data-method' => 'post',
                'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
            ]) ?>
          </div>
      </div>
  <?php endif ?>
</div>
<?php if (!$model->module->enableAccountDelete): ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
        </div>
        <div class="panel-body">
            <p>
              <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
              <?= Yii::t('user', 'It will be deleted forever') ?>.
              <?= Yii::t('user', 'Please be certain') ?>.
            </p>
          <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
              'class' => 'btn btn-danger',
              'data-method' => 'post',
              'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
          ]) ?>
        </div>
    </div>
<?php endif ?>
</div>
</div>
