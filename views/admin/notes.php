<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use app\models\Note;

echo $this->render('_nav', ['cur' => 'notes']);

echo Gridview::widget([
    'options' => ['class' => 'grid-view table-responsive'],
    'dataProvider' => $noteProvider,
    'filterModel' => $noteSearch,
    'columns' => [
        'id',
        [
            'attribute' => 'name',
            'value' => function ($model, $key, $index, $column) {
                return mb_strimwidth($model->name, 0, 20, '...', 'UTF-8');
            }
        ],
        [
            'attribute' => 'visibility',
            'value' => function ($model, $key, $index, $column) {
                switch ($model->visibility) {
                    case Note::VIS_PRIVATE: return 'Только себе';
                    case Note::VIS_PUBLIC_UNLISTED: return 'По ссылке';
                    case Note::VIS_PUBLIC_LISTED: return 'Всем';
                    default: return '(не задано)';
                }
            }
        ],
        [
            'attribute' => 'user.name',
            'label' => 'Имя пользователя',
            'value' => function ($model, $key, $index, $column) {
                return isset($model->user) ? mb_strimwidth($model->user->name, 0, 20, '...', 'UTF-8') : '(не задано)';
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d-m-Y']
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['note/view', 'id' => $model->id]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['note/update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['note/delete', 'id' => $model->id], ['data-method' => 'post']);
                }
            ]
        ]
    ]
]);

?>
