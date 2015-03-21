<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Note;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class NoteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $notes = Note::find()->all();

        return $this->render('index', ['notes' => $notes]);
    }

    public function actionView($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('viewNote', ['note' => $note])) {
            return $this->render('view', ['note' => $note]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('createNote')) {
            $note = new Note();
            $note->public = 1;

            if ($note->load(Yii::$app->request->post()) && $note->validate()) {
                if (Yii::$app->user->isGuest) {
                    $note->save(false);
                } else {
                    $note->link('user', Yii::$app->user->identity);
                }

                return $this->redirect(['view', 'id' => $note->id]);
            }

            return $this->render('create', ['note' => $note]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionEdit($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('updateNote', ['note' => $note])) {
            if ($note->load(Yii::$app->request->post()) && $note->save()) {
                return $this->redirect(['view', 'id' => $note->id]);
            }

            return $this->render('edit', ['note' => $note]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionDelete($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('removeNote', ['note' => $note])) {
            $note->delete();

            return $this->redirect('index');
        } else {
            throw new ForbiddenHttpException;
        }
    }

    private function findNote($id)
    {
        if ($note = Note::findOne($id)) {
            return $note;
        } else {
            throw new NotFoundHttpException('Заметка не найдена');
        }
    }
}
