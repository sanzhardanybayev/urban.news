<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View                $this
 * @var dektrium\user\models\User   $user
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

<?//= $this->render('_menu') ?>
<ul id="w2" class="nav-tabs card adminNav nav">
    <li class="active"><a class="" href="/user/admin/index">Пользователи</a></li>
    <li class="<?= (Yii::$app->session->getFlash('role') == 'role') ? 'active' : '' ; ?>"><a href="/rbac/role/index">Роли</a></li>
    <li class="<?= (Yii::$app->session->getFlash('role') == 'permissions') ? 'active' : '' ; ?>"><a href="/rbac/permission/index">Разрешения</a></li>
    <li class="<?= (Yii::$app->session->getFlash('role') == 'rules') ? 'active' : '' ; ?>"><a href="/rbac/rule/index">Правила</a></li>
    <li class="dropdown">
        <a class='dropdown-button btn' href='#' data-activates='dropdown2'>Создать <i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <!-- Dropdown Structure -->
        <ul id='dropdown2' class='dropdown-content'>
            <li><a class="black-text center" href="/user/admin/create" tabindex="-1">Нового пользователя</a></li>
            <li><a class="black-text center" href="/rbac/role/create" tabindex="-1">Новую роль</a></li>
            <li><a class="black-text center" href="/rbac/permission/create" tabindex="-1">Новое разрешение</a></li>
            <li><a class="black-text center" href="/rbac/rule/create" tabindex="-1">Новое правило</a></li>
        </ul>
    </li>
</ul>

<div class="row">
    <div class="card">
        <div class="col m3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Nav::widget([
                        'options' => [
                            'class' => 'nav-pills nav-stacked',
                        ],
                        'items' => [
                            ['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/create']],
                            ['label' => Yii::t('user', 'Profile details'), 'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ]],
                            ['label' => Yii::t('user', 'Information'), 'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ]],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col m9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="alert alert-info">
                        <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
                        <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
                    </div>
                    <?php $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'enableAjaxValidation'   => true,
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'wrapper' => 'col-sm-9',
                            ],
                        ],
                    ]); ?>

                    <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
