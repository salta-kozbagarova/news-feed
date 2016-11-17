<?php

use yii\db\Migration;

class m160724_081831_create_notification_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_to_user', [
            'notification_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'PRIMARY KEY(notification_id, user_id)'
        ]);

        $this->createIndex(
            'idx-notification_to_user-notification_id',
            'notification_to_user',
            'notification_id'
        );
        $this->createIndex(
            'idx-notification_to_user-user_id',
            'notification_to_user',
            'user_id'
        );

        $this->addForeignKey(
            'fk-notification_to_user-notification_id',
            'notification_to_user',
            'notification_id',
            'notification',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-notification_to_user-user_id',
            'notification_to_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `notification`
        $this->dropForeignKey(
            'fk-notification_to_user-notification_id',
            'notification_to_user'
        );

        // drops index for column `notification_id`
        $this->dropIndex(
            'idx-notification_to_user-notification_id',
            'notification_to_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-notification_to_user-user_id',
            'notification_to_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-notification_to_user-user_id',
            'notification_to_user'
        );

        $this->dropTable('notification_to_user');
    }
}
