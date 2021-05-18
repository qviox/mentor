<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user \app\models\User */
/* @var $model app\models\scores\UserTask */
/* @var $form yii\widgets\ActiveForm */
/* @var $availableTasks array */

$availableTasks = $model->isNewRecord ? $availableTasks : [$model->task_id => $model->task->name];
?>
    <div class="user-task-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'task_id')->dropDownList($availableTasks, ['prompt' => 'Укажите задание', 'disabled' => !$model->isNewRecord ? true : false])->label('Задание') ?>

        <?= $form->field($model, 'point')->textInput(['type' => 'number', 'default' => 0, 'min' => 0, 'max' => 5000]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>