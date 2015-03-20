<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($note, 'name') ?>
    <?= $form->field($note, 'description') ?>
    <?= Html::submitButton($note->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => 'btn btn-default']) ?>
<?php ActiveForm::end() ?>
