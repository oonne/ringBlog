<?php

namespace common\helpers;

use Yii;
use yii\db\QueryInterface;

class Query
{
    public static function addDigitalFilter(QueryInterface $query, $attribute, $value)
    {
        $pattern = '/^(>|>=|<|<=|=)(\d*\.?\d+)$/';
        if (preg_match($pattern, $value, $matches) === 1) {
            $query->andFilterWhere([$matches[1], $attribute, $matches[2]]);
        } else {
            $query->andFilterWhere(['like', $attribute, $value]);
        }
    }

    public static function addDigitalFilterHaving(yii\db\Query $query, $attribute, $value)
    {
        $pattern = '/^(>|>=|<|<=|=)(\d*\.?\d+)$/';
        if (preg_match($pattern, $value, $matches) === 1) {
            $query->andHaving([$matches[1], $attribute, $matches[2]]);
        } else {
            $query->andHaving(['like', $attribute, $value]);
        }
    }
}