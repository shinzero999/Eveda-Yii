<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_030932_create_upgrade_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('upgrade', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'phone_number' => Schema::TYPE_STRING,
            'address' => Schema::TYPE_STRING,
            'about' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->addForeignKey('FK_user_id_to_user', 'upgrade', 'user_id', 'user', 'id');
    }

    public function down()
    {
        echo "m150801_030932_create_order_table cannot be reverted.\n";

        return false;
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
