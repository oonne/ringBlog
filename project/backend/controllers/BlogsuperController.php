<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use common\models\Blog;
use backend\models\BlogSearch;

/**
 * Blogsuper controller
 */
class BlogsuperController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionCreateBlog()
    {
        $model = new Blog();
        $model->setScenario('creation');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->last_editor = Yii::$app->user->id;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', '添加成功！');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', '添加失败。');
                }
            }
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

    public function actionUpdateBlog($id)
    {
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->last_editor = Yii::$app->user->id;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', '更新成功！');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', '更新失败。');
                }
            }
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

    public function actionViewBlog($id)
    {
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

   public function actionDeleteBlog($id)
    {
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        $model->status = Blog::STATUS_DELETED;
        $model->last_editor = Yii::$app->user->id;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', '已删除！');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', '删除失败。');
        }
        
        return $this->redirect(['index']);
    }

    public function actionStatus($id, $status)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = Blog::findOne($id);

        if (!$model || !in_array($status, [Blog::STATUS_ENABLED, Blog::STATUS_DISABLED])) {
            throw new BadRequestHttpException('请求错误！');
        }

        $model->status = $status;

        if ($model->save(false)) {
            return [
                'status' => 'success',
                'data' => []
            ];
        } else {
            return [
                'status' => 'fail',
                'data' => [
                    'message' => '更新出错！'
                ]
            ];
        }
    }
}
