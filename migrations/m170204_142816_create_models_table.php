<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `models`.
 */
class m170204_142816_create_models_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('models', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('models');
    }
}
