<?php

use yii\db\Migration;

class m171108_070108_add_online_tests_price_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%online_tests}}', 'price', $this->decimal(10, 2)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%online_tests}}', 'price');
    }
}