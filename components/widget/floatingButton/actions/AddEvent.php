<?php
/**
 * Created by PhpStorm.
 * User: Sanzhar
 * Date: 14.03.2017
 * Time: 16:45
 */

namespace app\components\widget\floatingButton\actions;

use app\models\AddEventForm;
use app\models\AuthAssignment;
use app\models\Models;
use app\models\News;
use app\models\User;
use Yii;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

class AddEvent extends Widget implements FloatingActionInterface
{
    private function initSelectAuthorDropDown($form,$addEventForm){
        $modelsInput = '';


        $options = [];
        foreach ($addEventForm->models as $model) {
            $modelValue = '<option  value="' . $model->id . '">' . $model->name . '</option>';
            array_push($options, $modelValue);
        }

        if(Yii::$app->user->can('createUser')){

            $modelsInput = '
                        <div class="row">
                                <div class="input-field col s12 m6">
                                  <select class="icons" name="addEventForm[model_id]" required>
                                    <option value="" disabled >Выберите модель</option>
                                    '. implode($options) .'
                                  </select>
                                  <label>Выберите модель</label>
                                </div>
                        </div>';
        }

        return $modelsInput;

    }

    public  function render(){

        $addEventForm = new AddEventForm();

        echo '<div id="modal4" class="modal">
                  <div class="modal-content">
                    <h4>Добавить событие</h4>';

        $form = ActiveForm::begin([
            "id" => "news-form",
            "action" => "/event/add/",
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


        echo $this->renderBody($form,$addEventForm);

        ActiveForm::end();

        echo '        </div>
            </div>';
    }


    private function renderBody($form,$addEventForm){


        return $this->initSelectAuthorDropDown($form,$addEventForm) .'
            
          '. $form->field($addEventForm, "event_name")->textInput(["autofocus" => true, "required" => "required", "type" => "text", "class" => "form-control validate input-field col s12"])->label("Название события", ["class" => "", "data-error" => "Неправильный формат", "data-success" => "Все верно"]) .'
         
          <div class="form-group row col s12">
              '. Html::submitButton("Добавить", ["action" => "/event/add/", "class" => "waves-effect waves-light blue   col s12  btn"]) .'
          </div>
          ';
    }
}