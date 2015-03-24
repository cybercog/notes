<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменение пользователя';
?>
<h1 class="text-center"><?= $this->title ?></h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($userEdit, 'name')->textInput(['maxlength' => 60]) ?>
            <?= $form->field($userEdit, 'email')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($userEdit, 'password')->passwordInput(['maxlength' => 255])->hint('Оставьте поле пустым если не хотите его менять') ?>
            <?= $form->field($userEdit, 'role')->dropDownList(['user' => 'Пользователь', 'admin' => 'Администратор']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
