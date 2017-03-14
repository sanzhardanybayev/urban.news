<?php


namespace app\models;
use dektrium\user\models\ResendForm as BaseResendForm;

class ResendForm extends BaseResendForm
{
  /**
   * AJAX ONLY! Creates new confirmation token and sends it to the user.
   *
   * @return bool
   */
  public function resendAjax()
  {
    if (!$this->validate()) {
      return false;
    }

    $user = $this->finder->findUserByEmail($this->email);

    if ($user instanceof User) {
      if(!$user->isConfirmed) {
        /** @var Token $token */
        $token = \Yii::createObject([
            'class' => Token::className(),
            'user_id' => $user->id,
            'type' => Token::TYPE_CONFIRMATION,
        ]);
        $token->save(false);
        $this->mailer->sendConfirmationMessage($user, $token);
        return true;
      }
      else{
        //User already confirmed himself
        global $responseMessage;
        global $statusCode;
        $responseMessage= 'Данная почта уже подтверждена.';
        $statusCode = 406;

        return false;
      }
    }
    else{
      //TODO check if this mail does not exists in the database
      //User with sent email does not exists=
      global $responseMessage;
      global $statusCode;
      $responseMessage= "Пользователь с данной почтой не существует";
      $statusCode = 406;

      return false;
    }

    return false;

  }
}