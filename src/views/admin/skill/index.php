<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SkillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список навыков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-index">

    <p>  <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Создать навык</h2>',
            'toggleButton' => [
                'label' => 'Создать навык',
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
            'sort:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',

            ],
        ],
    ]); ?>


</div>
