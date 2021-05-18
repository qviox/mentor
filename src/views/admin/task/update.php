<?php

/* @var $this yii\web\View */
/* @var $model app\models\scores\Task */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Изменить задание: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="task-update">


    <?= $this->render('_form', ['model' => $model]); ?>

    <p>  <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Добавить поле</h2>',
            'toggleButton' => [
                'label' => 'Добавить поле',
                'tag' => 'button',
                'class' => 'btn btn-success',
            ],
        ]);
        ?></p>
    <?= $this->render('/admin/task-input/_form', [
        'model' => $task_form_input,
    ]) ?>
    <?php \yii\bootstrap\Modal::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title:ntext',
            [
                'attribute' => 'type',
                'filter' => false,
                'value' => function ($model) {
                    return $model->typeLabels()[$model->type];
                }
            ],
            'name:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} ',
                'buttons'=>[
                    'update' => function ($url, $model, $key) {
                        return   Html::a('', Url::to(['admin/task-input/update','id'=>$model->id]), ['class' => 'glyphicon glyphicon-pencil']) ;
                    },
                    'delete' => function ($url, $model, $key) {
                        return   Html::a('', Url::to(['admin/task-input/delete','id'=>$model->id]), ['class' => 'glyphicon glyphicon-pencil']) ;
                    }
                ]

            ]

        ],
    ]); ?>
</div>
