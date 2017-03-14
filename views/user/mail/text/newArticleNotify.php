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
  Уважаемый <?= $user->username ?>, <?= $author->username ?> только что добавил новость.
</p>
<ul>
  <li>Название - <?= $article->title?></li>
    <li>Ссылка - <a href="<?= $host ?>/news/<?= $article->id?>/" target="_blank"> <?= $article->title ?> </a></li>
</ul>