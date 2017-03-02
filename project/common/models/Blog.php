<?php

namespace common\models;

class Blog extends ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLE = 10;

    private static $_statusList;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            parent::timestampBehavior()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_title', 'blog_category', 'blog_content'], 'required', 'on' => ['creation']],
            
            [['blog_title'], 'string', 'max' => 255],
            [['blog_category'], 'integer'],
            [['blog_content'], 'string'],

            ['status', 'default', 'value' => self::STATUS_ENABLE],
            ['status', 'in', 'range' => [self::STATUS_ENABLE, self::STATUS_DISABLED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'User ID',
            'blog_title' => '标题',
            'blog_category' => '分类',
            'blog_content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'last_editor' => '最后修改人ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

}