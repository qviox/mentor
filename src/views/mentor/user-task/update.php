<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\UserTask */
/* @var $user app\models\User */

$this->title = 'Изменить задание у участника ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['participants/index']];
$this->params['breadcrumbs'][] = ['label' => $user->name, 'url' => ['update', 'id' => $user ->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="user-task-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
