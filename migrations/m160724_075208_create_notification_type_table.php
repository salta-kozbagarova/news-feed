<?php

use yii\db\Migration;

class m160724_075208_create_notification_type_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_type', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->unique()->notNull()
        ]);

        $this->insert('notification_type', [
            'type' => 'email'
        ]);

        $this->insert('notification_type', [
            'type' => 'browser'
        ]);
    }

    public function safeDown()
    {
        $this->delete('notification_type', ['in', 'id', [1, 2]]);
        $this->dropTable('notification_type');
    }
}
