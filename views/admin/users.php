<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

echo $this->render('_nav', ['cur' => 'users']);

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $userProvider,
    'filterModel' => $userSearch,
    'columns' => [
        'id', 'name', 'email',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d-m-Y'],
        ],
        [
            'attribute' => 'role.item_name'
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update} {delete}'
        ]
    ],
]);
Pjax::end();
?>
