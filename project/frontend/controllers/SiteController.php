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
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCategory($id)
    {    
        $query = Blog::find()->andFilterWhere(['blog_category' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionBlog($id)
    {    
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        return $this->render('blog', [
            'blog' => $model
        ]);
    }
}
