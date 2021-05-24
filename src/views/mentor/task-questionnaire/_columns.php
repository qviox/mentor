<?php
use yii\helpers\Html;
use yii\helpers\Url;
$columns=[
//    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'user_id',
        'label'=>'ID',

    ],
    [
        'attribute' => 'email',
        'label'=>'Email',
    ],
];

foreach($searchModel->task_inputs as $task_input){

    $arr=[
        'attribute'=>$task_input->name,
        'label'=>$task_input->title,
    ];
    if($task_input->type==\qviox\mentor\models\scores\TaskInput::TYPE_FILE ){
        $arr['format'] = 'raw';
        $arr['value']=function($model, $key, $index, $column){
            if($model[$column->attribute]){

                $files=[];
                $i=1;
                foreach(explode(';',$model[$column->attribute]) as $fileurl){
                    if($fileurl[0]!='/')
                        $fileurl='/'.$fileurl;
                        $files[]=Html::a("Файл $i", $fileurl);
                    $i++;
                }
                $files=implode(' | ',$files);
                return $files;
            }
            return null;
        };

    }
    if($task_input->type==\qviox\mentor\models\scores\TaskInput::TYPE_BOOL_YES_NO ){
        $arr['format'] = 'raw';
        $arr['value']=function($model, $key, $index, $column){
            if(isset($model[$column->attribute])){
                  switch ($model[$column->attribute]) {
                      case 0:
                          return 'Нет';
                          break;
                      case 1:
                          return 'Да';
                          break;
                  }
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

                return   Html::a('', Url::to(['task-questionnaire/update','taskId'=>Yii::$app->request->get('taskId'),'userId'=>$model['user_id']]), ['class' => 'glyphicon glyphicon-pencil']) ;
            }
        ]
    ]
);
return $columns;
?>