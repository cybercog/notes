<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заметка - ' . Html::encode($note->name);
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <?php if (Yii::$app->user->can('updateNote', ['note' => $note])): ?>
                    <div class="btn-group pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-cog"></span> Изменить', ['note/update', 'id' => $note->id], ['class' => 'btn btn-info btn-xs']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Удалить', ['note/delete', 'id' => $note->id], ['class' => 'btn btn-danger btn-xs', 'data-method' => 'post']) ?>
                    </div>
                <?php endif ?>
                <?= Html::encode($note->name) ?>
            </div>
            <div class="panel-body">
                <div class="raw-text"><?= Html::encode($note->description) ?></div>
                <hr>
                <div class="pull-left">Добавил: <?= $note->user ? Html::a(Html::encode($note->user->name), ['note/index', 'NoteSearch[user.name]' => Html::encode($note->user->name)]) : 'гость' ?>.</div>
                <div class="pull-right">Время добавления: <?= Yii::$app->formatter->asDate('@' . $note->created_at, 'php:d-m-Y') ?>.</div>
            </div>
            <div class="panel-footer">
                <nav>
                    <ul class="pager">
                        <?php if ($previousNote): ?>
                            <li class="next"><?= Html::a('Предыдущая заметка <span aria-hidden="true">&rarr;</span>', ['note/view', 'id' => $previousNote->id]) ?></li>
                        <?php endif ?>
                        <?php if ($nextNote): ?>
                            <li class="previous"><?= Html::a('<span aria-hidden="true">&larr;</span> Следующая заметка', ['note/view', 'id' => $nextNote->id]) ?></li>
                        <?php endif ?>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3 class="text-center">Добавить комментарий</h3>
                <?= $this->render('/comment/_form', ['comment' => $comment]) ?>

                <?php foreach ($note->comments as $comment): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php $commentControl = '' ?>
                            <?php if (Yii::$app->user->can('updateComment')): ?>
                                <?php $commentControl .= Html::a('<span class="glyphicon glyphicon-cog"></span> Изменить', ['comment/update', 'id' => $comment->id], ['class' => 'btn btn-info btn-xs']) ?>
                            <?php endif ?>
                            <?php if (Yii::$app->user->can('deleteComment')): ?>
                                <?php $commentControl .= Html::a('<span class="glyphicon glyphicon-remove"></span> Удалить', ['comment/delete', 'id' => $comment->id], ['class' => 'btn btn-danger btn-xs', 'data-method' => 'post']) ?>
                            <?php endif ?>
                            <?php if ($commentControl !== ''): ?>
                                <div class="btn-group pull-right"><?= $commentControl ?></div>
                            <?php endif ?>

                            Автор: <?= isset($comment->user) ? Html::a(Html::encode($comment->user->name), ['note/index', 'NoteSearch[user.name]' => Html::encode($comment->user->name)]) : 'гость' ?>
                        </div>
                        <div class="panel-body raw-text"><?= $comment->message ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
