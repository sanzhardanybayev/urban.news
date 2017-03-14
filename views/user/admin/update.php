<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\User;
use yii\bootstrap\Nav;
use yii\web\View;

/**
 * @var View    $this
 * @var User    $user
 * @var string  $content
 */

$this->title = Yii::t('user', 'Update user account');
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
                            [
                                'label' => Yii::t('user', 'Account details'),
                                'url' => ['/user/admin/update', 'id' => $user->id]
                            ],
                            [
                                'label' => Yii::t('user', 'Profile details'),
                                'url' => ['/user/admin/update-profile', 'id' => $user->id]
                            ],
                            ['label' => Yii::t('user', 'Information'), 'url' => ['/user/admin/info', 'id' => $user->id]],
                            [
                                'label' => Yii::t('user', 'Assignments'),
                                'url' => ['/user/admin/assignments', 'id' => $user->id],
                                'visible' => isset(Yii::$app->extensions['dektrium/yii2-rbac']),
                            ],
                            '<hr>',
                            [
                                'label' => Yii::t('user', 'Confirm'),
                                'url'   => ['/user/admin/confirm', 'id' => $user->id],
                                'visible' => !$user->isConfirmed,
                                'linkOptions' => [
                                    'class' => 'text-success',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                                ],
                            ],
                            [
                                'label' => Yii::t('user', 'Block'),
                                'url'   => ['/user/admin/block', 'id' => $user->id],
                                'visible' => !$user->isBlocked,
                                'linkOptions' => [
                                    'class' => 'text-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                                ],
                            ],
                            [
                                'label' => Yii::t('user', 'Unblock'),
                                'url'   => ['/user/admin/block', 'id' => $user->id],
                                'visible' => $user->isBlocked,
                                'linkOptions' => [
                                    'class' => 'text-success',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                                ],
                            ],
                            [
                                'label' => Yii::t('user', 'Delete'),
                                'url'   => ['/user/admin/delete', 'id' => $user->id],
                                'linkOptions' => [
                                    'class' => 'text-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure you want to delete this user?'),
                                ],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="row col m9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
