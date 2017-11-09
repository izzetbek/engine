<?php

use yii\db\Migration;

/**
 * Handles the creation of table `success_stories`.
 */
class m171107_143303_create_success_stories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%success_stories}}', [
            'id' => $this->primaryKey(),
            'thumb' => $this->string(50),
            'company' => $this->string(255),
            'order' => $this->integer()->notNull(),
            'draft' => $this->boolean()
        ]);

        $this->createTable('{{%success_storiesLang}}', [
            'id' => $this->primaryKey(),
            'story_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'name' => $this->string(255)->notNull(),
            'position' => $this->string(255)->notNull(),
            'story' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk_story_lang',
            '{{%success_storiesLang}}',
            'story_id',
            '{{%success_stories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_story_lang', '{{%success_storiesLang}}');
        $this->dropTable('{{%success_storiesLang}}');
        $this->dropTable('{{%success_stories}}');
    }
}
