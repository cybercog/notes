<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\UserEdit;


class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ],
            ]
        ];
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('editUser')) {
            $user = $this->findUser($id);
            $userEdit = new UserEdit();
            $userEdit->attributes = $user->attributes;
            $userEdit->role = $user->role->item_name;

            if ($userEdit->load(Yii::$app->request->post())) {
                $userEdit->_oldEmail = $userEdit->email;
                $userEdit->_oldName = $userEdit->name;

                if ($userEdit->editUser($user)) {
                    return $this->redirect(['admin/users']);
                }
            }

            return $this->render('update', ['userEdit' => $userEdit]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteUser')) {
            $this->findUser($id)->delete();

            return $this->redirect(['admin/users']);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    private function findUser($id)
    {
        if ($user = User::findOne($id)) {
            return $user;
        } else {
            throw new NotFoundHttpException;
        }
    }
}
