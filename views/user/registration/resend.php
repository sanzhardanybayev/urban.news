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

/*
 * @var yii\web\View                    $this
 * @var dektrium\user\models\ResendForm $model
 */

$this->title = Yii::t('user', 'Запрос на повторное получение письма подтверждения');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="card col s11 m6 offset-m3 amplify">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="col s12 panel-title"><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'resend-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'options' => ['class' => 'form-group col s12'],
                        'template' => "<div class='row'>
                                            <div class=\"input-field col s12\">
                                                {input}\n
                                                {label}\n
                                                <div class=\"form-control-focus\"> </div>
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

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'required'=>'required', 'type' => 'email', 'class' => '\'form-control validate input-field col s12'])->label('Email',['class' => '','data-error' => 'Неправильный формат',  'data-success' => 'Все верно']) ?>

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
      </div><span class="send">Отправить</span></span><span class="fa fa-paper-plane steady"></span>'), ['id' => "resendConfirmationEmail", 'class' => 'airPlane btn btn-primary btn-block col s12','disabled' => 'disabled']) ?><br>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
