<?php

namespace app\components\widget;

use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class UserCardWidget extends Widget
{
  public $username;
  public $avatar;
  public $email;
  public $blocked;


  public function init()
  {
    parent::init();
  }

  public function run(){
    $output = "<div class=\"col s12 m4\">
                        <div class='card'>
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
                              <a href='/news/" . $this->id . "'><i class=\"fa fa-book\" aria-hidden=\"true\"></i> Читать</a>
                         ";

    if ($this->crud) {
      $output .= CRUDWidget::widget(['id' => $this->id,
          'blocked' => $this->blocked]);
    }

    $output .= "      
                                        </div>
                                    </div>
                                </div>";
    return Html::decode($output);
  }

}