<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

$this->title = 'Заметки пользователей';
?>
<?= $this->render('/_subnav', ['cur' => 'all']) ?>

<div class="nav-tabs-body">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php foreach ($notes as $note): ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 inline">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php if (Yii::$app->user->can('updateNote', ['note' => $note])): ?>
                                    <div class="btn-group pull-right">
                                        <?= Html::a('', ['note/update', 'id' => $note->id], ['class' => 'glyphicon glyphicon-cog btn btn-info btn-xs']) ?>
                                        <?= Html::a('', ['note/delete', 'id' => $note->id], ['class' => 'glyphicon glyphicon-remove btn btn-danger btn-xs', 'data-method' => 'delete']) ?>
                                    </div>
                                <?php endif ?>
                                <?= Html::a(mb_strimwidth(Html::encode($note->name), 0, 18, '...', 'UTF-8'), ['note/view', 'id' => $note->id]) ?>
                            </div>
                            <div class="panel-body note-text-preview break-word"><?= mb_strimwidth(Html::encode($note->description), 0, 100, '...', 'UTF-8') ?></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="text-center">
                <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'pagination pagination-sm']]) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Поиск
                            </a>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php $form = ActiveForm::begin(['method' => 'GET']) ?>
                            <?= $form->field($noteSearch, 'name') ?>
                            <?= $form->field($noteSearch, 'description') ?>
                            <?= Html::submitInput('Поиск', ['class' => 'btn btn-primary']) ?>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <div class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Сортировка
                            </a>
                        </div>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="list-group">
                            <?= $sort->link('name', ['class' => 'list-group-item']) ?>
                            <?= $sort->link('description', ['class' => 'list-group-item']) ?>
                            <?= $sort->link('created_at', ['class' => 'list-group-item']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
