<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($comment, 'message')->textarea(['maxlength' => 255, 'rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($comment->isNewRecord ? 'Отправить' : 'Изменить', ['class' => 'btn ' . ($comment->isNewRecord ? 'btn-info' : 'btn-success')]) ?>
    </div>
<?php ActiveForm::end() ?>
