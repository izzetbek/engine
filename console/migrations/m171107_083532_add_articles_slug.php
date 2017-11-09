<?php

use yii\db\Migration;

class m171107_083532_add_articles_slug extends Migration
{
    public function up()
    {
        $this->addColumn('{{%articles}}', 'slug', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%articles}}', 'slug');
    }
}