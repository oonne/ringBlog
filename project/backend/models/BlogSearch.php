<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\models\Blog;

class BlogSearch extends Blog
{
    public $createdTimeFrom;
    public $createdTimeTo;
    public $updatedTimeFrom;
    public $updatedTimeTo;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['blog_title','blog_content', 'blog_category', 'updatedTimeFrom', 'updatedTimeTo', 'createdTimeFrom', 'createdTimeTo'], 'safe']
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

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'blog_title', $this->blog_title])
              ->andFilterWhere(['like', 'blog_content', $this->blog_content])
              ->andFilterWhere(['blog_category' => $this->blog_category])
              ->andFilterWhere(['>=', 'created_at', $this->createdTimeFrom])
              ->andFilterWhere(['<', 'created_at', $this->createdTimeTo])
              ->andFilterWhere(['>=', 'updated_at', $this->updatedTimeFrom])
              ->andFilterWhere(['<', 'updated_at', $this->updatedTimeTo]);

        return $dataProvider;
    }
}