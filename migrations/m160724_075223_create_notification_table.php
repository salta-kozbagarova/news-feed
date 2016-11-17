<?php

use yii\db\Migration;

class m160724_075223_create_notification_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'title' => $this->string(64)->notNull(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull()
        ]);

        // creates index for column `event_id`
        $this->createIndex(
            'idx-notification-event_id',
            'notification',
            'event_id'
        );

        // creates index for column `sender_id`
        $this->createIndex(
            'idx-notification-sender_id',
            'notification',
            'sender_id'
        );

        // add foreign key for table `event`
        $this->addForeignKey(
            'fk-notification-event_id',
            'notification',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-notification-sender_id',
            'notification',
            'sender_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {

        // drops foreign key for table `event`
        $this->dropForeignKey(
            'fk-notification-event_id',
            'notification'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            'idx-notification-event_id',
            'notification'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-notification-sender_id',
            'notification'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            'idx-notification-sender_id',
            'notification'
        );

        $this->dropTable('notification');
    }
}
