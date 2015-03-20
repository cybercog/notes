<?php
use yii\helpers\Html;

$this->title = 'Ошибка ' . $exception->statusCode;
?>
<div class="well well-sm">
    <h1 class="lead"><?= Html::encode($this->title) ?></h1>
    <p>
        Произошла ошибка. Вы можете вернуться на <?= Html::a('главную страницу', ['site/index']) ?> или <?= Html::a('связаться с нами', ['site/conta']) ?>.</p>
</div>
