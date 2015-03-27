<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_220104_create_session_table extends Migration
{
    public function up()
    {
        $this->createTable('session', [
            'id CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data LONGBLOB'
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('session');
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
