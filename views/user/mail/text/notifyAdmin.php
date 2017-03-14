<?php
use yii\helpers\Html;

/**
 * @var dektrium\user\Module        $module
 * @var dektrium\user\models\User   $user
 * @var dektrium\user\models\Token  $token
 * @var bool                        $showPassword
 */

?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
  Уважаемый <?= $user->username ?>, только зарегистрировался новый пользователь. Его данные :
</p>
<ul>
  <li>Имя пользователя - <?= $registeredUser->username ?></li>
  <li>Email - <?= $registeredUser->email ?></li>
  <li>IP адрес - <?= $registeredUser->registration_ip ?></li>
  <li>Роль - <?= $role ?></li>
</ul>