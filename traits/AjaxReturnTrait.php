<?php

namespace app\traits;


use yii\web\Response;

trait AjaxReturnTrait
{
  protected function returnAnswer($statusCode,$message)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    \Yii::$app->response->charset = 'UTF-8';
    \Yii::$app->response->data = $message;
    \Yii::$app->response->setStatusCode($statusCode, $message);
    \Yii::$app->response->send();
    \Yii::$app->end();
  }
}