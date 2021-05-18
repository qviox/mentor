<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SkillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список команд';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <p>  <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Добавить команду</h2>',
            'toggleButton' => [
                'label' => 'Добавить команду',
                'tag' => 'button',
                'class' => 'btn btn-success',
            ],
        ]);
        ?></p>
    <?= $this->render('_form', [
        'model' => $model,
        'mentors' => $mentors
    ]) ?>
    <?php \yii\bootstrap\Modal::end(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:ntext',
            [
                'attribute' => 'mentor_id',
                'label' => 'Ментор',
                'filter' => false,
                'value' => function ($model) {
                    if ($model->mentor) {
                        return $model->mentor->email;
                    }

                    return null;
                }
            ],
            'teamPoints',
            [
                'attribute' => 'userPoints',
                'value' => function ($model) {
                    return $model->getUserPoints();
                }
            ],
            [
                'attribute' => 'total_points',
                'value' => function ($model) {
                    return $model->total_points;
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',

            ],
        ],
    ]); ?>


</div>
