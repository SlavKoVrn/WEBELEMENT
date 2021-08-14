<?php

use \yii\db\Migration;

class m190124_110200_add_verification_token_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));

        $this->insert('{{%user}}',[
            'id' => 1,
            'username' => 'admin',
            'auth_key' => md5('admin'),
            'password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
            'password_reset_token' => '',
            'email' => 'slavko.chita@gmail.com',
            'verification_token' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
