<?php

use yii\db\Schema;
use yii\db\Migration;

class m150320_134551_create_note_table extends Migration
{
    public function up()
    {
        $this->createTable('note', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . " NOT NULL DEFAULT ''",
            'public' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE'
        ], 'Engine=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('note');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
