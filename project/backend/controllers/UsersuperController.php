<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use common\models\User;
use backend\models\UserSearch;

/**
 * Usersuper controller
 */
class UsersuperController extends Controller
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionCreateUser()
    {
        $model = new User();
        $model->setScenario('creation');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->setPassword($model->password);
                $model->generateAccessToken();
                $model->generateAuthKey();
                $model->enable();
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

    public function actionUpdateUser($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new BadRequestHttpException('请求错误！');
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->password !== null) {
                    $model->setPassword($model->password);
                }

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', '更新成功！');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', '更新失败。');
                }
            }
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

   public function actionDeleteUser($id)
    {
        if (Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash('danger', '不能删除当前登录的用户');    
        } else {
            $model = User::findOne($id);

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
        }
        
        return $this->redirect(['index']);
    }

    public function actionStatus($id, $status)
    {

        if (Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash('danger', '不能修改当前登录用户的状态'); 
            return $this->redirect(['index']);   
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = User::findOne($id);

            if (!$model || !in_array($status, [User::STATUS_ENABLED, User::STATUS_DISABLED])) {
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
}
