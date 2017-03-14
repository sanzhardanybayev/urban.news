<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\widget\news\PostPreviewWidget;


/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h5>Последние новости</h5>

    <div class="row">

        <?php
        if(empty($models)){
            echo "<h5 class='col s12'> Нет новостей </h5>";
        }
        else{
            $i=1;

            foreach ($models as $model) {
                if($i%4==0) { echo "<div class='row'>"; }
                echo PostPreviewWidget::widget(['title' => $model->title,
                    'id' => $model->id,
                    'short_description' => $model->short_description,
                    'preview_img' => $model->preview_img,
                    'content' => $model->content,
                    'avatarURL' => $model->user->profile->avatar,
                    'author_name' => $model->user->username,
                    'user_id' => $model->user->id,
                    'created_at' => Yii::$app->formatter->asDate($model->created_at,'long')]);
                if($i%3==0) { echo "</div>"; }
                $i++;
            }

        }
        ?>


    </div>
    <div>

      <?php

      // display pagination
      echo LinkPager::widget([
          'pagination' => $pages,
      ]);
      ?>
    </div>
</div>
