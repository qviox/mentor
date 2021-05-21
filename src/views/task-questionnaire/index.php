<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaskQuestionnaireSearch */
/* @var $task \app\models\scores\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $task->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-questionnaire-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Баллы',
                'value' => function ($model) {
                    if ($model->userTask) {
                        return $model->userTask->point;
                    }
                    return null;
                }
            ],
            [
                'attribute' => 'email',
                'label' => 'Email участника',
                'value' => function ($model) {
                    return $model->user->email;
                }
            ],
            [
                'attribute' => 'file_path',
                'filter' => false,
                'format' => 'raw',
                'label' => 'Файл',
                'value' => function ($model) {
                    return Html::a("Скачать", $model->file_path);
                }
            ],
            'created_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>


</div>
