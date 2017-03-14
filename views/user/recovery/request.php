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
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="card col s11 m6 offset-m3">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title"><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'password-recovery-form',
                    'options'     => ['class' => 'form-horizontal'],
                    'enableAjaxValidation'   => true,
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

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'required'=>'required', 'type' => 'email', 'class' => '\'form-control validate input-field col s12'])->label('Email',['class' => '','data-error' => 'Неправильный формат',  'data-success' => 'Все верно']) ?>


                <div class="form-group">
                    <div class="row col s12">
                        <?= Html::submitButton(Yii::t('user', 'Продолжить'), ['id' => "", 'class' => 'airPlane btn btn-primary btn-block col s12']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
