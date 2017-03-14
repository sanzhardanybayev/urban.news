<?php

namespace tests\codeception\unit\models;

use AcmePack\UnitTester;
use app\models\RegistrationForm;
use Codeception\Specify;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
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

  public function testCheckingPropsValidation()
  {
    $user = new User();
    $user->username = true;
    $user->email = 'string';

    $this->specify('Validation must return error as username type is BOOLEAN', function () use ($user) {
      expect('username type validation will not pass', $user->validate(['username']))->false();
      expect('email validation will not pass', $user->validate(['email']))->false();
    });

    $user->username = 'admin';
    $user->email = 'test@mail.ru';

    $this->specify('Validation must return success', function () use ($user) {
      expect('username type validation will  pass', $user->validate(['username']))->true();
      expect('email validation will  pass', $user->validate(['email']))->true();
    });


  }

  public function testCheckingIfUserIsCreated()
  {

    $user = new RegistrationForm();
    $user->username = "Tester";
    $user->email = 'tester@mail.ru';
    $user->password = 'qwe123';
    $user->register('admin');

    $this->specify('User should be created', function () use ($user) {
      $this->tester->seeRecord('app\models\User', ['username' => $user->username, 'email' => $user->email]);
    });

  }

  public function testMakingSureThatUserRoleIsSet()
  {

    $user = new RegistrationForm();
    $user->username = "Tester";
    $user->email = 'tester@mail.ru';
    $user->password = 'qwe123';
    $user->register('admin');

    $userId = User::find()->where(['email' => $user->email])->one()->id;

    $this->specify('User role should be set', function () use ($userId) {
      $this->tester->seeRecord('app\models\AuthAssignment', ['user_id' => $userId, 'item_name' => 'admin']);
    });
  }
}
