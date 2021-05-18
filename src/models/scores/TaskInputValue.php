<?php

namespace qviox\mentor\models\scores;


use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

class TaskInputValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_task_input_value}}';
    }
    public function rules()
    {
        return [
            [['user_id','task_input_id','val'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            ['task_input_id', 'validateFilledValue'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

        ];
    }

    public function validateFilledValue($attribute, $params)
    {
        if (self::findOne(['user_id'=>Yii::$app->user->id,'task_input_id'=>$this->$attribute])) {
            $this->addError($attribute, 'Поле['.$this->$attribute.'] уже заполнено');
        }
    }

    public function getTaskInput(){
        return $this->hasOne(TaskInput::class, ['id' => 'task_input_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getUserTask()
    {
        return $this->hasOne(UserTask::class, ['user_id' => 'user_id']);
    }

}