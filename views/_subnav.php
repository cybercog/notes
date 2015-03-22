<?php
use yii\helpers\Html;
?>
<?= Html::a('Создать заметку', ['note/create'], ['class' => 'btn btn-primary pull-right']) ?>
<ul class="nav nav-tabs">
    <?php if (!Yii::$app->user->isGuest): ?>
        <li role="presentation"<?= $cur === 'own' ? 'class="active"' : '' ?>><?= Html::a('Мои заметки', ['site/index']) ?></li>
    <?php endif ?>
    <li role="presentation"<?= $cur === 'all' ? 'class="active"' : '' ?>><?= Html::a('Все заметки', ['note/index']) ?></li>
</ul>
