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

    <!-- Include Font Awesome. -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Include Editor style. -->
    <link href="/vendor/froala/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/froala/css/froala_style.min.css" rel="stylesheet" type="text/css" />

<!--    <!-- Include Code Mirror style -->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">-->

    <!-- Include Editor Plugins style. -->
    <link rel="stylesheet" href="/vendor/froala/css/plugins/char_counter.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/code_view.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/colors.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/emoticons.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/file.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/fullscreen.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/image.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/image_manager.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/line_breaker.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/quick_insert.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/table.css">
    <link rel="stylesheet" href="/vendor/froala/css/plugins/video.css">
</head>
<body>
<?php $this->beginBody() ?>
<nav class="light-blue z-depth-1" role="navigation">
    <div class="nav-wrapper container">
        <a href="<?=Yii::$app->homeUrl?>" class="brand-logo">Almaty Urban News</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/">Home</a></li>
            <?php if(Yii::$app->user->isGuest) { ?>
                <li><a href="/user/login">SignIn</a></li>
                <li><a href="/user/signup">SignUp</a></li>
            <?php } else { ?>
                <li><a href="/user/profile">My profile</a></li>
                <li><a href="/user/settings/account">Settings</a></li>
                <li><a href="/user/logout">Logout(<?=Yii::$app->user->identity->username?>)</a></li>

            <?php } ?>

        </ul>
    </div>
</nav>


<div class="container">
    <!--        <div class="row">-->
    <!--            --><?//= Breadcrumbs::widget([
    //                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    //            ]) ?>
    <!--        </div>-->
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; UrbanNews <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<!-- Include JS files. -->
<script type="text/javascript" src="/vendor/froala/js/froala_editor.min.js"></script>

<!--<!-- Include Code Mirror. -->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>-->

<!-- Include Plugins. -->
<script type="text/javascript" src="/vendor/froala/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/file.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/vendor/froala/js/plugins/video.min.js"></script>
<script>
    $(function() {
        $('#edit').froalaEditor()
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
