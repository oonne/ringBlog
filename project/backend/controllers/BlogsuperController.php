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
 * Usersuper controller
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
                if ($model->save(false)) {
                    $model->last_editor = Yii::$app->user->id;
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
                if ($model->save(false)) {
                    $model->last_editor = Yii::$app->user->id;
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

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->delete()) {
                throw new \Exception('删除失败！');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', '删除成功！');
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        
        return $this->redirect(['index']);
    }
}
