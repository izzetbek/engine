<?php

use yii\db\Migration;

/**
 * Handles the creation of table `documents`.
 */
class m171109_083050_create_documents_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%documents}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(),
            'order' => $this->integer()->notNull(),
            'draft' => $this->boolean()
        ], $tableOptions);

        $this->createTable('{{%documentsLang}}', [
            'id' => $this->primaryKey(),
            'document_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_document_lang',
            '{{%documentsLang}}',
            'document_id',
            '{{%documents}}',
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
        $this->dropForeignKey('fk_document_lang', '{{%documentsLang}}');
        $this->dropTable('{{%documentsLang}}');
        $this->dropTable('{{%documents}}');
    }
}
