<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <?php foreach ($notes as $noteNumber => $note): ?>
        <div class="col-md-3">
            <h2><?= Html::a('Заметка ' . ($noteNumber + 1), ['note/view', 'id' => $note->id]) ?></h2>
            <p>Имя: <?= Html::encode($note->name) ?></p>
            <p>Описание: <?= Html::encode($note->description) ?></p>
        </div>
    <?php endforeach ?>
</div>
