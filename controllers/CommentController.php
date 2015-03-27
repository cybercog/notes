<?php
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Comment;
use app\models\CommentClosure;
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

    public function actionCreate($noteId, $parentId = null)
    {
        $comment = new Comment;

        if ($comment->load(Yii::$app->request->post()) && $comment->validate()) {
            if ($parentId !== null && (CommentClosure::find()->where(['child_id' => $parentId])->max('depth') >= Yii::$app->params['maxCommentsDepth'])) {
                throw new ForbiddenHttpException;
            }

            $comment->user_id = Yii::$app->user->getId();
            $comment->note_id = $noteId;
            $comment->save(false);

            CommentClosure::insertComment($comment->id, $parentId);

            return $this->redirect(['note/view', 'id' => $noteId]);
        }

        return $this->render('create', ['comment' => $comment]);
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
            $noteId = $this->findComment($id)->note_id;

            Comment::deleteAll(['id' => CommentClosure::findChildrenIds($id)]);

            return $this->redirect(['note/view', 'id' => $noteId]);
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
