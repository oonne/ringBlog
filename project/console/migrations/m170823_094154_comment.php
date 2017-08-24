<?php

use yii\db\Migration;

class m170823_094154_comment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'comment' => $this->string(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex(
            'idx-comment-post_id',
            'comment',
            'post_id'
        );
        $this->createIndex(
            'idx-comment-created_at_id',
            'comment',
            'created_at'
        );
    }

    public function down()
    {
        echo "m160825_032145_comment cannot be reverted.\n";

        return false;
    }
}
