<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\scores\Team */

$this->title = 'Изменить команду: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="team-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#members" data-toggle="tab" aria-expanded="true">Участники</a></li>
            <li class=""><a href="#tasks" data-toggle="tab" aria-expanded="false">Задания и баллы</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="members">
                <?= GridView::widget([
                    'dataProvider' => $userDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Участник',
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                return $model->email;
                            }
                        ],
                        'userPoints',
                        ['class' => 'yii\grid\ActionColumn',
                            'controller' => 'user-team',
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['participants/update', 'id' => $model->id, '#' => 'tasks']);
                                }
                            ]
                        ]
                        ]
                    ]);
                ?>
            </div>

            <div class="tab-pane" id="tasks">
                <p>
                    <?= Html::a('Добавить задание в рейтинг', ['team-task/create', 'teamId' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $taskDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Задание',
                            'attribute' => 'task_id',
                            'value' => function($model) {
                                return $model->task->name;
                            }
                        ],
                        'point',
                        ['class' => 'yii\grid\ActionColumn',
                            'controller' => 'team-task',
                            'template' => '{update}'
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs("
    if ( document.location.hash)
    {
        $('.nav-tabs a[href=\"' + document.location.hash + '\"]').tab ('show');
    }");
?>