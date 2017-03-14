<?php

namespace app\components;
use yii\base\Component;

class EventController extends Component
{
  public $modelName;
  public $eventNames;


  /**
   * EventController constructor.
   * @param $modelName
   * @param array $eventNames
   */
  public function __construct($modelName, array $eventNames)
  {
    $this->modelName = '\app\models\\' . $modelName;
    $this->eventNames = $eventNames;
    $this->initSubscribtion();
  }

  /**
   * Triggers particular event
   * @param $eventName
   * @param $eventObject
   */
  public function triggerEvent($eventName, $eventObject)
  {
      $this->trigger($eventName, $eventObject);
  }

  /**
   * Initializes all events that are registered within certain Controller actions
   */
  private function initSubscribtion()
  {
    foreach ($this->eventNames as $eventName) {
      $this->on($eventName, [$this->modelName, $eventName]);
    }
  }
}