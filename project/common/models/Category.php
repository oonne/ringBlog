<?php

namespace common\models;

use Yii;
use oonne\sortablegrid\SortableGridBehavior;
use yii\db\Query;

class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            parent::timestampBehavior(),
            [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'category_sequence'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required', 'on' => ['creation']],
            [['category_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Category ID',
            'category_name' => '分类名',
            'category_sequence' => '分类排序',
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

    /**
     * @inheritdoc
     */
    public static function getKeyValuePairs()
    {
        $query = (new Query())->select(['id', 'category_name'])
            ->from([self::tableName()])
            ->orderBy(['category_sequence' => SORT_DESC]);

        list($sql, $params) = Yii::$app->db->getQueryBuilder()->build($query);
        $data = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_KEY_PAIR);
        return $data;
    }

    public static function getCategoryList()
    {
        $query = (new Query())->select(['id', 'category_name'])
            ->from([self::tableName()])
            ->orderBy(['category_sequence' => SORT_DESC]);

        list($sql, $params) = Yii::$app->db->getQueryBuilder()->build($query);
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
}