<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\SkillSession */

$this->title = 'Изменить ассесмент-сессию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сессии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="skill-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
