<?php

use yii\db\Migration;

class m170817_145208_add_user_role extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'role', $this->string(64));

        $this->update('{{%users}}', ['role' => 'user']);
    }

    public function down()
    {
        $this->dropColumn('{{%users}}', 'role');
    }
}
