<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
?>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']) ?>
            <?= $form->field($model, 'email')->hint('На этот адрес будет отправлена ссылка для сброса пароля.') ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
