<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($note, 'name')->textInput(['maxlength' => 60]) ?>
            <?= $form->field($note, 'description')->textarea(['rows' => 9, 'maxlength' => 1000]) ?>
            <?= $form->field($note, 'visibility')->dropDownList(Yii::$app->user->isGuest ?
                [1 => 'Видна всем', 'Видна всем, но не отображается в публичном списке'] :
                ['Не видна никому, кроме вас', 'Видна всем', 'Видна всем, но не отображается в публичном списке']
            ) ?>

            <div class="form-group">
                <?= Html::submitButton($note->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => 'btn ' . ($note->isNewRecord ? 'btn-info' : 'btn-success')]) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
