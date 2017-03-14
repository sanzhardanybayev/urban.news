<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `events`.
 */
class m170204_143952_create_events_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('events', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING,
            'model_id' => $this->integer()->notNull()
        ]);

      // creates index for column `user_id`
      $this->createIndex(
          'idx-events-model_id',
          'events',
          'model_id'
      );

      // add foreign key for table 'user'
      $this->addForeignKey(
          'fk-events-model_id',
          'events',
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
        $this->dropTable('events');
    }
}
