<?php


namespace app\events\news;

use yii\base\Event;

class NewsEvent extends Event
{
  public $article_id;
  public $article_name;
  public $event_name;
  public $author;
  public $article_img = null;
  public $event_type = 'NEWS_EVENT';


  /**
   * NewsEvent constructor.
   * @param $article_name
   * @param $eventName
   * @param $author
   */
  public function __construct($articleId, $articleName, $eventName, $author, $articleImage = null)
  {
    $this->article_id = $articleId;
    $this->article_name = $articleName;
    $this->event_name = $eventName;
    $this->author = $author;
    $this->article_img = $articleImage;
  }


}