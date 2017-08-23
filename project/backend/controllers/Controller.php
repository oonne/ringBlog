<?php

namespace backend\controllers;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * The base controller
 */
class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {         
        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    /**
     * Redirects the browser to the referrer page.
     *
     * You can use this method in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to referrer page
     * return $this->goReferrer();
     * ```
     *
     * @return Response the current response object
     */
    public function goReferrer($defaultUrl = null)
    {
        if (Yii::$app->request->referrer) {
            return Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
        } else {
            if ($defaultUrl === null) {
                $defaultUrl = Yii::$app->getHomeUrl();
            }
            return Yii::$app->getResponse()->redirect($defaultUrl);
        }
    }
}
