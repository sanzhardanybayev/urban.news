<?php

use app\components\widget\news\PostPreviewWidget;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Urban News | Find interesting stories of your city';
?>
<div class="site-index">

    <h5>Последние новости</h5>


        <?php
        if(empty($models)){
            echo "<h5 class='col s12'> Нет новостей </h5>";
        }
        else{
            $i=0;
            $j=1;

            foreach ($models as $model) {
                if($i%3===0 || $i===0) { echo "<div class='row'>"; }
                    echo PostPreviewWidget::widget(
                        ['id' => $model->id,
                            'title' => $model->title,
                            'short_description' => strlen($model->short_description) > 213 ? substr($model->short_description,0,209)." ..." : $model->short_description,
                            'preview_img' => $model->preview_img,
                            'content' => $model->content,
                            'avatarURL' => $model->user->profile->avatar,
                            'author_name' => $model->user->username,
                            'user_id' => $model->user->id,
                            'created_at' => Yii::$app->formatter->asDate($model->created_at),
                        ]);
                if($j%3==0 || $j==sizeof($models)) { echo "</div>"; }
                $i++;
                $j++;
            }

        }
        ?>
    <div>
        <?php

        // display pagination
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>
