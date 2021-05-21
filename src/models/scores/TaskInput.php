<?php

namespace qviox\mentor\models\scores;

use yii\helpers\Html;
use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;
use yii\db\Exception;
class TaskInput extends \yii\db\ActiveRecord
{
    const TYPE_STRING=1;
    const TYPE_TEXT=2;
    const TYPE_FILE=3;
    const TYPE_BOOL_YES_NO=4;
    const ACCESS_LEVEL_PRIVATE=1;
    const ACCESS_LEVEL_PUBLIC=2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_task_input}}';
    }
    public function rules()
    {
        return [
            [['task_id','type','access_level'], 'integer'],
            [['name','title','description'], 'string', 'max' => 255],
            [['name','title','description','type','task_id'], 'required'],
            ['name', 'validateUniqueName'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название поля (Англ., без пробелов)',
            'type' => 'Тип поля',
            'access_level' => 'Уровень доступа',
            'title' => 'Заголовок',
            'description' => 'Описание',
        ];
    }
    public static function typeLabels()
    {
        return [
            self::TYPE_STRING => 'Строка',
            self::TYPE_TEXT => 'Текст',
            self::TYPE_FILE => 'Файл',
            self::TYPE_BOOL_YES_NO => 'Да/Нет',
        ];
    }
    public static function accessLevelLabels()
    {
        return [
            self::ACCESS_LEVEL_PRIVATE => 'Приватный',
            self::ACCESS_LEVEL_PUBLIC => 'Общедоступный',
        ];
    }
    public function getTask(){
            return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
    public function getFormInput($value=null,$inputOptions=['class'=>'form-control'],$label=true,$labelOptions=['class'=>'control-label']){
        $input=($label)?Html::label($this->title, $this->name,$labelOptions):'';
        $input.=Html::hiddenInput("TaskInputCode[$this->id]", $this->getCode());
        $name='TaskInput['.$this->id.']';
        switch ($this->type){
            case self::TYPE_STRING:
                $input.= Html::textInput( $name, $value,$inputOptions);
                break;
            case self::TYPE_TEXT:
                $input.= Html::textarea( $name, $value,$inputOptions);
                break;
            case self::TYPE_FILE:
                $inputOptions['multiple']=true;
                $input.= Html::fileInput( 'TaskInputFile[TaskInputFiles]'.'['.$this->id.'][]', null,$inputOptions);
                break;

            case self::TYPE_BOOL_YES_NO:
//                $input.= Html::fileInput( 'TaskInputFile[TaskInputFiles]'.'['.$this->id.'][]', null,$inputOptions);
                break;
        }
        return $input;
    }
    public function getCode(){
        return md5($this->id.Yii::$app->user->id.'qwesdsaqe');
    }



    public function validateUniqueName($attribute, $params)
    {

        if (in_array($this->$attribute, TaskInput::find()->select('name')->where(['task_id'=>$this->task_id])->column())) {
            $this->addError($attribute, 'Название поля должно быть уникальным для этого задания".');
        }
    }
    public function validateTaskInputValue($value){
        return true;
    }
    public function saveTaskInputValue($value){
        if(!$this->validateTaskInputValue($value))
            return false;
        $taskInputValue=new TaskInputValue();

        $taskInputValue->task_input_id=$this->id;
        $taskInputValue->user_id=Yii::$app->user->id;
        if($taskInputValue->taskInput->type==TaskInput::TYPE_FILE){
            $filesPathInfo=$taskInputValue->loadFile($value);
            $taskInputValue->val=$filesPathInfo['filesUrls'];

        }else
            $taskInputValue->val=$value;
        if($taskInputValue->save()){
            return  $filesPathInfo['filesPaths']??$taskInputValue->val;
        }

        else
            throw new Exception(serialize($taskInputValue->errors));
    }
    public function getTaskInputValueByUser($userId){
           return TaskInputValue::find()->where(['user_id'=>$userId,'task_input_id'=>$this->id])->one();
    }
    public function getTaskInputValue(){
        return $this->hasOne(TaskInputValue::class, ['task_input_id' => 'id']);
    }
}