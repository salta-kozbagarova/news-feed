<?php

use yii\db\Migration;

class m160724_082520_create_junction_table_for_notification_and_notification_type_tables extends Migration
{
    public function up()
    {
        $this->createTable('notification_and_notification_type', [
            'notification_id' => $this->integer()->notNull(),
            'notification_type_id' => $this->integer()->notNull(),
            'PRIMARY KEY(notification_id, notification_type_id)'
        ]);

        $this->createIndex(
            'idx-notification_and_notification_type-notification_id',
            'notification_and_notification_type',
            'notification_id'
        );
        $this->createIndex(
            'idx-notification_and_notification_type-notification_type_id',
            'notification_and_notification_type',
            'notification_type_id'
        );

        $this->addForeignKey(
            'fk-notification_and_notification_type-notification_id',
            'notification_and_notification_type',
            'notification_id',
            'notification',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-notification_and_notification_type-notification_type_id',
            'notification_and_notification_type',
            'notification_type_id',
            'notification_type',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-notification_and_notification_type-notification_id',
            'notification_and_notification_type'
        );

        $this->dropIndex(
            'idx-notification_and_notification_type-notification_id',
            'notification_and_notification_type'
        );

        $this->dropForeignKey(
            'fk-notification_and_notification_type-notification_type_id',
            'notification_and_notification_type'
        );
        
        $this->dropIndex(
            'idx-notification_and_notification_type-notification_type_id',
            'notification_and_notification_type'
        );

        $this->dropTable('notfication_and_notifiction_type');
    }
}
