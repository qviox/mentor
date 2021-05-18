<?php

use qviox\mentor\components\enums\TaskType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\scores\Task */
/* @var $form yii\widgets\ActiveForm */

?>
    <div class="task-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'type')
            ->dropDownList(TaskType::map(), ['prompt' => 'Укажите тип задания', 'disabled' => !$model->isNewRecord ? true : false])
            ->label('Тип задания') ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>