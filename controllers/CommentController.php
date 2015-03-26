<?php
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Comment;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
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
        if (Yii::$app->user->can('updateComment')) {
            $comment = $this->findComment($id);

            if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
                return $this->redirect(['note/view', 'id' => $comment->note_id]);
            }

            return $this->render('update', ['comment' => $comment,]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteComment')) {
            $comment = $this->findComment($id);
            $comment->delete();

            return $this->redirect(['note/view', 'id' => $comment->note_id]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    private function findComment($id)
    {
        if ($comment = Comment::findOne($id)) {
            return $comment;
        } else {
            throw new NotFoundHttpException;
        }
    }
}
