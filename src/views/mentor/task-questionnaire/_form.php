<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use qviox\mentor\models\scores\TaskInput;
/* @var $this yii\web\View */
/* @var $model app\models\scores\TaskQuestionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-questionnaire-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php foreach($task->taskInputs as $input):?>
        <?php $taskInputValue = $input->getTaskInputValueByUser($user->id); ?>
     <?php if($input->type==TaskInput::TYPE_STRING || $input->type==TaskInput::TYPE_TEXT):?>
            <div class="form-group">
            <textarea rows="5"  class="form-control" name="TaskInput[<?=$input->id?>]"><?=$taskInputValue->val?></textarea>
             </div>
     <?php endif;?>

    <?php if($input->type==TaskInput::TYPE_BOOL_YES_NO):?>
        <div class="form-group">
            <?=Html::dropDownList("TaskInput[$input->id]",$taskInputValue->val,[1=>'Да',0=>'Нет'],['class'=>"form-control"])?>
        </div>
    <?php endif;?>

        <?php ?>
    <?php endforeach;?>

    <?= $form->field($userTask, 'point')->textInput(['type' => 'number', 'default' => 0, 'min' => 1, 'max' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
