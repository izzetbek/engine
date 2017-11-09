<?php

use yii\db\Migration;

/**
 * Handles the creation of table `trainings`.
 */
class m171109_122633_create_trainings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%trainings}}', [
            'id' => $this->primaryKey(),
            'thumb' => $this->string(50),
            'begin_date' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'draft' => $this->boolean()->notNull()
        ], $tableOptions);

        $this->createTable('{{%trainingsLang}}', [
            'id' => $this->primaryKey(),
            'training_id' => $this->integer()->notNull(),
            'language' => $this->string('2')->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->addForeignKey(
            'fk_training_lang',
            '{{%trainingsLang}}',
            'training_id',
            '{{%trainings}}',
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
        $this->dropForeignKey('fk_training_lang', '{{%trainingsLang}}');
        $this->dropTable('{{%trainingsLang}}');
        $this->dropTable('{{%trainings}}');
    }
}
