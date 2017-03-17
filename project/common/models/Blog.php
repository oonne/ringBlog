<?php

namespace common\models;

class Blog extends ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 10;

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
            [['blog_content'], 'string'],

            [
                ['blog_category'],
                'exist',
                'targetClass' => Category::className(),
                'targetAttribute' => 'id'
            ],

            ['status', 'default', 'value' => self::STATUS_ENABLED],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
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
            'status' => '状态',
            'pageviews' => '点击量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'last_editor' => '最后修改人ID',
            'createdTimeRange' => '创建时间',
            'updatedTimeRange' => '更新时间',
        ];
    }

    public function addPageviews()
    {
        $this->pageviews += 1;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'blog_category']);
    }

    /**
     * Change status
     */
    public function enable()
    {
        $this->status = self::STATUS_ENABLED;
    }

    public function disable()
    {
        $this->status = self::STATUS_DISABLED;
    }

    /**
     * Get status
     */
    public static function getStatusList()
    {
        if (self::$_statusList === null) {
            self::$_statusList = [
                self::STATUS_ENABLED => '正常',
                self::STATUS_DISABLED => '禁用'
            ];
        }

        return self::$_statusList;
    }

    public function getStatusMsg()
    {
        $list = getStatusList();

        return $list[$this->status] ?? null;
    }

}