<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">МТ</span><span class="logo-lg">' . 'Менторство' . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <?= Html::a(
                        'Выход',
                        ['/admin/default/logout'],
                        ['data-method' => 'post', 'class' => '']
                    ) ?>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
