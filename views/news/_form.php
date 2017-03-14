<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form ">

    <?php $form = ActiveForm::begin(['options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>

    <input type="hidden" name="News[user_id]" value="<?=$id?>">
    <div class="row">
        <div class="input-field col s6">
            <input placeholder="<?=($model->title) ? $model->title : ''?>" id="title" type="text" name="News[title]" class="validate" value="<?=($model->title) ? $model->title : ''?>">
            <label for="first_name">Заголовок</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <textarea name="News[short_description]" id="News[short_description]" class="materialize-textarea" cols="6"><?=$model->short_description?></textarea>
            <label for="News[short_description]">Краткое описание</label>
        </div>
    </div>

    <div class="row">
        <h5>Основной текст</h5>
        <textarea name="News[content]" id="edit"><?=$model->content?></textarea>
    </div>

    <div class="row">
        <h5>Обложка новости</h5>

        <?php if(!$model->isNewRecord) { ?>
            <img class="materialboxed col s12 m4" src="/<?= ($model->preview_img) ? $model->preview_img : ''?>">
        <?php } ?>

        <div class="file-field input-field col s12 <?=($model->isNewRecord) ? '' : 'm6'?>">
            <div class="btn blue">
                <span><?=($model->isNewRecord) ? 'Загрузить обложку' : 'Обновить обложку'?> </span>
                <input type="file" name="News[preview_img]" value="/<?= ($model->preview_img) ? $model->preview_img : ''?>">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>


   <div class="form-group col s12">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'waves-effect waves-light blue     btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
