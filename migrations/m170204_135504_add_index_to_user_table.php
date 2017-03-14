    <?php

use yii\db\Migration;

class m170204_135504_add_index_to_user_table extends Migration
{
    public function up()
    {
        // creates index for column `id`
        $this->createIndex(
            'id',
            'user',
            'id'
        );
    }

    public function down()
    {
        // drops index for column `author_id`
        $this->dropIndex(
            'id',
            'user'
        );
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
