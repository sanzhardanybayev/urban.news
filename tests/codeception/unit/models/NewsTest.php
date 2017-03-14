<?php

namespace tests\codeception\unit\models;

use AcmePack\UnitTester;
use app\models\News;
use app\models\RegistrationForm;
use Codeception\Specify;

use app\models\User;

class NewsTest extends \Codeception\Test\Unit
{
  use Specify;
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function setUp()
  {
    parent::setUp();
    // uncomment the following to load fixtures for user table
    //$this->loadFixtures(['user']);
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
