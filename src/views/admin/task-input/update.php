<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\scores\Task */

$this->title = 'Изменить поле: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->task->name, 'url' => Url::to(['admin/task/update','id'=>$model->task->id])];
$this->params['breadcrumbs'][] = ['label' => 'Поле('.$model->title.')', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

       <?=$this->render('_form',[$form,'model'=>$model])?>

