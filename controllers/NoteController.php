<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Note;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\NoteSearch;
use app\models\Comment;
use app\models\CommentClosure;
use yii\web\Cookie;

class NoteController extends Controller
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

    public function actionIndex($viewType = null)
    {
        if ($viewType) {
            Yii::$app->response->cookies->add(new Cookie(['name' => 'viewType', 'value' => $viewType]));
        } else {
            if ($cookie = Yii::$app->request->cookies->get('viewType')) {
                $viewType = $cookie->value;
            } else {
                $viewType = 'panel';
                Yii::$app->response->cookies->add(new Cookie(['name' => 'viewType', 'value' => $viewType]));
            }
        }

        $noteSearch = new NoteSearch();
        $noteSearch->setScenario('all');
        $noteProvider = $noteSearch->search(Yii::$app->request->queryParams, ['visibility' => Note::VIS_PUBLIC_LISTED]);

        return $this->render('/notes', [
            'cur' => 'all',
            'viewType' => $viewType,
            'notes' => $noteProvider->getModels(),
            'pagination' => $noteProvider->pagination,
            'sort' => $noteProvider->sort,
            'noteSearch' => $noteSearch
        ]);
    }

    public function actionView($id)
    {
        $note = Note::find()->where(['id' => $id])->with('comments')->with('user')->one();

        if (!$note) {
            throw new NotFoundHttpException;
        }

        if (Yii::$app->user->can('viewNote', ['note' => $note])) {
            $query = Note::find()->with('user');
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

            $comment = new Comment;
            if ($comment->load(Yii::$app->request->post()) && $comment->validate()) {
                $parentId = Yii::$app->request->post('parentId');
                if ($parentId !== null && (CommentClosure::find()->where(['child_id' => $parentId])->max('depth') >= Yii::$app->params['maxCommentsDepth'])) {
                    throw new ForbiddenHttpException;
                }

                $comment->user_id = Yii::$app->user->getId();
                $comment->note_id = $note->id;
                $comment->save(false);

                CommentClosure::insertComment($comment->id, $parentId);

                return $this->refresh();
            }

            return $this->render('view', [
                'note' => $note,
                'previousNote' => $previousNote,
                'nextNote' => $nextNote,
                'comment' => $comment
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

    public function actionUpdate($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('updateNote', ['note' => $note])) {
            if ($note->load(Yii::$app->request->post()) && $note->save()) {
                return $this->redirect(['view', 'id' => $note->id]);
            }

            return $this->render('update', ['note' => $note]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionDelete($id)
    {
        $note = $this->findNote($id);

        if (Yii::$app->user->can('deleteNote', ['note' => $note])) {
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
