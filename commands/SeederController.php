<?php

namespace app\commands;

use app\models\Events;
use app\models\Models;
use app\models\News;
use app\models\Notifications;
use app\models\NotificationsManage;
use app\models\NotificationsMessageTemplates;
use app\models\RegistrationForm;
use app\models\UserRaw;
use app\models\WebsiteSettings;
use app\models\Role;
use app\traits\CustomSQL;
use dektrium\user\traits\ModuleTrait;
use Symfony\Component\EventDispatcher\Event;
use app\models\User;
use Yii;
use yii\console\Controller;

class SeederController extends Controller
{
  use CustomSQL;
  use ModuleTrait;

  /**
   * This method configures Authorization permissions
   */
  public function actionSeed()
  {
    $this->seedModels();
    $this->seedEvents();
    $this->seedNotifications();
    $this->seedMessageTemplates();
    $this->seedWebsiteSettings();
    $this->seedUsers();
    $this->seedNews();
  }


  private function seedModels()
  {
    $model = new Models();
    $model->name = 'news';
    $model->save();

    $model = new Models();
    $model->name = 'user';
    $model->save();

    $model = new Models();
    $model->name = 'profile';
    $model->save();
  }

  private function seedEvents()
  {

    $event = new Events();
    $event->name = 'onArticleCreate';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onArticleDelete';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onArticlePublish';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onTitleChange';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onContentChange';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onDescriptionChange';
    $event->model_id = 1;
    $event->save();

    $event = new Events();
    $event->name = 'onPreviewChange';
    $event->model_id = 1;
    $event->save();


    $event = new Events();
    $event->name = 'onUserCreate';
    $event->model_id = 2;
    $event->save();

    $event = new Events();
    $event->name = 'onUserDelete';
    $event->model_id = 2;
    $event->save();

    $event = new Events();
    $event->name = 'onUserBlock';
    $event->model_id = 2;
    $event->save();


    $event = new Events();
    $event->name = 'onPasswordChange';
    $event->model_id = 2;
    $event->save();


    $event = new Events();
    $event->name = 'onEmailChange';
    $event->model_id = 2;
    $event->save();

    $event = new Events();
    $event->name = 'onUsernameChange';
    $event->model_id = 2;
    $event->save();

    $event = new Events();
    $event->name = 'onNameChange';
    $event->model_id = 3;
    $event->save();

    $event = new Events();
    $event->name = 'onBioChange';
    $event->model_id = 3;
    $event->save();

    $event = new Events();
    $event->name = 'onWebsiteChange';
    $event->model_id = 3;
    $event->save();

    $event = new Events();
    $event->name = 'onPublicEmailChange';
    $event->model_id = 3;
    $event->save();

    $event = new Events();
    $event->name = 'onAvatarChange';
    $event->model_id = 3;
    $event->save();

  }

  private function seedNotifications()
  {
    $notifications = new NotificationsManage();
    $notifications->event_id = 1;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 1;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 1;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 2;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 2;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 2;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 3;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 3;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 3;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 4;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 4;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 4;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 5;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 5;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 5;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 6;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 6;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 6;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 7;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 7;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 7;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 1;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 8;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 8;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 8;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 9;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 9;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 9;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 10;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 10;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 10;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 11;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 11;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 11;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 12;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 12;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 12;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 2;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 13;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 13;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 13;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 14;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 14;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 14;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 15;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 15;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 15;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 16;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 16;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 16;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 17;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 17;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 17;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 18;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'admin';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 18;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'moderator';
    $notifications->model_id = 3;
    $notifications->save();

    $notifications = new NotificationsManage();
    $notifications->event_id = 18;
    $notifications->email = 1;
    $notifications->browser = 1;
    $notifications->role = 'registeredUser';
    $notifications->model_id = 3;
    $notifications->save();

  }

  private function seedMessageTemplates()
  {
    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 1;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 1;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 1;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что добавил новость - $article_title[$articlelink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 2;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что удалил новость - $article_title';
    $messageTemplate->browserMessage = '$author только что удалил новость - $article_title';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 2;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что удалил новость - $article_title';
    $messageTemplate->browserMessage = '$author только что удалил новость - $article_title';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 2;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что удалил новость - $article_title';
    $messageTemplate->browserMessage = '$author только что удалил новость - $article_title';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 3;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 3;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 3;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->browserMessage = '$author только что опубликовал новость - $article_title[$articlelink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 4;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлен заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 4;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлен заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 4;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлен заголовок для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 5;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 5;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 5;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 6;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 6;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 6;
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено краткое содержание для новости - $article_title[$articlelink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();


    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил превью для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено превью для новости - $article_title[$articlelink]';// to palce
    $messageTemplate->event_id = 7;
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил превью для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено превью для новости - $article_title[$articlelink]';// to palce
    $messageTemplate->event_id = 7;
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, $author только что обновил превью для новости - $article_title[$articlelink]';
    $messageTemplate->browserMessage = 'Обновлено превью для новости - $article_title[$articlelink]';// to palce
    $messageTemplate->event_id = 7;
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 1;
    $messageTemplate->save();

    // USERS
    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 8;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = 'Только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 8;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = 'Только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 8;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = 'Только что зарегистрировался $newUsername[$newUserLink]';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 9;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 9;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 9;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    // END
    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';// to palce

    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';// to palce

    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->emailMessage = 'Уважаемый $username, только что удалился $newUsername';
    $messageTemplate->browserMessage = 'Только что удалился $newUsername';// to palce

    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 10;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что заблокировали $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] заблокирован';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 10;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что заблокировали $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] заблокирован';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 10;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что заблокировали $newUsername[$newUserLink]';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] заблокирован';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 11;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой пароль';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил пароль';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 11;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой пароль';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил пароль';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 11;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой пароль';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил пароль';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 12;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свою почту';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил почту';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 12;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свою почту';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил почту';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 12;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свою почту';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил почту';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 13;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой логин';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил логин';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 13;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой логин';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил логин';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 13;
    $messageTemplate->emailMessage = 'Уважаемый $username, только что $newUsername[$newUserLink] поменял свой логин';
    $messageTemplate->browserMessage = '$newUsername[$newUserLink] обновил логин';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 2;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 14;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 14;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 14;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил имя';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 15;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 15;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 15;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил свое био';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 16;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 16;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 16;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил ссылку на сайт';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 17;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 17;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 17;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил публичную почту';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 18;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->role = 'admin';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 18;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->role = 'moderator';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

    $messageTemplate = new NotificationsMessageTemplates();
    $messageTemplate->event_id = 18;
    $messageTemplate->emailMessage = 'Уважаемый $username, $profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->browserMessage = '$profileUsername[$profileUserLink] обновил аватар';
    $messageTemplate->role = 'registeredUser';
    $messageTemplate->model_id = 3;
    $messageTemplate->save();

  }

  private function seedWebsiteSettings()
  {
    $websiteSettings = new WebsiteSettings();
    $websiteSettings->amountOfNewsOnMainPage = 9;
    $websiteSettings->amountOfNewsOnNewsPage = 9;
    $websiteSettings->save();
  }

  private function seedUsers()
  {
    // Password for  the following accounts is - qwe123#@!
    $this->registerUser("admin", '$2y$12$Y9R4qFlzw7Kznk024fjq2.ZpH7XqRx6zrEiygQqTlfNeDa.gJ5.Dy',
        "tester.dev.env@mail.ru", 'nblwMQbBJGU0AbYg4eGliPwh9bx3gnJy',
        1488242412, 1488242412, 1488242412, 'admin');
    // Password for  the following accounts is - qwe123#@!
    $this->registerUser("moderator", '$2y$12$Y9R4qFlzw7Kznk024fjq2.ZpH7XqRx6zrEiygQqTlfNeDa.gJ5.Dy',
        "moderator.dev.env@mail.ru", 'nblwMQbBJGU0AbYg4eGliPwh9bx3gnsy',
        1488242412, 1488242412, 1488242412, 'moderator');
    // Password for  the following accounts is - qwe123#@!
    $this->registerUser("reader", '$2y$12$Y9R4qFlzw7Kznk024fjq2.ZpH7XqRx6zrEiygQqTlfNeDa.gJ5.Dy',
        "registered.user.dev@mail.ru", 'nblwMQbBJGU0AbYg4eGliPwh9bx2gnsy',
        1488242412, 1488242412, 1488242412, 'registeredUser');


  }

  private function seedNews()
  {
    $admin_id = $this->processCustomSQL('SELECT id from user where username LIKE "admin"')[0];
    $moderator_id = $this->processCustomSQL('SELECT id from user where username LIKE "moderator"')[0];

    $this->createArticle('Modern Web Development',
        'This is the script for a talk I gave at Google Dev Fest MN in 2015. It was meant to be a lighthearted history of web development and a commentary on its future.',
        ' <h1>The NeXT™ Big Thing </h1>
                            <p>What’s the most important thing to come out of Switzerland? Chocolate? Clocks? Neutrality? The largest, most expensive scientific experiment in history which may eventually unlock the very secrets of the universe and unify our understanding of the smallest particles with that of the largest of heavenly bodies? No, none of these things. The answer is, of course, is the Internet. </p>
                            <img src="/dist/img/article1.jpg" />
                            <p>More specifically, the World Wide Web, which popularized the Internet. In 1980 when I was just an embryo in my mother’s belly, the internet was but an embryo in the mind of Physicist Tim Berners-Lee, who created a simple hypertext program called ENQUIRE as a personal database of people and software models.</p>',
        $admin_id,
        'dist/img/article1.jpg',
        1,
        1488312500,
        1488312507);
    $this->createArticle('Targeting Millennials? Snapchat is Your Marketing Strategy!',
        'Are you interested in exploring ways of how to reach out to a younger audience? Have you ever thought of using Snapchat in your business? As visual messaging has become increasingly popular in recent years, communication via tech devices has elevated to a completely new level. This is where Snapchat walks in!',
        ' <p>Snapchat is, as you may have heard, one of the currently most popular social (messaging) platforms which enables a quick and efficient communication around the world. Many of us, especially the middle age generation, would shrug their shoulders to this and say “Meh!”.¯\_(ツ)_/¯</p>
                            <p>However, the influence of Snapchat can easily be understood by looking into its achievement happened within only three years. Becoming the mainstream messaging platform in 2016, Snapchat has been successfully increasing the number of its users on a monthly basis. In September 2016, for example, the number of Snapchat users grew to 150 million active users, with 9.000 snaps shared per second. Imagine that! Even Facebook saw Snapchat as the potential money booster which resulted in a $3 billion offer unfortunately (or fortunately) refused by the Snapchat founders.</p>
                            <h1>How Snapchat Works</h1>
                            <img src="/dist/img/article2-1.jpg" />
                            <p>The first thing to keep in mind about Snapchat is the limited duration of the posts. A posted video or a photo will be visible to others only for a few seconds. Users can choose the duration from 1 to 10 seconds, but bear in mind that it will disappear forever after its duration finishes. This is also a challenge for marketers — how to gain attention in only 10 seconds? Furthermore, Snapchat filters are the most popular feature at the moment (even Facebook is now copying/pasting this), and the three editing tools enable users to design fun posts and grab some quick attention.</p>
                            <p>The first thing to keep in mind about Snapchat is the limited duration of the posts. A posted video or a photo will be visible to others only for a few seconds. Users can choose the duration from 1 to 10 seconds, but bear in mind that it will disappear forever after its duration finishes. This is also a challenge for marketers — how to gain attention in only 10 seconds? Furthermore, Snapchat filters are the most popular feature at the moment (even Facebook is now copying/pasting this), and the three editing tools enable users to design fun posts and grab some quick attention.</p>',
        $moderator_id,
        'dist/img/article2.jpg',
        1,
        1488313765,
        1488313772);
    $this->createArticle('Сбой в облачном сервисе Amazon вывел из строя Trello, Coursera и другие сайты',
        'В облачном сервисе Amazon Web Services произошёл сбой, говорится в сообщении на сайте компании. Из-за этого возникли проблемы в работе Trello, Coursera, Quora и других сайтов.',
        ' <p>The Verge отмечает, что из-за сбоя перестали работать сервисы Trello, Quora и IFTTT и сайт для определения доступности страниц Isitdownrightnow.com. Кроме того, «умный» помощник Alexa, а также термостаты и другие устройства для «умного» дома Nest столкнулись с проблемами при подключении к серверам.</p>
                            <p>Представители Amazon заметили, что индикатор на сайте, который отображает состояние сервисов компании, не работает из-за сбоя в S3.</p>',
        $moderator_id,
        'dist/img/article3.jpg',
        1,
        1488313990,
        1488313996);
    $this->createArticle('Послание Трампа конгрессу: что это такое и почему его так ждут?',
        'Во вторник президент США Дональд Трамп впервые выступит c традиционным посланием конгрессу "О положении страны" (State of the Union Address). Русская служба Би-би-си разбиралась, почему это ежегодное мероприятие в этот раз вызывает повышенный интерес.',
        '<p>В январе 2016 года Трамп критиковал последнее послание своего предшественника Барака Обамы. &quot;Обращение реально скучное, медленное и вялое - очень тяжело смотреть&quot;, - писал он в &quot;Твиттере&quot;.</p>
<p>Ближайшие часы покажут, насколько живо выступит сам Трамп.</p>

<h2>Когда?</h2>

<p>Трамп выступит с посланием 28 февраля в 21:00 по местному времени (в пять утра 1 марта по Москве). Обычай оглашать послание вечером основал в 1965 году Линдон Джонсон, чтобы гражданам удобнее было слушать его в прямом телеэфире.</p>

<h2>Где?</h2>

<p>В зале палаты представителей США на Капитолийском холме. Президент будет выступать с места, которое обычно занимает спикер.</p>

<h2>Перед кем?</h2>

<p>Количество мест в палате представителей составляет 435. Послание также будут слушать сенаторы, которых в верхней палате насчитывается 100 человек.</p>

<p>Заслушивание президентского послания - один из немногих случаев, когда обе палаты конгресса проводят совместное заседание. Также обе палаты утверждают итоги выборов президента США.</p>

<p>По традиции на заседании присутствуют также судьи Верховного суда, министры и члены Объединенного комитета начальников штабов.</p>

<p>В конгрессе 114-го созыва республиканцы располагают прочным большинством: 244 конгрессмена и 54 сенатора.</p>

<h2>Сколько займет времени?</h2>

<p>Неизвестно. Обычно послание длится чуть более часа.</p>

<h2>Вопросы и обсуждение?</h2>

<p>Не предусмотрены.</p>

<h2>Освещение?</h2>

<p>Послание будет транслироваться в прямом телеэфире и в режиме онлайн на сайте http://www.whitehouse.gov, а затем выложено там же в текстовом виде.</p>

<h2>Чем важно послание Трампа?</h2>

<p>Поскольку Трамп вступил в должность лишь 20 января этого года, речь идет не об отчете, а о программном выступлении. Намерения нового президента по ряду проблем ясны не до конца. Наблюдатели задаются вопросом, насколько практическая деятельность Трампа будет соответствовать его словам во время предвыборной кампании.</p>

<p>Трамп недавно охарактеризовал положение страны фразой &quot;Я унаследовал хаос&quot;. От него ждут разъяснений его грядущих шагов и радикальных инициатив.</p>

<p>&quot;Это возможность для американцев и членов конгресса услышать непосредственно от нашего нового президента [заявления] о его стратегиях и планах относительно решения актуальных проблем&quot;, - сказал накануне спикер палаты представителей Пол Райан.</p>

<h2>О чем может сказать Трамп?</h2>
<figure><img src="http://ichef.bbci.co.uk/news/624/cpsprodpb/A800/production/_94880034_capitol_bbc.jpg" alt="Здание Конгресса США" width="976" height="549" data-highest-encountered-width="624" class="fr-dii fr-draggable"></figure>

<p>Мнения комментаторов разделились. Одни ожидают объявления конкретных планов и законодательных инициатив, другие - эмоционального выступления в духе &quot;сделаем Америку великой&quot;.</p>

<p>Пресс-секретарь Белого дома Шон Спайсер высказывался осторожно. &quot;Президент затронет две основные темы: где мы сейчас и куда мы движемся. Это будет возможностью напомнить членам конгресса и американцам, что он обещал во время предвыборной кампании, что он уже сделал, а также поговорить о проблемах, с которыми сталкивается наша страна&quot;, - заявил он.</p>

<p>По словам Спайсера, президент &quot;хочет быть уверен, что жители страны знают, куда он ведет их, и почему он будет проводить политику, которую будет проводить&quot;, &quot;изложит оптимистичный взгляд на будущее нашей страны&quot; и &quot;будет говорить об амбициозной программе, по которой он намерен работать с конгрессом&quot;.</p>

<h2>С какими проблемами уже столкнулся Трамп?</h2>

<p>Это, прежде всего, блокирование указа о временном запрете въезда в США гражданам семи стран Ближнего Востока и Северной Африки, действие которого было приостановлено судом, а также противоречия в связи с финансированием строительства стены на границе с Мексикой и в целом миграционная политика. Данный вопрос вызывает наиболее бурную реакцию в американском обществе.</p>

<ul>
	<li><a href="http://www.bbc.com/russian/news-38939889">Трамп хочет подписать новый иммиграционный указ</a></li>
	<li><a href="http://www.bbc.com/russian/news-38749402">Трамп подписал указ о строительстве стены на границе с Мексикой</a></li>
	<li><a href="http://www.bbc.com/russian/news-38633418">Трамп пообещал заменить Obamacare на &quot;страхование для всех&quot;</a></li>
</ul>

<p>Заявив о намерении демонтировать созданную предшественником систему обязательного медицинского страхования, известную как Obamacare, Трамп пока не описал, что придет ей на смену.</p>

<p>Нет полной ясности с налоговой реформой, планов снижения регулирования деятельности компаний с целью создания дополнительных рабочих мест в США. Обо всем этом Трамп пока высказывался в общих выражениях</p>

<h2>Что будет с внешней политикой США?</h2>

<p>Здесь тоже многое из сказанного Трампом нуждается в конкретизации.</p>

<ul>
	<li><a href="http://www.bbc.com/russian/news-38888500">Дональд Трамп заявил о решительной поддержке НАТО</a></li>
	<li><a href="http://www.bbc.com/russian/news-39107764">Трамп предложил увеличить расходы на оборону на 54 млрд долларов</a></li>
	<li><a href="http://www.bbc.com/russian/features-39075790">США-Китай: как Пекину удалось выиграть первый раунд</a></li>
</ul>

<p>Обеспокоенные союзники по НАТО ждут дополнительных заверений в том, что Вашингтон настроен на сотрудничество, несмотря на критику Трампа, связанную с финансированием деятельности альянса.</p>

<p>Неизвестно, что конкретно собирается делать Трамп с Сирией. Во время избирательной кампании он обещал поручить военным в течение 30 дней с момента его вступления в должность представить предложения, как покончить с &quot;Исламским государством&quot; (запрещено в России и ряде других стран), и эти 30 дней истекли.</p>

<p>Противоречивые сигналы поступали от него и относительно дальнейшего развития отношений с Китаем.</p>

<h2>Будет ли Трамп говорить о России и Украине?</h2>

<p>Прогнозировать сложно, интрига сохраняется.</p>

<ul>
	<li><a href="http://www.bbc.com/russian/features-38996687">Как Трамп и Россия разлюбили друг друга</a></li>
	<li><a href="http://www.bbc.com/russian/news-39015189">Майк Пенс: Россия должна отвечать за свои действия</a></li>
	<li><a href="http://www.bbc.com/russian/news-39113096">МИД России: конгресс США готовит нам экономическую блокаду</a></li>
</ul>

<p>Судя по событиям и заявлениям последних недель, скорой отмены санкций против России и вообще коренных перемен в отношениях между Москвой и Вашингтоном ждать не следует.</p>

<h2>Каковы отношения Трампа с конгрессменами?</h2>

<p>Они непростые. Из 22 должностей в администрации Трампа, требующих утверждения сенатом, остаются вакантными восемь.</p>

<p>Госсекретаря Рекса Тиллерсона поддержали лишь 56 из 100 сенаторов. При утверждении министра образования Бетси Девос впервые в истории пришлось голосовать председательствующему в сенате вице-президенту Майклу Пенсу, поскольку голоса разделились поровну.</p>
',
        $moderator_id,
        'dist/img/article4.jpg',
        1,
        1488314108,
        1488314112);
    $this->createArticle('Autonomous Boats By 2020',
        'My twitter feed was abuzz this week with news of a Russian spy boat miles off the coast of Connecticut’s US Naval Submarine Base in Groton. This would’ve been a good time to test the Navy’s newest weapon — the Sea Hunter — an autonomous marine defense system (shown below). The concept of an encounter between autonomous and manual vessels waging battle is a good metaphor for future conflicts across industries from defense to energy to shipping.',
        ' <img src="/dist/img/article5-1.jpg" /><p>Marine boat traffic has grown threefold in the past 100 years. As the seas become more crowded the demand for autonomous solutions could not be more relevant from a greater profits to increased safety. Allianz Insurance reported that over 75% of all boating accidents are the fault of human error, often the result of fatigue. Rolls-Royce, a leading manufacturer of automobiles, aerospace engines and maritime solutions estimates that autonomous and remote-controlled vessels on open waters could one day rival their terrestrial counterparts on the speed of adoption and utility.</p>
            <img src="/dist/img/article5-2.jpg" />
                            <p>“Autonomous shipping is the future of the maritime industry” ssaid Mikael Makinen, president of Rolls-Royce’s marine division, in a white paper published by the company. “As disruptive as the smartphone, the smart ship will revolutionize the landscape of ship design and operations.”
                    While in the past we have discussed many upstarts in the autonomous marine space, Rolls-Royce is now leading the industry with its global research project, the Advanced Autonomous Waterborne Applications (AAWA), to deliver fully autonomous shipping vessels by the end of the decade. The AAWA endeavor draws together the European Union’s MUNIN (Maritime Unmanned Navigation through Intelligence in Networks); DNV GL, and China’s Maritime Safety Administration & Wuhan University of Technology. Each national group is bringing its own expertise to the table to assess the varied requirements to bring fully autonomous shipping to a commercial reality, including: software (navigation, collision avoidance, off-board communications), certifications (legal, liability & insurance) and societal changes (labor & business). A big driver of the research is external pressure from the shipping industry, including threats from pirates, increased cargo demands, and a shrinking skilled workforce.</p>
                    <iframe width="700" height="393" src="https://www.youtube.com/embed/ZuX5qFdiiI0" frameborder="0" allowfullscreen></iframe>',
        $moderator_id,
        'dist/img/article5.jpg',
        1,
        1488314280,
        1488314284);
    $this->createArticle('Technology that can get us to Mars does not exist, yet',
        'Everyone talking how we will go to Mars soon. Guess again, we won’t, there is one big problem, Mars is pretty far away. We can’t go there, technology does not exist.',
        ' <h3 name="a135">Mars is pretty far away</h3>

<blockquote name="f393">&ldquo;It&rsquo;s six orders of magnitude further than the space station. We would need to develop new ways to live away from the Earth and that&rsquo;s never been done before. Ever.&rdquo; Sam Scimemi,Nasa&rsquo;s director of the International Space Station</blockquote>

<p name="ed0e">Let&rsquo;s put this in perspective, as we recorded Earth and Mars where the closest 34.8 million miles from each other. The farthest is 250 million miles apart. It&rsquo;s important to notice that both Earth and Mars rotate over Sun, while for Earth it takes only 365 days to close the circle for Mars it&rsquo;s longer. Mars goes around the Sun every 687 days.</p>

<p name="ce03">How long should take us to go from Earth to Mars? <strong>Something between 150 and 300 days.</strong> If we check the history of traveling on that route, we will see the average time:</p>

<ul>
	<li name="43ad">Mariner 4 (1965) &mdash; 228 days</li>
	<li name="8201">Mariner 6 (1969) &mdash; 156 days</li>
	<li name="bec4">Mariner 7 (1969) &mdash; 131 days</li>
	<li name="e9bf">Mariner 9 (1971) &mdash; 167 days</li>
	<li name="817c">Viking 1 (1976) &mdash; 335 days</li>
	<li name="fe7e">Viking 2 (1976) &mdash; 360 days</li>
	<li name="a05e">Mars Reconnaissance Orbiter (2006) &mdash; 210 days</li>
	<li name="b230">Phoenix Lander (2008) &mdash; 295 days</li>
	<li name="ea34">Curiosity Lander (2012) &mdash; 253 days</li>
</ul> <img src="/dist/img/article6-1.jpg" />
<p>
	<br>
</p>

<p>We can&rsquo;t bring with us all that we need It&rsquo;s not the same if in a rocket is robot or human. In order to stay alive in the space people need to eat something, they need to have a water, and oxygen. Also, there is a fuel, the rocket needs a lot of it just to get to the Mars. It&rsquo;s double more for round trip. That is the main reason why is the trend one way ticket to Mars. There are no round trips. Getting off from the Earth A Mars mission would be on a much larger scale than almost anything we&rsquo;ve done before, it&rsquo;s not the same as regular mission. Still, there is no rocket that can take off from the Earth&rsquo;s surface and escape its gravitational pull to reach space carrying the weight of a large spacecraft, astronauts and all the supplies and materials needed to get to Mars.&nbsp;</p>

<p>Rockets would have to make several trips to drop off supplies and pieces for a vehicle into low-Earth orbit. Then everything should be built in the space before a rocket could be ready to start a journey to the Mars. But, there is a problem with a fuel, objects in low-Earth orbit travel all around every 90 minutes. During half that time, they experience the heat of the sun. If objects are not well managed there is a big possibility that everything will blow up before the start. Radiation make us problem too In May 2013, NASA scientists reported that a possible mission to Mars may involve a great radiation risk based on the amount of energetic particle radiation detected by the RAD on the Mars Science Laboratory while traveling from the Earth to Mars in 2011&ndash;2012.&nbsp;</p>

<p>
	<br>
</p>

<p>The calculated radiation dose was 0.66 sieverts round-trip. The agency&rsquo;s career radiation limit for astronauts is 1 sievert But, we are trying to It&rsquo;s everywhere on the news, NASA, SpaceX and some other companies are trying to do it. They are trying to build a technology that will be able to bring people to the Mars. They are not trying to send us, yet. They just want to make an opportunity for it and prepare everything. The future of technology is unpredictable I guess we will find a way and send the human to Mars before 2030. You know what is the awesome thing about it? From 1930&ndash;2030 will just pass 100 years. In that 100 years human development increase from the point where we launched our first successful mission to space to the point where we are able to walk on the Mars surface.</p>' ,
        $moderator_id,
        'dist/img/article6.jpg',
        1,
        1488314368,
        1488314371);
  }

  private function registerUser($username, $password_hash, $email, $auth_key, $confirmed_at, $updated_at, $created_at, $role)
  {
    $user = new UserRaw();
    $user->username = $username;
    $user->password_hash = $password_hash;
    $user->email = $email;
    $user->auth_key = $auth_key;
    $user->confirmed_at = $confirmed_at;
    $user->created_at = $created_at;
    $user->updated_at = $updated_at;
    $user->save();

    /** Assigning role to this user */
    $auth = Yii::$app->authManager;
    $userRole = $auth->getRole($role);
    $auth->assign($userRole, $user->id);

    /** Assigning role to this user */
    $connection = Yii::$app->getDb();
    $connection->createCommand()->insert('notifications', [
        'user_id' => $user->id,
        'browser' => '1',
        'email' => '1'
    ])->execute();
  }

  private function createArticle($title, $short_description, $content, $user_id, $preview_img, $isActive, $created_at, $updated_at)
  {

    $connection = Yii::$app->getDb();
    $connection->createCommand()->insert('news', [
        'title' => $title,
        'short_description' => $short_description,
        'content' => $content,
        'user_id' => $user_id['id'],
        'preview_img' => $preview_img,
        'active' => $isActive,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ])->execute();

  }
}