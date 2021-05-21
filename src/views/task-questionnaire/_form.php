<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\scores\TaskQuestionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-questionnaire-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'point')->textInput(['type' => 'number', 'default' => 0, 'min' => 1, 'max' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
