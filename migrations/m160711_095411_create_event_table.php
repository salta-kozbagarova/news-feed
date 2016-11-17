<?php

use yii\db\Migration;

class m160711_095411_create_event_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->unique()->notNull()
        ]);

        $this->insert('event', [
            'name' => 'new_post'
        ]);

        $this->insert('event', [
            'name' => 'block_user'
        ]);

        $this->insert('event', [
            'name' => 'new_user'
        ]);
    }

    public function safeDown()
    {
        $this->delete('event', ['in', 'id', [1, 2, 3]]);
        $this->dropTable('event');
    }
}
