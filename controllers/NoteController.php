<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Note;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\NoteSearch;

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
        $noteSearch = new NoteSearch();
        $noteProvider = $noteSearch->search(Yii::$app->request->queryParams, ['visibility' => Note::VIS_PUBLIC_LISTED]);

        return $this->render('index', [
            'notes' => $noteProvider->getModels(),
            'pagination' => $noteProvider->pagination,
            'sort' => $noteProvider->sort,
            'noteSearch' => $noteSearch
        ]);
    }

    public function actionView($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('viewNote', ['note' => $note])) {
            $query = Note::find();
            $previousNote = $query->where(['<=', 'created_at', $note->created_at])
                ->andWhere(['<', 'id', $note->id])
                ->andWhere(['visibility' => Note::VIS_PUBLIC_LISTED])
                ->orderBy('created_at DESC, id DESC')
                ->one();
            $nextNote = $query->where(['>=', 'created_at', $note->created_at])
                ->andWhere(['>', 'id', $note->id])
                ->andWhere(['visibility' => Note::VIS_PUBLIC_LISTED])
                ->orderBy('created_at ASC, id ASC')
                ->one();

            return $this->render('view', [
                'note' => $note,
                'previousNote' => $previousNote,
                'nextNote' => $nextNote
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionCreate()
    {
        $note = new Note();
        $note->visibility = Note::VIS_PUBLIC_LISTED;

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            if (Yii::$app->user->isGuest) {
                $note->save(false);
            } else {
                $note->link('user', Yii::$app->user->identity);
            }

            return $this->redirect(['view', 'id' => $note->id]);
        }

        return $this->render('create', ['note' => $note]);
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

            return $this->redirect(Yii::$app->request->referrer);
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
