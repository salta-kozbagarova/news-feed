<?php

use yii\db\Migration;

class m160706_052112_create_junction_table_for_user_and_post_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_post', [
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'PRIMARY KEY(user_id, post_id)'
        ]);

        $this->createIndex(
            'idx-user_post-user_id',
            'user_post',
            'user_id'
        );
        $this->createIndex(
            'idx-user_post-post_id',
            'user_post',
            'post_id'
        );

        $this->addForeignKey(
            'fk-user_post-user_id',
            'user_post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-user_post-post_id',
            'user_post',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_post-user_id',
            'user_post'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_post-user_id',
            'user_post'
        );

        // drops foreign key for table `post`
        $this->dropForeignKey(
            'fk-user_post-post_id',
            'user_post'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-user_post-post_id',
            'user_post'
        );

        $this->dropTable('user_post');
    }
}
