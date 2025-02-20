<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => 'Karyawan Recruitment',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin') {
            $menuItems = [
                ['label' => 'Home', 'url' => ['/'], 'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'],
                ['label' => 'Data Karyawan', 'url' => ['/list'], 'active' => Yii::$app->controller->action->id === 'list-biodata'],
            ];
        } elseif (Yii::$app->user->isGuest) {
            $menuItems = [
                ['label' => 'Home', 'url' => ['/'], 'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'],
                ['label' => 'Profile', 'url' => ['/login'], 'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'login'],
            ];
        } else {
            $menuItems = [
                ['label' => 'Home', 'url' => ['/'], 'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'],
                ['label' => 'Profile', 'url' => ['/biodata'], 'active' => Yii::$app->controller->action->id == 'mydata'],
            ];

        }

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup'], 'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'signup'];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
        } else {
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none']
                )
                . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= 'Karyawan App' ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?> | <a href="https://www.linkedin.com/in/imbasri/">Imbasri</a></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
