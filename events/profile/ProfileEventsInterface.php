<?php

namespace app\events\profile;


interface ProfileEventsInterface
{
  const EVENT_ON_NAME_CHANGED = 'onNameChange';
  const EVENT_ON_BIO_CHANGED = 'onBioChange';
  const EVENT_ON_WEBSITE_CHANGED = 'onWebsiteChange';
  const EVENT_ON_PUBLIC_EMAIL_CHANGED = 'onPublicEmailChange';
  const EVENT_ON_AVATAR_CHANGED = 'onAvatarChange';
}