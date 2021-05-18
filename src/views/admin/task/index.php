<?php

use qviox\mentor\components\enums\TaskType;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SkillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заданий';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-index">

    <p>  <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Добавить задание</h2>',
            'toggleButton' => [
                'label' => 'Добавить задание',
                'tag' => 'button',
                'class' => 'btn btn-success',
            ],
        ]);
        ?></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php \yii\bootstrap\Modal::end(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name:ntext',
            [
                'attribute' => 'type',
                'filter' => TaskType::map(),
                'value' => function($model) {
                    return TaskType::label($model->type);
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',

            ]
        ],
    ]); ?>


</div>

