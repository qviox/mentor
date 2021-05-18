<?php

namespace qviox\mentor\models\scores;

use Yii;
use yii\helpers\ArrayHelper;


class TaskFormInput
{
    public static function getTaskInputs($task_id){
        $task=Task::findOne($task_id);
        if(!$task)
            return false;


    }
    public static function saveTaskInputsValue($items){

    }

}