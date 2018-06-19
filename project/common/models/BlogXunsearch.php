<?php

namespace common\models;

class BlogXunsearch extends \hightman\xunsearch\ActiveRecord
{
    public static function projectName() {
        return 'blog';
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'blog_category']);
    }
}