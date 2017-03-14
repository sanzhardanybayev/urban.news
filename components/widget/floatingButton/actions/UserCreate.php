<?php


namespace app\components\widget\floatingButton\actions;


use app\models\AuthAssignment;
use app\models\News;
use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;


class UserCreate implements FloatingActionInterface
{
  public function render()
  {
    $user = new RegistrationForm();
    echo '<div id="modal2" class="modal">
                <div class="modal-content">
                  <h4>Создать пользователя</h4>';
    $userForm = ActiveForm::begin([
        'id' => 'registration-form',
        'action' => '/user/register/',
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
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
    ]);
    echo $this->renderBody($userForm, $user);
    ActiveForm::end();
    echo '      </div>
          </div>';
  }

  private function renderBody($form, $user)
  {
    return $form->field($user, "email")->textInput(["maxlength" => 255, "autofocus" => true, "required" => "required", "type" => "email", "class" => "form-control validate input-field col s12"])->label("E-mail", ["class" => "", "data-error" => "Неправильный формат", "data-success" => "Все верно"]) . '
           ' . $form->field($user, "username")->textInput(["maxlength" => 255, "autofocus" => true, "required" => "required", "type" => "text", "class" => "form-control validate input-field col s12"])->label("Имя пользователяl", ["class" => "", "data-error" => "Неправильный формат", "data-success" => "Все верно"]) . '
            <div class="row">
              <h4 class="col s12"> Роль </h4>
              <p class="col s12 m4">
                <input class="with-gap" name="role" type="radio" checked id="registered_user"  />
                <label for="registered_user">Обычный пользователь</label>
              </p> 
              <p class="col s12 m4">
                <input class="with-gap" value="moderator" name="role" type="radio" id="moderator"  />
                <label for="moderator">Модератор</label>
              </p>
                <p class="col s12 m4">
                  <input class="with-gap" value="admin" name="role" type="radio" id="admin"/>
                  <label for="admin">Админ</label>
              </p>
              </div>
           ' . $form->field($user, "password")->passwordInput(["autofocus" => true, "required" => "required", "class" => "form-control validate input-field col s12"])->label("Пароль", ["class" => "", "data-error" => "Неправильный формат", "data-success" => "Все верно"]) . '
           <div class="form-group row col s12">
            ' . Html::button(Yii::t('user', '<span><div class="hide sk-fading-circle">
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
                                        </div><span class="send">Сохранить</span></span><span class="fa fa-paper-plane steady"></span>'), ["action" => "/news/create", "id" => "addUser", "class" => "airPlane btn btn-primary btn-block col s12"]) . '
           </div>';
  }
}