<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use common\models\Blog;
use common\models\Category;

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
        $categoryName = Category::findOne($id)->category_name;

        $query = Blog::find()->where([
            'status' => Blog::STATUS_ENABLED
        ])->andFilterWhere([
            'blog_category' => $id
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'blog_date' => SORT_DESC
                ]
            ]
        ]);
        
        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'categoryName' => $categoryName
        ]);
    }

    public function actionBlog($id)
    {    
        $model = Blog::findOne([
            'id' => $id,
            'status' => Blog::STATUS_ENABLED
        ]);
        
        if (!$model) {
            return $this->render('error', [
                'name' => '内容错误',
                'message' => '查无相关博客',
            ]);
        }

        $model->updateCounters(['pageviews' => 1]);

        return $this->render('blog', [
            'blog' => $model
        ]);
    }
}
