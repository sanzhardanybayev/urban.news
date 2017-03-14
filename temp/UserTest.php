<?php
/**
 * Copyright (c) 2017.  This piece of code is made my Sanzhar Danybayev
 */

namespace app\tests\codeception\unit\models;
use app\models\UserTest as User;
use app\models\RegistrationForm;
use dektrium\user\helpers\Password;
use Yii;

class UserTest extends \Codeception\Test\Unit
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
  public function testCheckingPropsValidation()
  {
    $user =  new User();
    $user->username = 123;
    $user->email = 'string';
    $this->assertFalse($user->validate(['username']));
    $this->assertFalse($user->validate(['email']));

    $user->username = true;
    $user->email = 'test@mail.ru';
    $this->assertFalse($user->validate(['username']));
    $this->assertTrue($user->validate(['email']));

    $user->username = 'This';
    $this->assertTrue($user->validate(['username']));

  }

  public function testCheckingIfUserIsCreated(){

  $user = new RegistrationForm();
  $user->username = "Tester";
  $user->email = 'tester@mail.ru';
  $user->password = 'qwe123';
  $user->register('admin');

  $this->tester->seeRecord('app\models\User',['username' => 'Tester']);
}

  public function testMakingSureThatUserRoleIsSet(){

  $user = new RegistrationForm();
  $user->username = "Tester";
  $user->email = 'tester@mail.ru';
  $user->password = 'qwe123';
  $user->register('admin');

  $userId = User::find()->where(['email' => $user->email])->one()->id;

  $this->tester->seeRecord('app\models\AuthAssignment',['user_id' => $userId, 'item_name' => 'admin' ]);
}
}