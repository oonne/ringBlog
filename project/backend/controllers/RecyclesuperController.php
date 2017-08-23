<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use common\models\Blog;
use backend\models\RecycleSearch;

class RecyclesuperController extends Controller
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
        $searchModel = new RecycleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewRecycle($id)
    {
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionRecoveryRecycle($id)
    {
        $model = Blog::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        $model->status = Blog::STATUS_DISABLED;
        $model->last_editor = Yii::$app->user->id;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', '已恢复为禁用状态！');
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('danger', '恢复失败。');
        }
        
        return $this->redirect(['index']);
    }

    public function actionDeleteRecycle($id)
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