<?php

use qviox\mentor\components\enums\TaskType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\scores\Task */
/* @var $form yii\widgets\ActiveForm */
$task=\qviox\mentor\models\scores\Task::findOne(2);
$model=new \qviox\mentor\models\scores\TaskInputValue();

?>
<div class="task-form">
    <?php $form = ActiveForm::begin(['action'=>Url::to(['api/ajax/save-task-data']),'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=$task->getFormInputByName('address')?>
    <?=$task->getFormInputByName('project_info')?>
    <?=$task->getFormInputByName('file_pdf')?>
    <?=$task->getFormInputByName('file_doc')?>
    <?=$task->getFormInputByName('project_docs')?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>