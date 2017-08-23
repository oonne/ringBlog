<?php

namespace frontend\controllers;

use Yii;
use common\models\Reply;

class ReplyController extends \yii\web\Controller
{
    public function actionAdd()
    {
        $reply = new  Reply();
        $reply ->comment_id = Yii::$app->request->post('comment_id');
        $reply->reply = Yii::$app->request->post('reply');
        if ($reply->save()) {
            return  $this->redirect(Yii::$app->request->referrer);
        }
    }

}