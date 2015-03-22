<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
