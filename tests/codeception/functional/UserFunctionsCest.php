<?php


class UserFunctionsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToTest(FunctionalTester $I)
    {
      $I->wantTo('Make sure that login works');
      $I->amOnPage('/user/login/test/');
      $I->see('Login', 'h5');
      $I->see('Login', 'button');
      $I->expect('That user successfully logs in');
      $I->fillField('input[name="login-form[login]"]', 'admin');
      $I->fillField('input[name="login-form[password]"]', 'qwe123');
      $I->click('button');
      $I->seeCurrentUrlEquals('/');
    }

    public function tryToCheckIfAuthorizationWorks(FunctionalTester $I)
    {
      $I->wantTo('Make sure that authorization works');
      $I->amOnPage('/test/');
      $I->see('Latest news', 'h5');
      $I->expect('Redirect to login page');
      $I->click('Read');
      $I->seeCurrentUrlEquals('/user/register/');
    }


  public function tryToCheckIfModeratorRulesWorkProperly(FunctionalTester $I)
  {
    $I->wantTo('Make sure that login works');
    $I->amOnPage('/user/login/test/');
    $I->see('Login', 'h5');
    $I->see('Login', 'button');
    $I->expect('That user successfully logs in');
    $I->fillField('input[name="login-form[login]"]', 'moderator');
    $I->fillField('input[name="login-form[password]"]', 'qwe123');
    $I->click('button');
    $I->seeCurrentUrlEquals('/');
    $I->wantTo('Make sure that moderator rules work properly');
    $I->see('Создать пост', 'a');
    $I->cantSee('Добавить пользователя', 'a');
    $I->cantSee('Уведомить всех пользователей', 'a');
  }


  public function tryToCheckIfAdminRulesWorkProperly(FunctionalTester $I)
  {
    $I->wantTo('Make sure that login works');
    $I->amOnPage('/user/login/test/');
    $I->see('Login', 'h5');
    $I->see('Login', 'button');
    $I->expect('That user successfully logs in');
    $I->fillField('input[name="login-form[login]"]', 'admin');
    $I->fillField('input[name="login-form[password]"]', 'qwe123');
    $I->click('button');
    $I->seeCurrentUrlEquals('/');
    $I->wantTo('Make sure that admin rules work properly');
    $I->see('Создать пост', 'a');
    $I->see('Добавить пользователя', 'a');
    $I->see('Уведомить всех пользователей', 'a');
    $I->comment('Rules do work');
  }

}
