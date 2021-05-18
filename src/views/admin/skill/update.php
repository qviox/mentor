<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\Skill */

$this->title = 'Изменить навык: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Навыки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="skill-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
