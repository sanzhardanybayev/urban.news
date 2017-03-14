<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `notifications`.
 */
class m170204_142510_create_notifications_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
      $this->createTable('notifications', [
          'user_id' => $this->primaryKey(),
          'email' => Schema::TYPE_BOOLEAN,
          'browser' => Schema::TYPE_BOOLEAN
      ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

      // creates index for column `user_id`
      $this->createIndex(
          'idx-notifications-user_id',
          'notifications',
          'user_id'
      );

      // add foreign key for table 'user'
      $this->addForeignKey(
          'fk-notifications-user_id',
          'notifications',
          'user_id',
          'user',
          'id',
          'CASCADE'
      );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-notifications-user_id',
            'notifications'
        );
        // drops index for column `user_id`
        $this->dropIndex(
            'idx-notifications-user_id',
            'notifications'
        );

        $this->dropTable('notifications');
    }
}
