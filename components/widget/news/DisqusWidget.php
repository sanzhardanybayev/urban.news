<?php

namespace app\components\widget\news;


use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class DisqusWidget extends Widget
{
  public $pageUrl = '';
  public $identifier = '';

  public function init()
  {
    parent::init();
  }

  public function run()
  {

    $output = '';

    return  Html::decode($output);
  }

}