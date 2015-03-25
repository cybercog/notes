<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\UserSearch;
use app\models\NoteSearch;

class AdminController extends Controller
{
    public function actionStatistic()
    {
        if (Yii::$app->user->can('viewAdminPanelStatistic')){
            return $this->render('statistic');
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionUsers()
    {
        if (Yii::$app->user->can('viewAdminPanelUsers')) {
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

    public function actionNotes()
    {
        if (Yii::$app->user->can('viewAdminPanelNotes')) {
            $noteSearch = new NoteSearch;
            $noteSearch->setScenario('admin');
            $noteProvider = $noteSearch->search(Yii::$app->request->queryParams);

            return $this->render('notes', [
                'noteSearch' => $noteSearch,
                'noteProvider' => $noteProvider
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }
}
