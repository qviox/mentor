<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php
    $columns = [
        //  ['class' => 'yii\grid\SerialColumn'],
        'id',
        'email:email',
        [
            'attribute' => 'role',
            'label'=>'Роль',
            'filter' => kartik\select2\Select2::widget([
                'data' => \yii\helpers\ArrayHelper::map(\qviox\mentor\models\rbac\URole::find()->select(['id', 'label'])->asArray()->all(), 'id', 'label'),
                'options' => ['placeholder' => 'Выберите роль'],
                'model' => $searchModel,
                'attribute' => 'role',

                'pluginOptions' => [
                    'allowClear' => true
                ],

            ]),
            'value' => function ($model) {
                $label=$model->userRole->label;
                return ($label)?$label:'-';
            }
        ],
        [
            'attribute' => 'type',
            'label'=>'Тип',
            'filter' => kartik\select2\Select2::widget([
                'data' => \yii\helpers\ArrayHelper::map(\qviox\mentor\models\UType::find()->select(['id', 'label'])->asArray()->all(), 'id', 'label'),
                'options' => ['placeholder' => 'Выберите тип'],
                'model' => $searchModel,
                'attribute' => 'type',

                'pluginOptions' => [
                    'allowClear' => true
                ],

            ]),
            'value' => function ($model) {
                $label=$model->userType->label;
                return ($label)?$label:'-';
            }
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
