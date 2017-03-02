<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User
{

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['username', 'nickname', 'status'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['like', 'nickname', $this->nickname])
              ->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }
}