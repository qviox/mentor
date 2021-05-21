<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CompetitionQuestionnaireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анкеты Конкурсного отбора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-questionnaire-index">


    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'fio',
            'email',
            'phone',
            [
                'attribute' => 'gender',
                'format' => 'raw',
                'value' => function ($model) {

                    if ($model->gender == 1) return 'М'; else return 'Ж';
                }
            ],
            'age',
            'region',
            'education',
            'work',
            'work_experience',
            'experience',
            'member_voluntary',
            'professional_qualities',
            'leader_social_change',
            'expectations',
            'created_at',
        ],
        'exportConfig' => [
            \kartik\export\ExportMenu::FORMAT_TEXT => false,
            \kartik\export\ExportMenu::FORMAT_HTML => false,
            \kartik\export\ExportMenu::FORMAT_EXCEL => false,
            \kartik\export\ExportMenu::FORMAT_PDF => false,
            \kartik\export\ExportMenu::FORMAT_CSV => false
        ],


    ]);
    ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fio',
            'email',
            'created_at',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
