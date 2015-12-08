<?php

use yii\db\Schema;
use yii\db\Migration;

class m151113_040306_create_event_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('event', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'location' => Schema::TYPE_STRING,
            'start_date' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
            'end_date' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
            'url' => Schema::TYPE_STRING,
            'notes' => Schema::TYPE_STRING,
            'image' => Schema::TYPE_TEXT,
            'visibility' => Schema::TYPE_BOOLEAN,
            'region_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'genre_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL' . ' DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->addForeignKey('FK_user_id_to_user_table', 'event', 'user_id', 'user', 'id');
        $this->addForeignKey('FK_region_id_to_region', 'event', 'region_id', 'region', 'id');
        $this->addForeignKey('FK_genre_id_to_genre', 'event', 'genre_id', 'genre', 'id');
    }

    public function down()
    {
        echo "m151113_040306_create_event_table cannot be reverted.\n";

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
