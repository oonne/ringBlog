<?php

use yii\db\Migration;

class m170823_094347_reply extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%reply}}', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer()->notNull(),
            'reply' => $this->string(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex(
            'idx-reply-comment_id',
            'reply',
            'comment_id'
        );
        $this->createIndex(
            'idx-reply-created_at_id',
            'reply',
            'created_at'
        );
    }

    public function down()
    {
        echo "m160825_032215_reply cannot be reverted.\n";

        return false;
    }
}
