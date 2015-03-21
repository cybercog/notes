<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($note, 'name') ?>
            <?= $form->field($note, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($note, 'public')->checkbox(['labelOptions' => ['checked' => true]]) ?>
            <?= Html::submitButton($note->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => 'btn btn-default']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
