<?php

use yii\db\Migration;
use yii\db\Schema;

class m170822_112618_create_gallery_album_photos extends Migration
{
    public $tableName = '{{%gallery_album_photos}}';

    public function up()
    {

        $this->createTable(
            $this->tableName,
            array(
                'id' => Schema::TYPE_PK,
                'type' => Schema::TYPE_STRING,
                'ownerId' => Schema::TYPE_STRING . ' NOT NULL',
                'rank' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'name' => Schema::TYPE_STRING,
                'description' => Schema::TYPE_TEXT
            )
        );
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
