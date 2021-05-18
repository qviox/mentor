<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\SkillUserPoint */
/* @var $team \app\models\scores\Team */
/* @var $availableTasks array */

$this->title = 'Добавить задание команде: ' . $team->name;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['team/index']];
$this->params['breadcrumbs'][] = ['label' => $team->name, 'url' => ['team/update', 'id' => $team->id]];
$this->params['breadcrumbs'][] = 'Добавить';
?>

<div class="team-task-update">
    <?= $this->render('_form', [
        'team' => $team,
        'model' => $model,
        'availableTasks' => $availableTasks
    ]); ?>
</div>
