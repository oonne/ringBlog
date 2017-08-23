<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use common\models\Category;
use backend\models\CategorySearch;
use oonne\sortablegrid\SortableGridAction;
use common\models\Blog;

/**
 * Categorysuper controller
 */
class CategorysuperController extends Controller
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

    public function actions()
    {
        return [
            'sequence' => [
                'class' => SortableGridAction::className(),
                'modelName' => Category::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionCreateCategory()
    {
        $model = new Category();
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

    public function actionUpdateCategory($id)
    {
        $model = Category::findOne($id);

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

   public function actionDeleteCategory($id)
    {
        $model = Category::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        $blog = Blog::find()->where(['blog_category' => $id])->exists();
        if ( $blog ) {
            Yii::$app->session->setFlash('danger', '该分类下有内容，不能删除！');
        } else {
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
        }
        
        return $this->redirect(['index']);
    }
}
