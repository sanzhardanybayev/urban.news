<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Handles the creation of table `notifications_manage`.
 */
class m170204_144518_create_notifications_manage_table extends Migration
{
  /**
   * @inheritdoc
   */
  public function up()
  {
    $this->createTable('notifications_manage', [
        'id' => $this->primaryKey(),
        'event_id' => $this->integer()->notNull(),
        'model_id' => $this->integer()->notNull(),
        'email' => Schema::TYPE_BOOLEAN,
        'browser' => Schema::TYPE_BOOLEAN,
        'role' => Schema::TYPE_STRING
    ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');


    $this->createIndex(
        'idx-notifications_manage-role',
        'notifications_manage',
        'role'
    );

    $this->addForeignKey(
        'fk-notifications_manage-role',
        'notifications_manage',
        'role',
        'auth_item',
        'name',
        'CASCADE'
    );

    $this->createIndex(
        'idx-notifications_manage-model_id',
        'notifications_manage',
        'model_id'
    );

    $this->addForeignKey(
        'fk-notifications_manage-model_id',
        'notifications_manage',
        'model_id',
        'models',
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
        'fk-notifications_manage-role',
        'notifications_manage'
    );

    $this->dropIndex(
        'idx-notifications_manage-role',
        'notifications_manage'
    );


    $this->dropForeignKey(
        'fk-notifications_manage-model_id',
        'notifications_manage'
    );

    $this->dropIndex(
        'idx-notifications_manage-model_id',
        'notifications_manage'
    );

    $this->dropTable('notifications_manage');
  }
}
