<?php
use yii\helpers\Html;
?>
<p>ИД: <?= $note->id ?></p>
<p>Имя: <?= Html::encode($note->name) ?></p>
<p>Описание: <?= Html::encode($note->description) ?></p>
<div>
    <?= Html::a('Изменить', ['note/edit', 'id' => $note->id]) ?> |
    <?= Html::a('Удалить', ['note/delete', 'id' => $note->id], ['data-method' => 'post']) ?>
</div>
