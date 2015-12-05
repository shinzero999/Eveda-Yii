<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\User;

class m150405_161249_user_add_admin_user extends Migration
{
    public function up()
    {
        $this->insert('{{%user}}', [
            'email' => 'admin@admin.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'password_reset_token' => '',
            'role' => User::ROLE_SUPER_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        echo "m150405_161249_user_add_admin_user cannot be reverted.\n";

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
