<?php

namespace common\helpers;

use Yii;
use common\models\BlogXunsearch;
use common\models\Blog;

class Xunsearch
{
    /**
     * 更新全部索引
     * 
     * @return boolean
     */
    public static function updateAllBlog()
    {
        try
        {
            BlogXunsearch::getDb()->getIndex()->clean();
            
            $blogs = Blog::find()->where(['status' => Blog::STATUS_ENABLED])->asArray()->all();
            foreach ($blogs as $blog) {
                $model = new BlogXunsearch();
                $model->setAttributes($blog);
                
                if (!$model->save()) {
                    throw new \Exception();
                }
            }
            
            return BlogXunsearch::getDb()->getIndex()->flushIndex();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * 增加索引
     * 
     * @param Blog $blog
     * @return boolean
     */
    public static function addBlog(Blog $blog)
    {
        try
        {
            $model = new BlogXunsearch();
            $model->setAttributes($blog->getAttributes());
            
            if (!$model->save()) {
                throw new \Exception();
            }
            
            return BlogXunsearch::getDb()->getIndex()->flushIndex();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * 删除索引
     * 
     * @param string $id
     * @return boolean
     */
    public static function deleteBlog($id)
    {
        try
        {
            $model = BlogXunsearch::findOne($id);
            if (!$model || !$model->delete()) {
                throw new \Exception();
            }
            
            return BlogXunsearch::getDb()->getIndex()->flushIndex();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * 更新索引
     * 
     * @param Blog $blog
     * @return boolean
     */
    public static function updateBlog(Blog $blog)
    {
        try
        {
            $model = BlogXunsearch::findOne($blog->id);
            if (!$model) {
                throw new \Exception();
            }
            
            $model->setAttributes($blog->getAttributes());
            if (!$model->update()) {
                throw new \Exception();
            }
            
            return BlogXunsearch::getDb()->getIndex()->flushIndex();
        } catch (\Exception $e) {
            return false;
        }
    }
}