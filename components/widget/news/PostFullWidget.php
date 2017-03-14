<?php

namespace app\components\widget\news;

use app\models\News;
use Codeception\Lib\Connector\Yii1;
use yii\base\Widget;
use yii\helpers\Html;

class PostFullWidget extends Widget
{
  public $short_description;
  public $title;
  public $content;
  public $preview_img;
  public $avatar;
  public $username;
  public $created_at;
  public $default_avatar = 'dist/img/default.png';
  public $url = '';
  public $user_id = '';
  public $article_id = '';


  public function init()
  {

    parent::init();

  }


  public function run()
  {
    $update_button = '';

    if(\Yii::$app->session->hasFlash('allowToUpdate')){
      $url = '/news/update/'. $this->article_id;

      if(\Yii::$app->user->can('createUser') && News::findOne($this->article_id)->user->getId() != \Yii::$app->user->identity->getId()){
        $url = '/news/update/user/'. $this->user_id .'/article/'. $this->article_id;
      }
      $update_button = '<a class="btn blue" href="'. $url .'/"> Редактировать </a>
                        <a href="javascript: void(0)"
                           link="/news/delete/'. $this->article_id .'/" 
                           class="deleteButton waves-effect waves-light darken-2 red btn">
                          Удалить
                       </a>';
    }
    $avatarURL = ($this->avatar) ? $this->avatar : $this->default_avatar;
    $output = "<div class=\"col s12 m12\">
                        <div class='card'>
                            <div class=\"card-image full\" >
                                <div class='blackDiv'></div>
                                <div class='posterFull' style='background: url(/" . $this->preview_img . ");'></div>
                                <h3 class=\"card-title col s12 center\" >" . $this->title . "</h3>
                                <div class='row col s4 post-info'>
                                    <div class='chip '>
                                        <a href='/user/" . $this->username . "'>
                                            <div class='ava_mini' style='background: url(/" . $avatarURL . ")'> </div>
                                            " . $this->username . "
                                        </a>
                                    </div>
                                    <div class='created'>
                                       <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> " . $this->created_at . "
                                    </div>
                                </div>
                            </div>
               
                        <div class=\"card-content full\">
                               <div class='row col s12'>
                                  ". $update_button ."
                               </div>
                              <p class='articleIntro'>" . $this->short_description . "</p>
                              <section id='fullDescription'>
                                  " . $this->content . "
                              </section>
                        </div>
                    </div>
                </div>";
    return Html::decode($output);
  }
}

?>