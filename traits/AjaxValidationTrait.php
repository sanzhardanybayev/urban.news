<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace app\traits;

use app\models\UploadForm;
use Symfony\Component\EventDispatcher\Event;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
trait AjaxValidationTrait
{
  /**
   * Performs ajax validation.
   *
   * @param Model $model
   *
   * @throws \yii\base\ExitException
   */
  protected function performAjaxValidation(Model $model)
  {
    if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->data   = ActiveForm::validate($model);
      \Yii::$app->response->send();
      \Yii::$app->end();
    }
  }

  /**
   * Performs ajax validation.
   *
   * @param Model $model
   *
   * @throws \yii\base\ExitException
   */
  protected function performAjaxValidationAndSending(Model $model)
  {
    if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {

      if ($model->resendAjax()) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset= 'UTF-8';
        \Yii::$app->response->data   = "Письмо было отправлено на Вашу почту. Оно содержит ссылку на страницу подтверждения.";
        \Yii::$app->response->send();
        \Yii::$app->end();
      }
      else{

        global $responseMessage;
        global $statusCode;

        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset= 'UTF-8';
        \Yii::$app->response->data   = $responseMessage;
        \Yii::$app->response->setStatusCode($statusCode,  $responseMessage);
        \Yii::$app->response->send();

        \Yii::$app->end();
      }
    }
  }

  /**
   * Performs ajax validation.
   *
   * @param Model $model
   *
   * @throws \yii\base\ExitException
   */
  protected function performAjaxValidationUpdate(Model $model)
  {
    if(!\Yii::$app->user->can('createUser') && \Yii::$app->request->post('settings-form')['current_password'] == ''){
      $responseMessage = 'Обязательно введите текущий пароль';
      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset= 'UTF-8';
      \Yii::$app->response->data   = $responseMessage;
      \Yii::$app->response->setStatusCode(400,  $responseMessage);
      \Yii::$app->response->send();

      \Yii::$app->end();
    }
    $oldEmail = $model->email;

    if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {

      if ($model->save($oldEmail)) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset= 'UTF-8';
        \Yii::$app->response->data   = "Аккаунт был успешно обновлен";
        \Yii::$app->response->send();
        \Yii::$app->end();
      }
      else{

        $responseMessage = \Yii::$app->session->getFlash('wrong_passwrd') ? \Yii::$app->session->getFlash('wrong_passwrd') : 'Неправильный пароль';
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset= 'UTF-8';
        \Yii::$app->response->data   = "Неправильный пароль";
        \Yii::$app->response->setStatusCode(400,  $responseMessage);
        \Yii::$app->response->send();

        \Yii::$app->end();
      }
    }
  }

  protected function performAjaxValidationUpdateFile(Model $model, UploadForm $file)
  {
    if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {

      if ($file->uploadavatar($model)) {
        if ($model->save()) {
          \Yii::$app->response->format = Response::FORMAT_JSON;
          \Yii::$app->response->charset = 'UTF-8';
          \Yii::$app->response->data = "Аккаунт был успешно обновлен";
          \Yii::$app->response->send();
          \Yii::$app->end();
        } else {

          global $responseMessage;
          global $statusCode;

          \Yii::$app->response->format = Response::FORMAT_JSON;
          \Yii::$app->response->charset = 'UTF-8';
          \Yii::$app->response->data = $responseMessage;
          \Yii::$app->response->setStatusCode($statusCode, $responseMessage);
          \Yii::$app->response->send();

          \Yii::$app->end();
        }
      }
      else{

        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->charset = 'UTF-8';
        \Yii::$app->response->data = "Не удалось загрузить фото";
        \Yii::$app->response->setStatusCode('500', "Не удалось загрузить фото");
        \Yii::$app->response->send();

        \Yii::$app->end();
      }
    }
  }

  protected function performAjaxRequestNews(Model $model,UploadForm $file, $request){

    if ($model->createArticle($file, $request)) {
      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset= 'UTF-8';
      \Yii::$app->response->data   = "Новость была успешно сохранена";
      \Yii::$app->response->send();
      \Yii::$app->end();
    }
    else{

      \Yii::$app->response->format = Response::FORMAT_JSON;
      \Yii::$app->response->charset= 'UTF-8';
      \Yii::$app->response->data   = 'Произошла ошибка';
      \Yii::$app->response->setStatusCode(500,  'Произошла ошибка');
      \Yii::$app->response->send();

      \Yii::$app->end();
    }


  }

}
