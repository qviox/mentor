<?php

use qviox\mentor\components\enums\TaskType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\scores\Task */
/* @var $form yii\widgets\ActiveForm */

?>
    <div class="task-form">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>(!$model->isNewRecord)?Url::to(['admin/task-input/update','id'=>$model->id]):Url::to(['admin/task-input/create'])]); ?>

        <?= $form->field($model, 'name')->textInput(['disabled' => !$model->isNewRecord ? true : false]) ?>
        <?= $form->field($model, 'task_id')->hiddenInput(['value' => $model->task_id])->label(false);?>
        <?= $form->field($model, 'type')
            ->dropDownList(\qviox\mentor\models\scores\TaskInput::typeLabels(), ['prompt' => 'Укажите тип поля','disabled' => !$model->isNewRecord ? true : false])
            ->label('Тип поля') ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'description')->textArea(['rows'=>4]) ?>
        <?= $form->field($model, 'default_value')->textInput() ?>
        <?= $form->field($model, 'access_level')
            ->dropDownList(\qviox\mentor\models\scores\TaskInput::accessLevelLabels())
            ->label('Уровень доступа') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>