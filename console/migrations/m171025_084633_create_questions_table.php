<?php

use yii\db\Migration;

/**
 * Handles the creation of table `questions`.
 */
class m171025_084633_create_questions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%questions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'webinar_id' => $this->integer()->notNull(),
            'question' => $this->text(),
            'ask_date' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%questions}}');
    }
}
