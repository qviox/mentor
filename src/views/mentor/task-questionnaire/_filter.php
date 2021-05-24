<?php
$task_inputs=$searchModel->task_inputs;
return function ($model, $key, $index, $grid) use ($task_inputs){
    if($index===0){
        $form='<tr>';
        foreach($model as $inputName=>$val){
            switch ($task_inputs[$inputName]->type){
                case \qviox\mentor\models\scores\TaskInput::TYPE_STRING:
                case \qviox\mentor\models\scores\TaskInput::TYPE_TEXT:
                default:
                $form.='<td><input class="task_questionnare_input form-control" value="'.$_GET[$inputName].'" name="'.$inputName.'" type="text"></td>';
                break;
                case \qviox\mentor\models\scores\TaskInput::TYPE_BOOL_YES_NO:
                $form.='<td>'.\yii\helpers\Html::dropDownList($inputName,$_GET[$inputName],[1=>'Да',0=>'Нет'],['prompt'=>'-','class'=>'form-control']).'</td>';
                break;
            }
          }
        $form.='</tr>';
        return $form;
    }
}
?>
