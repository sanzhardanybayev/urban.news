<?php
/**
 * Copyright (c) 2017.  This piece of code is made my Sanzhar Danybayev
 */

namespace app\tests\codeception\unit\models;
use app\models\News;
use Yii;

class NewsTest extends \Codeception\Test\Unit
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
  }

  protected function _after()
  {
  }


  // tests
  public function testCheckingIfPropValidationWorks()
  {
    $article =  new News();
    $article->title = 123;
    $this->assertFalse($article->validate(['title']));

    $article->title = true;
    $this->assertFalse($article->validate(['title']));

    $article->title = 'This';
    $this->assertTrue($article->validate(['title']));

  }

  public function testCheckingIfArticleIsCreated(){

    $article = new News();
    $article->title = "This is it!";
    $article->user_id = 1;
    $article->short_description = 'Short Description';
    $article->content = 'content';
    $article->preview_img = '';
    $article->save();

    $this->tester->seeRecord('app\models\News',['title' => 'This is it!']);
  }

  public function testCheckingIfArticleIsCreatedAndThenDeleted(){

    $article = new News();
    $article->title = "This is it!";
    $article->user_id = 1;
    $article->short_description = 'Short Description';
    $article->content = 'content';
    $article->preview_img = '';
    $article->save();

    $this->tester->seeRecord('app\models\News',['title' => 'This is it!']);
    $article->delete();
    $this->tester->dontSeeRecord('app\models\News',['title' => 'This is it!']);
  }
}