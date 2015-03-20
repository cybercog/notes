<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php foreach ($notes as $noteNumber => $note): ?>
    <div>
        <h2><?= Html::a('Заметка ' . ($noteNumber + 1), ['note/view', 'id' => $note->id]) ?></h2>
        <p>ИД: <?= $note->id ?></p>
        <p>Имя: <?= Html::encode($note->name) ?></p>
        <p>Описание: <?= Html::encode($note->description) ?></p>
    </div>
<?php endforeach ?>
