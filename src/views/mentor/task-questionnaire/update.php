<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\scores\TaskQuestionnaire */

$this->title = $task->name .' '. $model->id;
$this->params['breadcrumbs'][] = ['label' => $task->name, 'url' => ['index', 'taskId' => $task->id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="task-questionnaire-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'user' => $user,
        'task'=>$task,
        'userTask'=>$userTask
    ]) ?>
</div>
