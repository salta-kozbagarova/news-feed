<?php

use yii\db\Migration;

class m160706_043347_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'accessToken' => $this->string(64)->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(1),
            'role' => 'enum("administrator","author","user") not null default "user"'
        ]);

        $this->insert('user', [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.kz',
            'password' => \Yii::$app->getSecurity()->generatePasswordHash('admin123'),
            'accessToken' => \Yii::$app->security->generateRandomString(),
            'is_active' => 1,
            'role' => 'administrator'
        ]);

        $this->insert('user', [
            'first_name' => 'author',
            'last_name' => 'author',
            'username' => 'author',
            'email' => 'author@author.kz',
            'password' => \Yii::$app->getSecurity()->generatePasswordHash('author123'),
            'accessToken' => \Yii::$app->security->generateRandomString(),
            'is_active' => 1,
            'role' => 'author'
        ]);

        $this->insert('user', [
            'first_name' => 'demo',
            'last_name' => 'demo',
            'username' => 'demo',
            'email' => 'demo@demo.kz',
            'password' => \Yii::$app->getSecurity()->generatePasswordHash('demo123'),
            'accessToken' => \Yii::$app->security->generateRandomString(),
            'is_active' => 1,
            'role' => 'user'
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', ['in', 'id', [1, 2, 3]]);
        $this->dropTable('user');
    }
}
