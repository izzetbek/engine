<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ht_templates`.
 */
class m171108_130140_create_ht_templates_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%hr_templates}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(),
            'order' => $this->integer()->notNull(),
            'draft' => $this->boolean()
        ], $tableOptions);

        $this->createTable('{{%hr_templatesLang}}', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_template_lang',
            '{{%hr_templatesLang}}',
            'template_id',
            '{{%hr_templates}}',
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
        $this->dropForeignKey('fk_template_lang', '{{%hr_templatesLang}}');
        $this->dropTable('{{%hr_templatesLang}}');
        $this->dropTable('{{%hr_templates}}');
    }
}
