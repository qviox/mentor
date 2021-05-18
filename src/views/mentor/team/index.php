<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SkillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список команд';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:ntext',
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
                'template' => '{update}'
            ],
        ],
    ]); ?>

</div>
