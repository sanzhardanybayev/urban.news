<?php

use yii\db\Migration;
/**
 * Handles the creation of table `website_settings`.
 */
class m170227_120008_create_website_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('website_settings', [
            'id' => $this->primaryKey(),
            'amountOfNewsOnMainPage' => $this->integer()->defaultValue(8),
            'amountOfNewsOnNewsPage' => $this->integer()->defaultValue(8)
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('website_settings');
    }
}
