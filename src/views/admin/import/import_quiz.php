<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChatBotQuestionFiles */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Импорт Квиз';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="chat-bot-question-files-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>



    <label>Загрузить файл результатов квиза</label>
    <?= Html::fileInput('import') ?>
    <br>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
