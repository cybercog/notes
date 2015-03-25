<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->title = ($cur === 'all') ? 'Заметки пользователей' : 'Ваши заметки';
?>
<?= Html::a('Создать заметку', ['note/create'], ['class' => 'btn btn-primary pull-right']) ?>
<ul class="nav nav-tabs">
    <?php if (!Yii::$app->user->isGuest): ?>
        <li role="presentation"<?= $cur === 'own' ? 'class="active"' : '' ?>><?= Html::a('Мои заметки', ['site/index']) ?></li>
    <?php endif ?>
    <li role="presentation"<?= $cur === 'all' ? 'class="active"' : '' ?>><?= Html::a('Все заметки', ['note/index']) ?></li>
</ul>

<?php Pjax::begin(['timeout' => 5000]) ?>
    <div class="nav-tabs-body">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <?php foreach ($notes as $note): ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 inline">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php if (($cur === 'all' && Yii::$app->user->can('updateNote', ['note' => $note])) || $cur === 'own'): ?>
                                        <div class="btn-group pull-right">
                                            <?= Html::a('', ['note/update', 'id' => $note->id], ['class' => 'glyphicon glyphicon-cog btn btn-info btn-xs']) ?>
                                            <?= Html::a('', ['note/delete', 'id' => $note->id], ['class' => 'glyphicon glyphicon-remove btn btn-danger btn-xs', 'data-method' => 'post']) ?>
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
                                <?php $form = ActiveForm::begin(['method' => 'GET','options' => ['data-pjax' => '1']]) ?>
                                    <?php if ($cur === 'all'): ?>
                                        <?= $form->field($noteSearch, 'user.name') ?>
                                    <?php endif ?>
                                    <?= $form->field($noteSearch, 'name') ?>
                                    <?= $form->field($noteSearch, 'description')->textarea(['rows' => 2]) ?>

                                    <div class="form-group">
                                        <?= Html::submitInput('Поиск', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Сбросить', [''], ['class' => 'btn btn-info']) ?>
                                    </div>
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

                    <?php if ($cur === 'own'): ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <div class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Статистика
                                    </a>
                                </div>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <ul class="list-group">
                                    <li class="list-group-item break-word">За день создано <?= $notesCountDay ?> заметок.</li>
                                    <li class="list-group-item break-word">За месяц создано <?= $notesCountMonth ?> заметок.</li>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?php Pjax::end() ?>
