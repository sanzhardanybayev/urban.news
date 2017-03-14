<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use  yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */

$this->title = Yii::t('user', 'Вход');
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
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
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
                ]) ?>

                <?= $form->field(
                    $model,
                    'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'type'=> 'text','class' => 'form-control validate input-field col s12', 'tabindex' => '1']]
                    )->label('Логин',['class' => '','data-error' => 'Неправильный формат', 'data-success' => 'Все верно']) ?>


                <?= $form
                    ->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']]
                    )
                    ->passwordInput()
                    ->label(
                        Yii::t('user', 'Password')
                        .($module->enablePasswordRecovery ?
                            ' (' . Html::a(
                                Yii::t('user', 'Забыли пароль?'),
                                ['/user/recovery/request'],
                                ['tabindex' => '3']
                            )
                            . ')' : '')
                    ) ?>

                <div class="checkbox">
                    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4'],false)->label('Запомнить меня') ?>
                </div>

                <div class="col s12">
                    <?= Html::submitButton(
                        Yii::t('user', 'Войти'),
                        ['class' => 'col s12 btn btn-primary btn-block', 'tabindex' => '3', 'value' => 'login']
                    ) ?>
                <div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="col s12">
            <?php if ($module->enableConfirmation): ?>
                <p class="center">
                    <?= Html::a(Yii::t('user', 'Не получили письмо подтверждения?'), ['/user/resend']) ?>
                </p>
            <?php endif ?>
            <?php if ($module->enableRegistration): ?>
                <p class="center">
                    <?= Html::a(Yii::t('user', 'Нет аккаунта? Создайте!'), ['/user/register']) ?>
                </p>
            <?php endif ?>
            <?= Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ]) ?>
        </div>
            </div>
        </div>
    </div>
</div>
