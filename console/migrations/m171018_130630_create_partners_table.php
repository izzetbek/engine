<?php

use yii\db\Migration;

/**
 * Handles the creation of table `partners`.
 */
class m171018_130630_create_partners_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%partners}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'thumb' => $this->string(),
            'link' => $this->string(),
            'order' => $this->integer()->notNull(),
            'draft' => $this->boolean()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%partners}}');
    }
}
