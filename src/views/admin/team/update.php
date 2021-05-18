<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
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
            <li class="active"><a href="#base" data-toggle="tab" aria-expanded="true">Основные настройки</a></li>
            <li class=""><a href="#members" data-toggle="tab" aria-expanded="false">Участники</a></li>
            <li class=""><a href="#tasks" data-toggle="tab" aria-expanded="false">Задания и баллы</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane skin-green active" id="base">
                <?= $this->render('_form', ['model' => $model, 'mentors' => $mentors]); ?>
            </div>
            <div class="tab-pane" id="members">
                <p>  <?php
                    \yii\bootstrap\Modal::begin([
                        'header' => '<h2>Добавить участника</h2>',
                        'toggleButton' => [
                            'label' => 'Добавить участника',
                            'tag' => 'button',
                            'class' => 'btn btn-success',
                        ],
                    ]);
                    ?></p>
                <?= $this->render('_add-user-form', [
                    'team' => $model,
                ]) ?>
                <?php \yii\bootstrap\Modal::end(); ?>
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
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['admin/participants/update', 'id' => $model->id, '#' => 'team']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',['admin/user-team/delete', 'user_id' => $model->id, '#' => 'team']);
                                }
                            ]
                        ]
                        ]
                    ]);
                ?>
            </div>

            <div class="tab-pane" id="tasks">
                <p>
                    <?= Html::a('Добавить задание в рейтинг', ['admin/team-task/create', 'teamId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                            'template' => '{update} {delete}',
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