<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\FroalaAsset;
use app\assets\PushNotificationsAsset;
use app\models\Notifications;
use app\models\AuthAssignment;

AppAsset::register($this);
// if user is not guest and if he allowed to send him browser notifications
if (!Yii::$app->user->isGuest && (Notifications::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->browser == 1)) {
  PushNotificationsAsset::register($this);
  // Include appropriate JS depending on role
  switch (AuthAssignment::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->item_name) {
    case "admin" :
      \app\assets\AdminAsset::register($this);
      break;
    case "moderator" :
      \app\assets\ModeratorAsset::register($this);
      break;
    case "registeredUser" :
      \app\assets\RegisteredUserAsset::register($this);
      break;
  }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Almaty Urban News',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/user/login']]
            ) : (
               '<li>'
                . Html::beginForm(['/user/profile'], 'get', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'My Profile',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
                .'<li>'
                . Html::beginForm(['/user/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'

            ),
            Yii::$app->user->isGuest ? (
            ['label' => 'SignUp', 'url' => ['/site/signup']]
            ) : ''
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; UrbanNews <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
