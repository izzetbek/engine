<?php

use yii\db\Migration;

class m170822_111640_create_gallery_albums extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%galleryLang}}', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer()->notNull(),
            'language' => $this->string(6)->notNull(),
            'name' => $this->string(255),
            'description' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey('fk_gallery_lang','{{%galleryLang}}', 'album_id', '{{%gallery}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_gallery_albums_lang', '{{%galleryLang}}');
        $this->dropTable('{{%gallery}}');
        $this->dropTable('{{%galleryLang}}');
    }
}
