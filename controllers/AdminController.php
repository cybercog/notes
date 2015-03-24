<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\UserSearch;

class AdminController extends Controller
{
    public function actionStatistic()
    {
        if (Yii::$app->user->can('viewAdminStatistic')){
            return $this->render('statistic');
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionUsers()
    {
        if (Yii::$app->user->can('viewAdminUsers')) {
            $userSearch = new UserSearch;
            $userProvider = $userSearch->search(Yii::$app->request->queryParams);

            return $this->render('users', [
                'userSearch' => $userSearch,
                'userProvider' => $userProvider
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }
}
