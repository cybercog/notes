<?php
$this->title = 'Создание заметки';
?>
<h1 class="text-center"><?= $this->title ?></h1>

<?= $this->render('_form', ['note' => $note]) ?>
