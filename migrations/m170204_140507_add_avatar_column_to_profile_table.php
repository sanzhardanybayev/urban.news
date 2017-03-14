<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Handles adding avatar to table `profile`.
 */
class m170204_140507_add_avatar_column_to_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('profile', 'avatar', Schema::TYPE_STRING . '(200)');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('profile', 'avatar');
    }
}
