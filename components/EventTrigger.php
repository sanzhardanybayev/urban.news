<?php


namespace app\components;

use Yii;

class EventTrigger
{

  public $event_id;
  public $event_type;
  public $event_name;
  public $initiator_name;
  public $subject_name;
  public $subject_id;
  public $subject_image;
  public $notification_subject_url;

  /**
   * EventTrigger constructor.
   * This function initiates EventTrigger
   * @param $eventId
   * @param $eventName
   * @param $initiatorName
   * @param $eventType
   * @param $subjectName
   * @param $subjectId
   * @param $subjectImage
   */
  public function __construct($eventId, $eventName, $initiatorName, $eventType, $subjectName, $subjectId, $subjectImage)
  {
    $this->event_id = $eventId;
    $this->event_name = $eventName;
    $this->initiator_name = $initiatorName;
    $this->event_type = $eventType;
    $this->subject_name = $subjectName;
    $this->subject_id = $subjectId;
    $this->subject_image = $this->returnSubjectImgURI($subjectImage);
    $this->notification_subject_url = $this->returnSubjectURL();
  }

  /**
   * Determines which url to assign to that event depending on it's type
   * @return null|string
   */
  private function returnSubjectURL()
  {
    if ($this->subject_id != null && $this->event_name != 'Удалился пользователь') {
      switch ($this->event_type) {
        case "NEWS_EVENT":
          return Yii::$app->request->getHostInfo() . '/news/' . $this->subject_id . '/';
          break;
        case "USER_EVENT":
          return Yii::$app->request->getHostInfo() . '/user/' . $this->subject_name . '/';
          break;
        case "PROFILE_EVENT":
          return Yii::$app->request->getHostInfo() . '/user/' . $this->subject_name . '/';
          break;
      }
    } else {
      return null;
    }
  }

  /**
   * Determines which default image to assign to that event if image property is not set
   * @param $subjectImage
   * @return string
   */
  private function returnSubjectImgURI($subjectImage)
  {
    switch ($this->event_type) {
      case "NEWS_EVENT":
        return ($subjectImage != null) ? Yii::$app->request->getHostInfo() . '/' . $subjectImage : Yii::$app->request->getHostInfo() . '/dist/img/icon.png';
        break;
      case "USER_EVENT":
        return ($subjectImage != null) ? Yii::$app->request->getHostInfo() . '/' . $subjectImage : Yii::$app->request->getHostInfo() . '/dist/img/icon.png';
        break;
      case "PROFILE_EVENT":
        return ($subjectImage != null) ? Yii::$app->request->getHostInfo() . '/' . $subjectImage : Yii::$app->request->getHostInfo() . '/dist/img/icon.png';
        break;
    }
  }
}