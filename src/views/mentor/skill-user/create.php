<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\SkillUserPoint */
/* @var $user app\models\User */
/* @var $availableSessions array */

$this->title = 'Добавить навык участнику: ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => 'Участники', 'url' => ['participants/index']];
$this->params['breadcrumbs'][] = ['label' => $user->email, 'url' => ['participants/update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Добавить';
?>

<div class="skill-user-update">
    <?= $this->render('_form', [
        'user' => $user,
        'model' => $model,
        'availableSessions' => $availableSessions
    ]); ?>
</div>
