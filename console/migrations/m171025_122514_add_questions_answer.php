<?php

use yii\db\Migration;

class m171025_122514_add_questions_answer extends Migration
{
    public function up()
    {
        $this->addColumn('{{%questions}}', 'answer', $this->text());
    }

    public function down()
    {
        $this->dropColumn('{{%questions}}', 'answer');
    }
}
