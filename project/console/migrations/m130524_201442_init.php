<?php

use yii\db\Migration;
use common\models\User;
use common\models\Category;
use common\models\Blog;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Crear user table
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'nickname' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull()->defaultValue(''),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the user admin
        $admin = new User();
        $admin->username = 'admin';
        $admin->nickname = '管理员';
        $admin->setPassword($admin->username);
        $admin->generateAuthKey();
        $admin->enable();
        $admin->created_at = $admin->updated_at = time();

        $this->insert('{{%user}}',$admin->toArray());

        // Crear category table
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'category_name' => $this->string(32)->notNull(),
            'category_sequence' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the category Default
        $defaultCategory = new Category();
        $defaultCategory->category_name = '默认分类';
        $defaultCategory->category_sequence = 1;
        $defaultCategory->created_at = $defaultCategory->updated_at = time();
        $defaultCategory->last_editor = 1;

        $this->insert('{{%category}}',$defaultCategory->toArray());

        // Crear blog table
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'blog_title' => $this->string(255)->notNull(),
            'blog_category' => $this->integer()->notNull(),
            'blog_content' => $this->text()->notNull(),
            'blog_date' => $this->string(16)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'pageviews' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'last_editor' => $this->integer()->notNull(),
        ], $tableOptions);

        // Initialize the blog "Hello world"
        $hello = new Blog();
        $hello->blog_title = 'Hello world';
        $hello->blog_category = 1;
        $hello->blog_content = 'Hello world! Welcome to RingBlog!';
        $hello->blog_date = date("Y-m-d", time());
        $hello->status = Blog::STATUS_ENABLED;
        $hello->pageviews = 0;
        $hello->created_at = $hello->updated_at = time();
        $hello->last_editor = 1;

        $this->insert('{{%blog}}',$hello->toArray());
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%blog}}');
    }
}
