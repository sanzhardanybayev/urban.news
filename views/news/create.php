<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = 'Добавление статьи';
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="card col s11 m12" id="account">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title"><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'          => 'create-form',
                    'options'     => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
//                    'enableAjaxValidation'   => true,
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

                    <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'required'=>'required', 'type' => 'text', 'class' => '\'form-control validate input-field col s12'])->label('Заголовок',['class' => '','data-error' => 'Неправильный формат',  'data-success' => 'Все верно']) ?>

                    <div class='row'>
                        <div class=\"input-field col s12\">
                        <?= $form->field($model, 'short_description')->textarea(['class' => 'materialize-textarea', 'required'=>'required'])->label('Краткое описание') ?>
                        </div>
                    </div>

                    <div class="row">
                        <?= $form->field($model, 'content')->textarea(['class' => 'materialize-textarea','id' => 'edit', 'required'=>'required'])->label('Основной текст') ?>
                    </div>

                    <div class="row">
                        <h5>Обложка новости</h5>

                        <?php if(!$model->isNewRecord) { ?>
                            <img class="materialboxed col s12 m4" src="/<?= ($model->preview_img) ? $model->preview_img : ''?>">
                        <?php } ?>

                        <div class="file-field input-field col s12 <?=($model->isNewRecord) ? '' : 'm6'?>">
                            <div class="btn blue">
                                <span><?=($model->isNewRecord) ? 'Загрузить обложку' : 'Обновить обложку'?> </span>
                                <input type="file" required name="News[preview_img]" value="/<?= ($model->preview_img) ? $model->preview_img : ''?>">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row col s12">
                        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'waves-effect waves-light blue   col s12  btn']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<!--                --><?//= $this->render('_form', [
//                    'model' => $model,
//                    'id' => Yii::$app->user->identity->getId()
//                ]) ?>


