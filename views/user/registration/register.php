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
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */

$this->title = Yii::t('user', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="card col s11 m6 offset-m3">
        <div class="panel panel-default">
            <div class="panel-heading col s12">
                <h5 class="panel-title"><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
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

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'required'=>'required', 'type' => 'email','tabindex' => '1', 'class' => '\'form-control validate input-field col s12'])->label('Email',['class' => '','data-error' => 'Неправильный формат',  'data-success' => 'Все верно']) ?>


                <?= $form->field(
                    $model,
                    'username',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'type'=> 'text','class' => 'form-control validate input-field col s12', 'tabindex' => '2']]
                )->label('Логин',['class' => '','data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>


                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <div class="col s12">
                    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'col s12 btn btn-success btn-block']) ?>
                </div>
                <div class="row col s12">
                    <p class="center">
                        <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                    </p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
