<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\helpers\Query as QueryHelper;
use common\models\Blog;

class BlogSearch extends Blog
{
    public $dateRange;
    public $updatedTimeRange;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['blog_title','blog_content', 'pageviews', 'blog_category', 'status', 'dateRange', 'updatedTimeRange'], 'safe']
        ];
    }

    public function Search($params)
    {
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['blog_date' => SORT_DESC]]
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        QueryHelper::addDigitalFilter($query, 'pageviews', $this->pageviews);

        $date = explode('~', $this->dateRange, 2);
        if (count($date) == 2){
            $_dateFrom = $date[0];
            $_dateTo = $date[1];
            $query->andFilterWhere(['>=', 'blog_date', $_dateFrom ])
                  ->andFilterWhere(['<=', 'blog_date', $_dateTo ]);
        }
        $updatedTime = explode('~', $this->updatedTimeRange, 2);
        if (count($updatedTime) == 2){
            $_updatedFrom = strtotime($updatedTime[0]);
            $_updatedTo = strtotime($updatedTime[1])+86400;
            $query->andFilterWhere(['>=', 'updated_at', $_updatedFrom ])
                  ->andFilterWhere(['<', 'updated_at', $_updatedTo ]);
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'blog_title', $this->blog_title])
              ->andFilterWhere(['like', 'blog_content', $this->blog_content])
              ->andFilterWhere(['status' => $this->status])
              ->andFilterWhere(['blog_category' => $this->blog_category]);

        return $dataProvider;
    }
}