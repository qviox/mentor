<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Участники';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <?php
    $columns = [
        //  ['class' => 'yii\grid\SerialColumn'],
        'id',
        'email:email',
        [
            'attribute' => 'team_id',
            'label' => 'Команда',
            'value' => function ($model) {

                if ($model->team) {
                    return $model->team->name;
                }
                return null;
            }
        ],
        [
            'attribute' => 'type',
            'filter' => false,
            'value' => function ($model) {
                return $model->getTypeLabel();
            }
        ],
        'userPoints',
        [
            'attribute' => 'created_at',
            'filter' => false
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{update}'
        ],
    ];

    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
        'exportConfig' => [
            \kartik\export\ExportMenu::FORMAT_TEXT => false,
            \kartik\export\ExportMenu::FORMAT_HTML => false,
            \kartik\export\ExportMenu::FORMAT_EXCEL => false,
            \kartik\export\ExportMenu::FORMAT_PDF =>  false,
            \kartik\export\ExportMenu::FORMAT_CSV =>  false
        ]
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
</div>
