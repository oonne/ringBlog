<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\helpers\Query as QueryHelper;
use common\models\Blog;

class RecycleSearch extends Blog
{
    public $dateRange;
    public $deletedTimeRange;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['blog_title','blog_content', 'pageviews', 'blog_category', 'dateRange', 'deletedTimeRange'], 'safe']
        ];
    }

    public function Search($params)
    {
        $query = Blog::find()->where(['status' => Blog::STATUS_DELETED]);

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
        $deletedTime = explode('~', $this->deletedTimeRange, 2);
        if (count($deletedTime) == 2){
            $query->andFilterWhere(['>=', "FROM_UNIXTIME(`updated_at`, '%Y-%m-%d')", $deletedTime[0] ])
                  ->andFilterWhere(['<=', "FROM_UNIXTIME(`updated_at`, '%Y-%m-%d')", $deletedTime[1] ]);
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'blog_title', $this->blog_title])
              ->andFilterWhere(['like', 'blog_content', $this->blog_content])
              ->andFilterWhere(['blog_category' => $this->blog_category]);

        return $dataProvider;
    }
}