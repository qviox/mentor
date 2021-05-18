<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaskQuestionnaireSearch */
/* @var $task \app\models\scores\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $task->name;
$this->params['breadcrumbs'][] = $this->title;
$columns=[
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'id',

    ],
    [
        'attribute' => 'email',
    ],


];
foreach($task_inputs as $task_input){
    $arr=[
        'attribute'=>$task_input->name,
        'label'=>$task_input->title,
    ];
    if($task_input->type==\qviox\mentor\models\scores\TaskInput::TYPE_FILE || $task_input->type==\qviox\mentor\models\scores\TaskInput::TYPE_FILES){
        $arr['format'] = 'raw';
        $arr['value']=function($model, $key, $index, $column){
            if($model[$column->attribute]){
                $files=[];
                $i=1;
                foreach(explode(';',$model[$column->attribute]) as $fileurl){
                    $files[]=Html::a("Файл $i",'/'.$fileurl);
                    $i++;
                }
                $files=implode(' | ',$files);
                return $files;
            }
            return null;
        };

    }
    array_push($columns,$arr);
}
array_push($columns,
    ['class' => 'yii\grid\ActionColumn',
    'template' => '{update}',
        'buttons'=>[
            'update' => function ($url, $model, $key) {

                return   Html::a('', Url::to(['task-questionnaire/update','taskId'=>Yii::$app->request->get('taskId'),'userId'=>$model['id']]), ['class' => 'glyphicon glyphicon-pencil']) ;
            }
        ]
    ]
);
?>
<div class="task-questionnaire-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>

</div>
