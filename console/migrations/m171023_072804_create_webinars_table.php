<?php

use yii\db\Migration;

/**
 * Handles the creation of table `webinars`.
 */
class m171023_072804_create_webinars_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%webinars}}', [
            'id' => $this->primaryKey(),
            'price' => $this->decimal(10, 2)->notNull(),
            'beginDate' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%webinarsLang}}', [
            'id' => $this->primaryKey(),
            'webinar_id' => $this->integer()->notNull(),
            'language' => $this->string('2')->notNull(),
            'title' => $this->string()->notNull(),
            'site_description' => $this->text(),
            'cabinet_description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_webinar_lang','{{%webinarsLang}}', 'webinar_id', '{{%webinars}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_webinar_lang', '{{%webinarsLang}}');
        $this->dropTable('{{%webinars}}');
        $this->dropTable('{{%webinarsLang}}');
    }
}