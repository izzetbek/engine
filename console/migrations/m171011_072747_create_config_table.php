<?php

use yii\db\Migration;

/**
 * Handles the creation of table `config`.
 */
class m171011_072747_create_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";

        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'param' => $this->string(128)->notNull()->unique(),
            'value' => $this->text()->notNull(),
            'default' => $this->text()->notNull(),
            'label' => $this->string(255)->notNull(),
            'type' => $this->string(128)->notNull()
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
