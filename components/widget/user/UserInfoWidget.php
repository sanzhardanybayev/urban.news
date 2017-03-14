<?php


namespace app\components\widget\user;

use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class UserInfoWidget extends Widget
{
  public $username;
  public $location;
  public $website;
  public $public_email;
  public $created_at;
  public $bio;

  public function init()
  {
    parent::init();
  }

  public function run()
  {

    if ($this->location != '') {
      $location = '<li>
                     <i class="fa fa-location-arrow" aria-hidden="true"></i>
                     ' . Html::encode($this->location) . '
                 </li>';
    } else {
      $location = '';
    }

    if ($this->website != '') {
      $website = '<li>' . Html::a(Html::encode($this->website), Html::encode($this->website), ["target" => "_blank"]) . '</li>';
    } else {
      $website = '';
    }

    if ($this->public_email != '') {
      $public_email = '<li>
                        ' . Html::a(Html::encode($this->public_email), "mailto:" . Html::encode($this->public_email)) . '
                      </li>';
    } else {
      $public_email = '';
    }

    if ($this->bio != '') {
      $bio = '"' . Html::encode($this->bio) . '"';
    } else {
      $bio = '';
    }

    $output = '<h5>' . $this->username . '</h5>
                <ul style="padding: 0; list-style: none outside none;">
                  <li>
                  ' . $bio . '
                  </li>
                  ' . $location . '
                  ' . $website . '
                  ' . $public_email . '
                  <li>' . Yii::t("user", "Joined on {0, date}", $this->created_at) . '</li>
                </ul>';

    return Html::decode($output);
  }
}