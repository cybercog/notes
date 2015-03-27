<?php

use yii\db\Schema;
use yii\db\Migration;

class m150326_221130_create_comment_closure_table extends Migration
{
    public function up()
    {
        $this->createTable('comment_closure', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'child_id' => Schema::TYPE_INTEGER  . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'FOREIGN KEY (parent_id) REFERENCES comment(id) ON DELETE CASCADE',
            'FOREIGN KEY (child_id) REFERENCES comment(id) ON DELETE CASCADE',
            'PRIMARY KEY (parent_id, child_id)'
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
