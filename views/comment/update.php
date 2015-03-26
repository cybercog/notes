<?php
use yii\helpers\Html;
?>
<h1 class="text-center">Изменение комментария</h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <p>Автор: <?= isset($comment->user) ? Html::a(Html::encode($comment->user->name), ['note/index', 'NoteSearch[user.name]' => Html::encode($comment->user->name)]) : 'гость' ?></p>
        <?= $this->render('_form', ['comment' => $comment]) ?>
    </div>
</div>
