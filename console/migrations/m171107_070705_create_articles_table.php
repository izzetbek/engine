<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m171107_070705_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'post_date' => $this->integer()->notNull(),
            'thumb' => $this->string(50),
            'draft' => $this->boolean(),
        ], $tableOptions);

        $this->createTable('{{%articlesLang}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'language' => $this->string('2')->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL'
        ], $tableOptions);

        $this->addForeignKey('fk_article_lang','{{%articlesLang}}', 'article_id', '{{%articles}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_article_lang', '{{%articlesLang}}');
        $this->dropTable('{{%articlesLang}}');
        $this->dropTable('{{%articles}}');
    }
}
