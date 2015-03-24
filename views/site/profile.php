<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;

$this->title = 'Изменение профиля';

if (Yii::$app->session->hasFlash('profileChanged')) {
    echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => 'Профиль изменён.']);
}
?>
<h1 class="text-center">Изменение профиля</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($profileModel, 'email') ?>
            <?= $form->field($profileModel, 'name') ?>
            <?= $form->field($profileModel, 'password')->passwordInput()->hint('Оставьте поле пустым если не хотите его менять') ?>

            <div class="form-group">
                <?= Html::submitInput('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

