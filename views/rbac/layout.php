<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this     yii\web\View
 * @var $content string
 */

use dektrium\rbac\widgets\Menu;

?>

<?//= Menu::widget() ?>
<ul id="w2" class="nav-tabs card adminNav nav">
    <li><a href="/user/admin/index">Пользователи</a></li>
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

<div style=" padding: 10px 0">
    <div class="row">
        <div class="card col s12">
            <?= $content ?>
        </div>
    </div>
</div>