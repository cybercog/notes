<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php
        NavBar::begin([
            'brandLabel' => 'Заметки',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar navbar-inverse']
        ]);

        $navItems = [
            ['label' => 'О нас', 'url' => ['/site/about']],
            ['label' => 'Обратная связь', 'url' => ['/site/contact']]
        ];
        if (Yii::$app->user->isGuest) {
            $navItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
            $navItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        } else {
            if (Yii::$app->authManager->getAssignment('admin', Yii::$app->user->getId())) {
                $navItems[] = ['label' => 'Панель администрирования', 'url' => ['/admin/index']];
            }
            $navItems[] = ['label' => 'Профиль (' . Yii::$app->user->identity->name . ')', 'items' => [
                ['label' => 'Изменить', 'url' => ['/site/profile']],
                ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]];
        }
        echo Nav::widget(['options' => ['class' => 'navbar-nav navbar-right'], 'items' => $navItems]);

        NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
        <?= $content ?>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
