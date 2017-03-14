<?php

namespace tests\codeception\unit\models;

use app\models\User;
use Yii;
use \app\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends \Codeception\Test\Unit
{
    use Specify;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function testLoginNoUser()
    {
        $model = \Yii::createObject(LoginForm::className());
        $model->username = "not_identity";
        $model->password = "not_identity";
        $model->rememberMe = false;

        $this->specify('user should not be able to login, when there is no identity', function () use ($model) {
            expect('model should not login user', $model->login())->false();
            expect('user should not be logged in', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginWrongPassword()
    {
        $model = \Yii::createObject(LoginForm::className());
        $model->username = "admin";
        $model->password = "wrong_password";
        $model->rememberMe = false;
        $model->login();

        $this->specify('user should not be able to login with wrong password', function () use ($model) {
            expect('model should not login user', $model->login())->false();
            expect('error message should be set', $model->errors)->hasKey('password');
            expect('user should not be logged in', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginCorrect()
    {
        $model = \Yii::createObject(LoginForm::className());
        $model->username = "admin";
        $model->password = "qwe123";
        $model->rememberMe = false;
        $model->login();

        $this->specify('user should be able to login with correct credentials', function () use ($model) {
            expect('model should login user', $model->login())->true();
            expect('error message should not be set', $model->errors)->hasntKey('password');
            expect('user should be logged in', Yii::$app->user->isGuest)->false();
        });
    }



}
