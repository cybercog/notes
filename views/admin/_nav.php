<?php
use yii\helpers\Html;
?>
<ul class="nav nav-tabs admin-nav">
    <li role="presentation"<?= $cur === 'statistic' ? 'class="active"' : '' ?>><?= Html::a('Статистика', ['admin/statistic']) ?></li>
    <li role="presentation"<?= $cur === 'users' ? 'class="active"' : '' ?>><?= Html::a('Управление пользователями', ['admin/users']) ?></li>
</ul>
