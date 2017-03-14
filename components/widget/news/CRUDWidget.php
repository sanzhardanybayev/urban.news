<?php

namespace app\components\widget\news;

use yii\base\Widget;
use yii\bootstrap\Html;

class CRUDWidget extends Widget
{
  public $id;
  public $active;
  public $user_id;

  public function init()
  {
    parent::init();

  }

  public function run()
  {
    $ifChecked = ($this->active) ? "checked='checked'" : "";
    $updateURL = '/news/update/'. $this->id;
    $output = " 
                  <div class='switch publish'>
                       Опубликовать
                      <label>
                        
                        <input ". $ifChecked ."   class='publishIt' name='publish' type='checkbox' article_id='". $this->id ."' action='/news/publish/" . $this->id . "/'>
                        <span class='lever'></span>
                        
                      </label>
                    </div>
                   
                  <a href='" . $updateURL. "/'
                     class=\"waves-effect waves-light darken-1 blue btn\">
                      Редактировать
                   </a>
                   
                  <a href='javascript: void(0)' 
                     link='/news/delete/" . $this->id . "/' 
                     class=\"deleteButton waves-effect waves-light darken-2 red btn\">
                      Удалить
                   </a>";

    return  Html::decode($output);

  }
}