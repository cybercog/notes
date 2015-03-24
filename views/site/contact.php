<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';
?>
<h1 class="text-center"><?= $this->title ?></h1>

<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
    <div class="alert alert-success">Сообщение отправлено.</div>
<?php else: ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <p>Вы можете связаться с нами с помощью формы ниже.</p>

            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => 60]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6, 'maxlength' => 5000]) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-xs-5 col-sm-3">{image}</div><div class="col-xs-7 col-sm-9">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
<?php endif ?>
