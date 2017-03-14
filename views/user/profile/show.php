<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\widget\news\PostPreviewWidget;


/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col s12 m12">
        <div class="row">

                <h5 class="col s12">Мои новости</h5>

                    <?php
                        if(empty($models)){
                            echo "<h5 class='col s12'> Нет новостей </h5>";
                        }
                        else{
                            $i=1;

                            foreach ($models as $model) {
                                if($i == 0 || $i%3==0) { echo "<div class='row'>"; }
                                echo PostPreviewWidget::widget(['id' => $model->id,
                                                            'title' => $model->title,
                                                            'short_description' => "" . (strlen($model->short_description) > 100 ? substr($model->short_description,0,100)."..." : $model->short_description),
                                                            'preview_img' => $model->preview_img,
                                                            'content' => $model->content,
                                                            'crud' => $crud,
                                                            'avatarURL' => ($model->user->profile->avatar) ? $model->user->profile->avatar : "dist/img/default.png",
                                                            'author_name' => $model->user->username,
                                                            'active' => $model->active,
                                                            'user_id' => $model->user->id,
                                                            'created_at' => Yii::$app->formatter->asDate($model->created_at,'short')]);
                                if($i%3 == 0) { echo "</div>"; }
                                $i++;
                            }

                        }
                    ?>


        </div>
    </div>
</div>
