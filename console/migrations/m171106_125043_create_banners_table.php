<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banners`.
 */
class m171106_125043_create_banners_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'thumb' => $this->string(50)->notNull(),
            'link' => $this->string(255),
            'draft' => $this->boolean(),
            'order' => $this->integer()->notNull()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%banners}}');
    }
}
