<?php
namespace frontend\controllers;

use common\models\Comment;
use common\models\Reply;
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

        $comments = Comment::findAll([
            'post_id' => $id,
            'status' => 1]);  //获得该文章所有 status 为 1 的评论
        $replys = array();
        foreach ($comments as $comment) {
            $replys[$comment->id] = Reply::findAll(['comment_id' => $comment->id,'status' => 1]);  //根据评论 id 查找所有 status 为 1 的评论，并赋值给$replys数组，
        }

        $model->addPageviews();

        return $this->render('blog', [
            'blog' => $model,
            'comments'=>$comments,    //传递变量到前台
            'replys' => $replys
        ]);
    }
}
