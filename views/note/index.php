<?php
use yii\helpers\Html;
?>
<?= $this->render('/_subnav', ['cur' => 'all']) ?>

<div class="nav-tabs-body">
    <div class="row">
        <?php foreach ($notes as $note): ?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Html::a(Html::encode($note->name), ['note/view', 'id' => $note->id]) ?></div>
                    <div class="panel-body"><?= Html::encode($note->description) ?></div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
