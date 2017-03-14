<?php

namespace app\components\widget\floatingButton\actions;

use app\components\utility;
use app\models\AuthAssignment;
use app\models\News;
use app\models\User;
use Yii;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;


class NewsCreate extends Widget implements FloatingActionInterface
{

  private function initSelectAuthorDropDown($form,$news){
    $authorInput = '';
    $authors = array();
    $moderators = AuthAssignment::find()
        ->where(['item_name' => 'moderator'])
        ->orWhere(['item_name' => 'admin'])
        ->andWhere(['<>','user_id',Yii::$app->user->identity->id])
        ->all();

    foreach ($moderators as $moderator) {
      $user = User::findOne($moderator->user_id);
      $moderatorAvatar = ($user->profile->avatar) ? $user->profile->avatar : "dist/img/default.png";
      $authorValue = '<option  value="' . $user->id . '" data-icon="/' . $moderatorAvatar . '" class="left circle">' . $user->username . '</option>';
      array_push($authors, $authorValue);
    }

    if(Yii::$app->user->can('createUser')){
      $adminAvatar = (Yii::$app->user->identity->profile->avatar) ? Yii::$app->user->identity->profile->avatar : "dist/img/default.png";
      $authorInput = '
                        <div class="row">
                                <div class="input-field col s12 m6">
                                  <select class="icons" name="News[user_id]" required>
                                    <option value="" disabled >Выберите автора</option>
                                    <option selected value="'. Yii::$app->user->identity->id  .'"
                                             data-icon="/'. $adminAvatar .'" class="left circle">Я</option>
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

  public  function render(){

      $news = new News();
      echo '<div id="modal1" class="modal">
                  <div class="modal-content">
                    <h4>Создать статью</h4>';

                    $form = ActiveForm::begin([
                            "id" => "news-form",
                            "action" => "/news/create/",
                            "options" => ["class" => "form-horizontal", "enctype" => "multipart/form-data"],
                          //                    "enableAjaxValidation"   => true,
                            "enableClientValidation" => true,
                            "layout" => "horizontal",
                            "fieldConfig" => [
                                "options" => ["class" => "form-group col s12"],
                                "template" => "<div class='row'>
                                                                                    <div class='input-field col s12'>
                                                                                        {input}\n
                                                                                        {label}\n
                                                                                        <div class='form-control-focus'> </div>
                                                                                        \n{error}\n
                                                                                    </div>
                                                                                </div>",
                                "horizontalCssClasses" => [
                                    "label" => [],
                                    "offset" => "col-sm-offset-4",
                                    "wrapper" => "col-sm-10",
                                    "error" => "has-error",
                                    "hint" => "help-block",
                                ],
                            ]
                        ]);
                      echo $this->renderBody($form,$news);
                    ActiveForm::end();

    echo '        </div>
            </div>';
  }



  private function renderBody($form,$news){

    return $this->initSelectAuthorDropDown($form,$news) .'
          '. $form->field($news, "title")->textInput(["autofocus" => true, "required" => "required", "type" => "text", "class" => "form-control validate input-field col s12"])->label("Заголовок", ["class" => "", "data-error" => "Неправильный формат", "data-success" => "Все верно"]) .'
         
          '. $form->field($news, "short_description")->textarea(["class" => "materialize-textarea", "required" => "required"])->label("Краткое описание") .'
          
          <div class="row">
            <h6>Содержание новости*</h6>
              '. $form->field($news, "content")->textarea(["class" => "materialize-textarea", "id" => "edit", "required" => "required"])->label("Основной текст") .'
          </div>
          <div class="row">
            <h5>Обложка новости</h5>
            <div class="file-field input-field col s12">
              <div class="btn blue">
                <span>Загрузить обложку</span>
                <input type="file" required name="News[preview_img]">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
          </div>

          <div class="form-group row col s12">
              '. Html::submitButton("Добавить", ["action" => "/news/create", "id" => "news-form", "class" => "waves-effect waves-light blue   col s12  btn"]) .'
          </div>
          ';
  }
}