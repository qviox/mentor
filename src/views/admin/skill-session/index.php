<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SkillSessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список ассесмент-сессий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-index">

    <p>  <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Создать ассесмент-сессию</h2>',
            'toggleButton' => [
                'label' => 'Создать ассесмент-сессию',
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
            'name:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',

            ]
        ],
    ]); ?>

</div>
