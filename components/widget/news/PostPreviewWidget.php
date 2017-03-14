<?php

namespace app\components\widget\news;

use app\components\utility;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\components\widget\news\CRUDWidget as CRUDWidget;

class PostPreviewWidget extends Widget
{
  public $id;
  public $short_description;
  public $title;
  public $content;
  public $preview_img;
  public $avatarURL;
  public $created_at;
  public $author_name;
  public $crud = false;
  public $default_avatar = 'dist/img/default.png';
  public $active;
  public $user_id;
  public $test;

  public function init()
  {
    parent::init();

  }

  /**
   * @return string
   */
  public function run()
  {
    $linkText = ($this->test) ? 'Read' : 'Читать';
    $avatarURL = ($this->avatarURL) ? $this->avatarURL : $this->default_avatar;
    $output = "<div class=\"col s12 m4\">
                        <div class='card '>
                            <div class=\"card-image\">
                                <a href='/news/" . $this->id . "'>
                                    <div class='blackDiv'> </div>
                                    <div class='poster' style='background: url(/" . $this->preview_img . ")'></div>
                                    <span class=\"card-title\">" . $this->title . "</span>
                          
                                </a>
                            </div>
                         
                            <div class=\"card-content\">
                               <div class='row post-info'>
                                  <div class='chip '>
                                    <a href='/user/" . $this->author_name . "'>
                                        <div class='ava_mini' style='background: url(/" . $avatarURL . ")'> </div>
                                        " . $this->author_name . "
                                    </a>
                                  </div>
                                  <div class='created'>
                                    <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> " . $this->created_at . "
                                  </div>
                                </div>
                                  <p><bold>" . $this->short_description . "</p>
                            </div>
                            <div class=\"card-action\">
                              <a href='/news/" . $this->id . "'>". $linkText ."</a>
                         ";

    if ($this->crud) {
      $output .= CRUDWidget::widget(['id' => $this->id,
                                     'active' => $this->active,
                                      'user_id' => $this->user_id]);
    }

    $output .= "      
                                        </div>
                                    </div>
                                </div>";


    return Html::decode($output);
  }


}

?>