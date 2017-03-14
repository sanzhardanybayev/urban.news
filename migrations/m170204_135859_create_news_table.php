<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `news`.
 */
class m170204_135859_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => Schema::TYPE_TEXT,
            'short_description' => Schema::TYPE_TEXT,
            'content' => Schema::TYPE_TEXT,
            'user_id' => $this->integer()->notNull(),
            'type' => Schema::TYPE_STRING,
            'preview_img' => Schema::TYPE_STRING,
            'active' => Schema::TYPE_BOOLEAN,
            'created_at' => Schema::TYPE_INTEGER. '(11)',
            'updated_at' => Schema::TYPE_INTEGER. '(11)',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-news-user_id',
            'news',
            'user_id'
        );

        // add foreign key for table 'user'
        $this->addForeignKey(
            'fk-news-user_id',
            'news',
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
            'fk-news-user_id',
            'news'
        );
        // drops index for column `user_id`
        $this->dropIndex(
            'idx-news-user_id',
            'news'
        );
        $this->dropTable('news');
    }
}
