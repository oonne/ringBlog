<?php

namespace frontend\controllers;

use common\models\Comment;
use Yii;
class CommentController extends \yii\web\Controller
{
    public function actionAdd($id)
    {
        $comment = new  Comment();
        $comment ->post_id = $id;
        $comment->comment = Yii::$app->request->post('comment');
        if ($comment->save()) {
            return  $this->redirect(Yii::$app->request->referrer);
        }
        var_dump($comment->errors);
    }

}