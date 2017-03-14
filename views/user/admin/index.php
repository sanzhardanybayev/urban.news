<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

<?//= $this->render('/admin/_menu') ?>
<?//= Menu::widget() ?>

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
    <div class="card col s12">
        <?php Pjax::begin() ?>

        <?= GridView::widget([
            'dataProvider'  =>  $dataProvider,
            'filterModel'   =>  $searchModel,
            'layout'        =>  "{items}\n{pager}",
            'columns' => [
                'username',
                'email:email',
                [
                    'attribute' => 'registration_ip',
                    'value' => function ($model) {
                        return $model->registration_ip == null
                            ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
                            : $model->registration_ip;
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if (extension_loaded('intl')) {
                            return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                        } else {
                            return date('Y-m-d G:i:s', $model->created_at);
                        }
                    },
                ],
                [
                    'header' => Yii::t('user', 'Confirmation'),
                    'value' => function ($model) {
                        if ($model->isConfirmed) {
                            return '<div class="text-center">
                                        <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                                    </div>';
                        } else {
                            return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                            ]);
                        }
                    },
                    'format' => 'raw',
                    'visible' => Yii::$app->getModule('user')->enableConfirmation,
                ],
                [
                    'header' => Yii::t('user', 'Block status'),
                    'value' => function ($model) {
                        if ($model->isBlocked) {
                            return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                            ]);
                        } else {
                            return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-danger btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                            ]);
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>

        <?php Pjax::end() ?>
    </div>
</div>