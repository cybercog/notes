<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Note;
use yii\web\NotFoundHttpException;
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
        return $this->render('view', ['note' => $this->findNote($id)]);
    }

    public function actionCreate()
    {
        $note = new Note();

        if ($note->load(Yii::$app->request->post()) && $note->save()) {
            return $this->redirect(['view', 'id' => $note->id]);
        }

        return $this->render('create', ['note' => $note]);
    }

    public function actionEdit($id)
    {
        $note = $this->findNote($id);

        if ($note->load(Yii::$app->request->post()) && $note->save()) {
            return $this->redirect(['view', 'id' => $note->id]);
        }

        return $this->render('edit', ['note' => $note]);
    }

    public function actionDelete($id)
    {
        $this->findNote($id)->delete();

        return $this->redirect('index');
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
