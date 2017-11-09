<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m171020_085155_create_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%team}}', [
            'id' => $this->primaryKey(),
            'thumb' => $this->string(),
            'order' => $this->integer()->notNull(),
            'draft' => $this->boolean()
        ], $tableOptions);

        $this->createTable('{{%teamLang}}', [
            'id' => $this->primaryKey(),
            'teammate_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'name' => $this->string()->notNull(),
            'position' => $this->string(),
            'description' => $this->text()
        ]);

        $this->addForeignKey('fk_team_lang','{{%teamLang}}', 'teammate_id', '{{%team}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_team_lang', '{{%teamLang}}');
        $this->dropTable('{{%team}}');
        $this->dropTable('{{%teamLang}}');
    }
}