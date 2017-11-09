<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_webinars`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `webinars`
 */
class m171023_111126_create_junction_table_for_users_and_webinars_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%users_webinars}}', [
            'user_id' => $this->integer(),
            'webinar_id' => $this->integer(),
            'PRIMARY KEY(user_id, webinar_id)',
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            'idx-users_webinars-users_id',
            '{{%users_webinars}}',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-users_webinars-users_id',
            '{{%users_webinars}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `webinars_id`
        $this->createIndex(
            'idx-users_webinars-webinars_id',
            '{{%users_webinars}}',
            '{{%webinar_id}}'
        );

        // add foreign key for table `webinars`
        $this->addForeignKey(
            'fk-users_webinars-webinars_id',
            '{{%users_webinars}}',
            'webinar_id',
            '{{%webinars}}',
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
            'fk-users_webinars-users_id',
            '{{%users_webinars}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            'idx-users_webinars-users_id',
            '{{%users_webinars}}'
        );

        // drops foreign key for table `webinars`
        $this->dropForeignKey(
            'fk-users_webinars-webinars_id',
            '{{%users_webinars}}'
        );

        // drops index for column `webinars_id`
        $this->dropIndex(
            'idx-users_webinars-webinars_id',
            '{{%users_webinars}}'
        );

        $this->dropTable('{{%users_webinars}}');
    }
}
