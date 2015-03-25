<?php

use yii\db\Schema;
use yii\db\Migration;

class m150325_205232_create_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('comment', [
            'id' => Schema::TYPE_PK,
            'note_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'message' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'FOREIGN KEY (note_id) REFERENCES note(id) ON DELETE CASCADE',
            'FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE'
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('comment');
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
