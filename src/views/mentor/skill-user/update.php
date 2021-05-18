<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\SkillUserPoint */
/* @var $user app\models\User */

$this->title = 'Изменить навык у участника ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => 'Навыки', 'url' => ['participants/index']];
$this->params['breadcrumbs'][] = ['label' => $user->name, 'url' => ['update', 'id' => $user ->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="skill-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
