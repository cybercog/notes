<?php
$this->title = 'Изменение заметки';
?>
<h1 class="text-center"><?= $this->title ?></h1>

<?= $this->render('_form', ['note' => $note]) ?>
