<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_trainings`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `trainings`
 */
class m171110_100946_create_junction_table_for_users_and_trainings_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%users_trainings}}', [
            'users_id' => $this->integer(),
            'trainings_id' => $this->integer(),
            'PRIMARY KEY(users_id, trainings_id)',
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            'idx-users_trainings-users_id',
            '{{%users_trainings}}',
            'users_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-users_trainings-users_id',
            '{{%users_trainings}}',
            'users_id',
            'users',
            'id',
            'CASCADE'
        );

        // creates index for column `trainings_id`
        $this->createIndex(
            'idx-users_trainings-trainings_id',
            '{{%users_trainings}}',
            'trainings_id'
        );

        // add foreign key for table `trainings`
        $this->addForeignKey(
            'fk-users_trainings-trainings_id',
            '{{%users_trainings}}',
            'trainings_id',
            'trainings',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-users_trainings-users_id',
            '{{%users_trainings}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            'idx-users_trainings-users_id',
            '{{%users_trainings}}'
        );

        // drops foreign key for table `trainings`
        $this->dropForeignKey(
            'fk-users_trainings-trainings_id',
            '{{%users_trainings}}'
        );

        // drops index for column `trainings_id`
        $this->dropIndex(
            'idx-users_trainings-trainings_id',
            '{{%users_trainings}}'
        );

        $this->dropTable('{{%users_trainings}}');
    }
}
