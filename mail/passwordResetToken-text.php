<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */
?>
Здравствуйте, <?= Html::encode($user->name) ?>

Перейдите по ссылке ниже, чтобы сбросить пароль:

<?= Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]) ?>
