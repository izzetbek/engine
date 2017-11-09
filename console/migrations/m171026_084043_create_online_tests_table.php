<?php

use yii\db\Migration;

/**
 * Handles the creation of table `online_tests`.
 */
class m171026_084043_create_online_tests_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%online_tests}}', [
            'id' => $this->primaryKey(),
            'thumb' => $this->string(),
            'status' => $this->smallInteger()->notNull(),
            'passed_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%online_testsLang}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%online_tests_questions}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'order' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%online_tests_questionsLang}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->text()->notNull()
        ], $tableOptions);

        $this->createTable('{{%questions_variants}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'correct' => $this->boolean(),
        ], $tableOptions);

        $this->createTable('{{%questions_variantsLang}}', [
            'id' => $this->primaryKey(),
            'variant_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'content' => $this->string()
        ], $tableOptions);

        $this->addForeignKey(
            'fk_online_tests_lang',
            '{{%online_testsLang}}',
            'test_id',
            '{{%online_tests}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_online_tests_questions',
            '{{%online_tests_questions}}',
            'test_id',
            '{{%online_tests}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_online_tests_questions_lang',
            '{{%online_tests_questionsLang}}',
            'question_id',
            '{{%online_tests_questions}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_online_tests_questions_variants',
            '{{%questions_variants}}',
            'question_id',
            '{{%online_tests_questions}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_online_tests_questions_variants_lang',
            '{{%questions_variantsLang}}',
            'variant_id',
            '{{%questions_variants}}',
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
        $this->dropForeignKey('fk_online_tests_lang', '{{%online_testsLang}}');
        $this->dropForeignKey('fk_online_tests_questions', '{{%online_tests_questions}}');
        $this->dropForeignKey('fk_online_tests_questions_lang', '{{%online_tests_questionsLang}}');
        $this->dropForeignKey('fk_online_tests_questions_variants', '{{%questions_variants}}');
        $this->dropForeignKey('fk_online_tests_questions_variants_lang', '{{%questions_variantsLang}}');
        $this->dropTable('{{%questions_variantsLang}}');
        $this->dropTable('{{%questions_variants}}');
        $this->dropTable('{{%online_tests_questionsLang}}');
        $this->dropTable('{{%online_tests_questions}}');
        $this->dropTable('{{%online_testsLang}}');
        $this->dropTable('{{%online_tests}}');
    }
}