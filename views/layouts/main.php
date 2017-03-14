<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\components\widget\BreadcrumbsWidget as Breadcrumbs;
use app\components\widget\HeaderWidget;
use app\components\widget\ProfileBarWidget as ProfileWidget;
use app\components\widget\floatingButton\FloatingButton;
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
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= HeaderWidget::widget(); ?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?= ($this->params['profile_bar']->user_id != null) ? ProfileWidget::widget([
    'avatar' => (!empty($this->params['profile_bar']->avatar)) ? "/" . $this->params['profile_bar']->avatar : "/dist/img/default.png",
    'username' => $this->params['profile_bar']->user->username,
    'location' => (!empty($this->params['profile_bar']->location)) ? $this->params['profile_bar']->location : '',
    'website' => (!empty($this->params['profile_bar']->website)) ? $this->params['profile_bar']->website : '',
    'public_email' => (!empty($this->params['profile_bar']->public_email)) ? $this->params['profile_bar']->public_email : '',
    'created_at' => $this->params['profile_bar']->user->created_at,
    'bio' => (!empty($this->params['profile_bar']->bio)) ? $this->params['profile_bar']->bio : ''
]) : '' ?>


<div class="container">
  <?= $content ?>
</div>

<!-- Floating button for moderators and admins -->
<?php if ((Yii::$app->user->can('createPost'))) {
  FroalaAsset::register($this);
  $floatingButton = new FloatingButton();
  $floatingButton->run();
} ?>

<footer class="page-footer ">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">О проекте</h5>
                <p class="grey-text text-lighten-4">Читайте и делитесь свежими новостями о Вашем городе</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p class="pull-left">&copy; UrbanNews <?= date('Y') ?></p>
        </div>
    </div>
</footer>

<?php if (isset($this->params['message'])) { ?>
    <script>
        Materialize.toast("<?= ($this->params['name']) ? $this->params['name'] . ', ' : '' ?><?= ($this->params['message']) ? $this->params['message'] : '' ?>", 4000<?= ($this->params['success']) ? ',"green"' : ''?>) // 4000 is the duration of the toast
    </script>
<?php } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
