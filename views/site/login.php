<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
?>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?= Html::a('Восстановление пароля', ['site/request-password-reset']) ?>.

            <div class="form-group">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
