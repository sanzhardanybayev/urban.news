<?php


namespace app\components\widget;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use app\components\widget\user\UserInfoWidget;

class ProfileBarWidget extends Widget
{
  public $avatar;
  public $username;
  public $location;
  public $website;
  public $public_email;
  public $created_at;
  public $bio;

  public function run()
  {
    $output = '<section class="row profile_bar">
                      <div class="profileCover"></div>
                      <div class="container">
                          <div class="col s6 offset-m3 m2">
                              <div class="avatar_small img-rounded img-responsive col s12"
                                   style="background: url('. $this->avatar .')">
                              </div>
                          </div>
                          <div class="col s6 m7">';

    $output .= UserInfoWidget::widget(['username' => $this->username,
                                        'location' => $this->location,
                                        'website' => $this->website,
                                        'public_email' => $this->public_email,
                                        'created_at' => $this->created_at,
                                        'bio' => $this->bio]);
    $output .= '
                            </div>
                        </div>
                 </section>';

    return Html::decode($output);
  }

}