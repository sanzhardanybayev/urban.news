<?php

namespace app\events\profile;


use yii\base\Event;

class ProfileEvent extends Event
{
  public $role;
  public $user_id;
  public $username;
  public $event_name;
  public $event_type;

  public function __construct($role, $user_id, $username, $event_name, $event_type)
  {
    $this->role = $role;
    $this->user_id = $user_id;
    $this->username = $username;
    $this->event_name = $event_name;
    $this->event_type = $event_type;
  }

}