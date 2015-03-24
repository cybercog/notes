<?php
use yii\helpers\Html;

$this->title = 'Заметка - ' . Html::encode($note->name);
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <?php if (Yii::$app->user->can('updateNote', ['note' => $note])): ?>
                    <div class="btn-group pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-cog"></span> Изменить', ['note/edit', 'id' => $note->id], ['class' => 'btn btn-info btn-xs']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Удалить', ['note/delete', 'id' => $note->id], ['class' => 'btn btn-danger btn-xs', 'data-method' => 'post']) ?>
                    </div>
                <?php endif ?>
                <?= Html::encode($note->name) ?>
            </div>
            <div class="panel-body">
                <div class="note-text"><?= Html::encode($note->description) ?></div>
                <hr>
                <div class="pull-left">Добавил: <?= $note->user ? Html::encode($note->user->name) : 'гость' ?>.</div>
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
    </div>
</div>
