<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\UserTask */
/* @var $team \app\models\scores\Team */

$this->title = 'Изменить задание у команды ' . $team->name;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['team/index']];
$this->params['breadcrumbs'][] = ['label' => $team->name, 'url' => ['update', 'id' => $team ->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="team-task-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
