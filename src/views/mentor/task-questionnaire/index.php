<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaskQuestionnaireSearch */
/* @var $task \app\models\scores\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $task->name;
$this->params['breadcrumbs'][] = $this->title;

$columns = require __DIR__ . '/_columns.php';
?>
<div class="task-questionnaire-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>

</div>
