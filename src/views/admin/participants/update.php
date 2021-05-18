<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $skillUserProvider yii\data\ActiveDataProvider */
/* @var $teams array */
/* @var $team \app\models\scores\Team */

$this->title = 'Участник: ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Участник', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->email;
?>
<div class="user-update">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#skills" data-toggle="tab" aria-expanded="true">Навыки и баллы</a></li>
            <li class=""><a href="#tasks" data-toggle="tab" aria-expanded="false">Задания и баллы</a></li>
            <li class=""><a href="#team" data-toggle="tab" aria-expanded="false">Команда</a></li>
            <li class=""><a href="#base" data-toggle="tab" aria-expanded="false">Контакты</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="skills">
                <p>
                    <?= Html::a('Добавить навык', ['admin/skill-user/create', 'userId' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $skillUserProvider,
                    'filterModel' => $skillSearchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Навык',
                            'attribute' => 'skill_id',
                            'filter' => $skills,
                            'value' => function($model) {
                                return $model->skill->name;
                            }
                        ],
                        [
                            'label' => 'Ассесмент-сессия',
                            'attribute' => 'session_id',
                            'filter' => $sessions,
                            'value' => function($model) {
                                return $model->session->name;
                            }
                        ],
                        'point',
                        ['class' => 'yii\grid\ActionColumn',
                            'controller' => 'skill-user',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['admin/skill-user/update', 'skill_id' => $model->skill_id,'user_id'=>$model->user_id,'session_id'=>$model->session_id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',['admin/skill-user/delete', 'skill_id' => $model->skill_id,'user_id'=>$model->user_id,'session_id'=>$model->session_id],['data-method'=>"post"]);
                                }
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>

            <div class="tab-pane" id="tasks">
                <p>
                    <?= Html::a('Добавить задание в рейтинг', ['admin/user-task/create', 'userId' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $taskUserProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Задание',
                            'attribute' => 'task_id',
                            'filter' => $skills,
                            'value' => function($model) {
                                return $model->task->name;
                            }
                        ],
                        'point',
                        ['class' => 'yii\grid\ActionColumn',
                            'controller' => 'user-task',
                            'template' => '{update} {delete}',
                        ]
                    ]
                ]);
                ?>
            </div>

            <div class="tab-pane skin-green" id="team">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => !$team->user_id ? ['admin/user-team/create'] : ['admin/user-team/update', 'userId' => $model->id]
                ]); ?>
                    <?= $form->field($team, 'user_id')->hiddenInput(['value' => $model->id])->label(false);?>
                    <?= $form->field($team, 'team_id')->dropDownList($teams, ['prompt' => 'Укажите команду'])->label('Команда') ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="tab-pane skin-green" id="base">

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
