<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\scores\TaskQuestionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-questionnaire-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php foreach($task->taskInputs as $input):?>
        <?php if($input->type!=\qviox\mentor\models\scores\TaskInput::TYPE_FILE):?>
            <?php $taskInputValue=$input->getTaskInputValueByUser($user->id);?>
    <div class="form-group">
        <textarea  class="form-control" name="TaskInput[<?=$input->id?>]"><?=$taskInputValue->val?></textarea>
    </div>
        <?php endif;?>
    <?php endforeach;?>

    <?= $form->field($userTask, 'point')->textInput(['type' => 'number', 'default' => 0, 'min' => 1, 'max' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
