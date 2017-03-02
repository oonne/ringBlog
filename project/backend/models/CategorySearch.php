<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\models\Category;

class CategorySearch extends Category
{

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['category_name'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['category_sequence' => SORT_DESC]]
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'category_name', $this->category_name]);

        return $dataProvider;
    }
}