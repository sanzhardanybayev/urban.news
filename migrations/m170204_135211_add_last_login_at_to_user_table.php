<?php

use yii\db\Migration;

class m170204_135211_add_last_login_at_to_user_table extends Migration
{
  public function up()
  {
    $this->addColumn('{{%user}}', 'last_login_at', $this->integer());

  }

  public function down()
  {
    $this->dropColumn('{{%user}}', 'last_login_at');
  }
}
