<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->authManager->getAssignment('admin', Yii::$app->user->getId()) === null) {
            throw new ForbiddenHttpException;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index.php');
    }
}
