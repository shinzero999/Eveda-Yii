<?php

use yii\db\Schema;
use yii\db\Migration;

class m151113_040631_create_follow_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('follow', [
            'id' => Schema::TYPE_PK,
            'event_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->addForeignKey('FK_event_id_to_event_table', 'follow', 'event_id', 'event', 'id');
        $this->addForeignKey('FK_user_id_to_user_tbl', 'follow', 'user_id', 'user', 'id');
    }

    public function down()
    {
        echo "m151113_040631_create_follow_table cannot be reverted.\n";

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
