<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use common\models\Blog;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {    
        $query = Blog::find()->where([
            'status' => Blog::STATUS_ENABLED
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'blog_date' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCategory($id)
    {    
        $query = Blog::find()->where([
            'status' => Blog::STATUS_ENABLED
        ])->andFilterWhere([
            'blog_category' => $id
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'blog_date' => SORT_DESC
                ]
            ]
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionBlog($id)
    {    
        $model = Blog::findOne([
            'id' => $id,
            'status' => Blog::STATUS_ENABLED
        ]);
        
        if (!$model) {
            // throw new BadRequestHttpException('请求错误！');
            return $this->render('error', [
                'name' => '查无分类博客',
                'message' => '内容已被作者删除',
            ]);
        }

        $model->updateCounters(['pageviews' => 1]);

        return $this->render('blog', [
            'blog' => $model
        ]);
    }
}
