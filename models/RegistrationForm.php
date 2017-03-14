<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\components\utility;
use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use yii\web\Response;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationForm extends BaseRegistrationForm
{
  /**
   * Registers a new user account. If registration was successful it will set flash message.
   *
   * @return bool
   */
  public function register($role = '')
  {
    if (!$this->validate()) {
      if (\Yii::$app->request->isAjax) {

        $return_json = ['status' => 'error', 'message' => ' validation not passed'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return_json;

      } else {
        return false;
      }
    }

    /** @var User $user */
    $user = Yii::createObject(User::className());
    $user->setScenario('register');
    $this->loadAttributes($user);

    if (!$user->register($role)) {
      if (\Yii::$app->request->isAjax) {

        $return_json = ['status' => 'error', 'message' => ' registration not passed'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return_json;

      } else {
        return false;
      }
    }

    /** Assigning role to this user */
    $auth = Yii::$app->authManager;
    $userRole = $auth->getRole($role);
    $auth->assign($userRole, $user->id);

    if (!(\Yii::$app->request->isAjax)) {
      Yii::$app->session->setFlash(
          'info',
          Yii::t(
              'user',
              'Your account has been created and a message with further instructions has been sent to your email'
          )
      );
    }

    return true;
  }

}
