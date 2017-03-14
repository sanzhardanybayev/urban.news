<?php

use app\components\widget\news\DisqusWidget;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\widget\news\PostFullWidget;


/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">


    <div class="row">

        <?php

                echo PostFullWidget::widget(['title' => $model->title,
                'short_description' => $model->short_description,
                'preview_img' => $model->preview_img,
                'avatar' => $model->user->profile->avatar,
                'username' => $model->user->username,
                'created_at' => Yii::$app->formatter->asDate($model->created_at,'long'),
                'content' => $model->content,
                'user_id' => $model->user->id,
                'article_id' => $model->id]);

                echo DisqusWidget::widget(['pageUrl' => Yii::$app->request->getAbsoluteUrl(),
                                           'identifier' => $model->id]);
        ?>

    </div>

</div>
