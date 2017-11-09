<?php

use yii\db\Migration;

class m171018_071856_add_category_draft extends Migration
{
    public function up()
    {
        $this->addColumn('{{%site_categories}}', 'draft', $this->boolean()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%site_categories}}', 'draft');
    }
}
