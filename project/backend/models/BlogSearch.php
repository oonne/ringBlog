<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\helpers\Query as QueryHelper;
use common\models\Blog;

class BlogSearch extends Blog
{
    public $createdTimeRange;
    public $_createdFrom;
    public $_createdTo;
    public $updatedTimeRange;
    public $_updatedFrom;
    public $_updatedTo;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['blog_title','blog_content', 'pageviews', 'blog_category', 'status', 'createdTimeRange', 'updatedTimeRange'], 'safe']
        ];
    }

    public function Search($params)
    {
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        QueryHelper::addDigitalFilter($query, 'pageviews', $this->pageviews);

        $createdTime = explode('~', $this->createdTimeRange, 2);
        if (count($createdTime) == 2){
            $this->_createdFrom = strtotime($createdTime[0]);
            $this->_createdTo = strtotime($createdTime[1]);
            $query->andFilterWhere(['>=', 'created_at', $this->_createdFrom ])
                  ->andFilterWhere(['<', 'created_at', $this->_createdTo ]);
        }
        $updatedTime = explode('~', $this->updatedTimeRange, 2);
        if (count($updatedTime) == 2){
            $this->_updatedFrom = strtotime($updatedTime[0]);
            $this->_updatedTo = strtotime($updatedTime[1]);
            $query->andFilterWhere(['>=', 'updated_at', $this->_updatedFrom ])
                  ->andFilterWhere(['<', 'updated_at', $this->_updatedTo ]);
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'blog_title', $this->blog_title])
              ->andFilterWhere(['like', 'blog_content', $this->blog_content])
              ->andFilterWhere(['status' => $this->status])
              ->andFilterWhere(['blog_category' => $this->blog_category]);

        return $dataProvider;
    }
}