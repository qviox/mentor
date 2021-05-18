<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\SkillUserPoint */
/* @var $user app\models\User */
/* @var $availableTasks array */

$this->title = 'Добавить задание участнику: ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => 'Участники', 'url' => ['participants/index']];
$this->params['breadcrumbs'][] = ['label' => $user->email, 'url' => ['participants/update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Добавить';
?>

<div class="user-task-update">
    <?= $this->render('_form', [
        'user' => $user,
        'model' => $model,
        'availableTasks' => $availableTasks
    ]); ?>
</div>
