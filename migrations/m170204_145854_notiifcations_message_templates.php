<?php

use yii\db\Migration;
use yii\db\Schema;

class m170204_145854_notiifcations_message_templates extends Migration
{
  /**
   * @inheritdoc
   */
  public function up()
  {
    $this->createTable('notifications_message_templates', [
        'id' => $this->primaryKey(),
        'event_id' => $this->integer()->notNull(),
        'model_id' => $this->integer()->notNull(),
        'emailMessage' => Schema::TYPE_TEXT,
        'browserMessage' => Schema::TYPE_TEXT,
        'role' => Schema::TYPE_STRING,
    ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

    $this->createIndex(
        'idx-notifications_message_templates-role',
        'notifications_message_templates',
        'role'
    );

    $this->addForeignKey(
        'fk-notifications_message_templates-role',
        'notifications_message_templates',
        'role',
        'auth_item',
        'name',
        'CASCADE'
    );

    $this->createIndex(
        'idx-notifications_message_templates-model_id',
        'notifications_message_templates',
        'model_id'
    );

    $this->addForeignKey(
        'fk-notifications_message_templates-model_id',
        'notifications_message_templates',
        'model_id',
        'models',
        'id',
        'CASCADE'
    );

    $this->createIndex(
        'idx-notifications_message_templates-event_id',
        'notifications_message_templates',
        'event_id'
    );

    $this->addForeignKey(
        'fk-notifications_message_templates-event_id',
        'notifications_message_templates',
        'event_id',
        'events',
        'id',
        'CASCADE'
    );
  }

  /**
   * @inheritdoc
   */
  public function down()
  {

    $this->dropForeignKey(
        'fk-notifications_message_templates-role',
        'notifications_message_templates'
    );

    $this->dropIndex(
        'idx-notifications_message_templates-role',
        'notifications_message_templates'
    );

    $this->dropForeignKey(
        'fk-notifications_message_templates-model_id',
        'notifications_message_templates'
    );

    $this->dropIndex(
        'idx-notifications_message_templates-model_id',
        'notifications_message_templates'
    );

    $this->dropForeignKey(
        'fk-notifications_message_templates-event_id',
        'notifications_message_templates'
    );

    $this->dropIndex(
        'idx-notifications_message_templates-event_id',
        'notifications_message_templates'
    );

    $this->dropTable('notifications_message_templates');
  }
}
