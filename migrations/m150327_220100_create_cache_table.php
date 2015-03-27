<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_220100_create_cache_table extends Migration
{
    public function up()
    {
        $this->createTable('cache', [
            'id char(128) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER . '(11)',
            'data LONGBLOB'
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('cache');
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
