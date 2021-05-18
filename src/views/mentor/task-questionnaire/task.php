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
//            [
//                'label' => 'Баллы',
//                'value' => function ($model) {
//                    if ($model->userTask) {
//                        return $model->userTask->point;
//                    }
//                    return null;
//                }
//            ],
            [
                'attribute' => 'email',

            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ]
        ]
    ]); ?>

</div>
