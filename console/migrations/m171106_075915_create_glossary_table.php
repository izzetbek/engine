<?php

use yii\db\Migration;

/**
 * Handles the creation of table `glossary`.
 */
class m171106_075915_create_glossary_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%glossary}}', [
            'id' => $this->primaryKey(),
            'draft' => $this->smallInteger()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%glossaryLang}}', [
            'id' => $this->primaryKey(),
            'glossary_id' => $this->integer()->notNull(),
            'language' => $this->string('2')->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->addForeignKey('fk_glossary_lang','{{%glossaryLang}}', 'glossary_id', '{{%glossary}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_glossary_lang', '{{%glossaryLang}}');
        $this->dropTable('{{%glossaryLang}}');
        $this->dropTable('{{%glossary}}');
    }
}
