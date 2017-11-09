<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_lang`.
 */
class m170922_111019_create_category_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%site_categoriesLang}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language' => $this->string('2')->notNull(),
            'title' => $this->string(255),
            'description' => $this->string(),
            'meta_json' => 'JSON NOT NULL',
        ]);

        $this->dropColumn('{{%site_categories}}', 'title');
        $this->dropColumn('{{%site_categories}}', 'description');
        $this->dropColumn('{{%site_categories}}', 'meta_json');

        $this->addForeignKey(
            'fk_category_lang','{{%site_categoriesLang}}', 'category_id', '{{%site_categories}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_category_lang', '{{%site_categoriesLang}}');
        $this->dropTable('{{%site_categoriesLang}}');

        $this->addColumn('{{%site_categories}}', 'title', $this->string(255));
        $this->addColumn('{{%site_categories}}', 'description', $this->string());
        $this->addColumn('{{%site_categories}}', 'meta_json', 'JSON NOT NULL');
    }
}
