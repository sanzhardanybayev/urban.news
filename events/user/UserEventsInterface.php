<?php

namespace app\events\user;

interface UserEventsInterface
{
  const EVENT_ON_PASSWORD_CHANGED = 'onPasswordChange';
  const EVENT_ON_USER_CREATE = 'onUserCreate';
  const EVENT_ON_USER_DELETE = 'onUserDelete';
  const EVENT_ON_USER_BLOCK = 'onUserBlock';
  const EVENT_ON_EMAIL_CHANGED = 'onEmailChange';
  const EVENT_ON_LOGIN_CHANGED = 'onUsernameChange';

}