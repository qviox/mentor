<?php

namespace qviox\mentor\models\scores;


use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

class TaskInputValue extends \yii\db\ActiveRecord
{
    public $file;
    public $maxCountFiles=15;
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
            [['task_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskInput::class, 'targetAttribute' => ['task_input_id' => 'id']],

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
    public function loadFile($arrayJsonBase64){

            $pathUrl = Yii::$app->getModule('mentor')->uploads . '/tasks/'.$this->taskInput->task_id.'/';
            $pathDir =Yii::getAlias('@'.$pathUrl);

            try{
                $files=json_decode($arrayJsonBase64);
                if(count($files)>$this->maxCountFiles)
                    throw new Exception('too many files (>'.$this->maxCountFiles.')');
                foreach($files as $file){

                    $f = str_replace(' ', '+ ', $file->data);

                    $data = base64_decode(explode(',', $f)[1]);

                    $fileName = Yii::$app->security->generateRandomString() . '.' . $file->ext;

                    if (!is_dir($pathDir)) {
                        BaseFileHelper::createDirectory($pathDir, 0777, true);
                    }

                    $filepath=$pathDir. $fileName;
                    $fileUrl='/'.$pathUrl.$fileName;

                    if(!file_put_contents( $filepath, $data))
                        throw new Exception('cant load file');
                    $filesUrls[] = $fileUrl;
                    $filesPaths[]=$filepath;
                }

                return ['filesUrls'=>implode(';',$filesUrls),'filesPaths'=>implode(';',$filesPaths)];
            }catch (Exception $e){
                foreach($filesPaths as $p){
                    unlink($p);
                }
                return false;
            }


    }

}