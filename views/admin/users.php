<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\helpers\Html;

echo $this->render('_nav', ['cur' => 'users']);

Pjax::begin(['timeout' => 5000]);
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
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['user/update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['user/delete', 'id' => $model->id], ['data-method' => 'post']);
                }
            ]
        ]
    ],
]);
Pjax::end();
?>
