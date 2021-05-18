<?php

namespace qviox\mentor\models\scores;


use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\db\Exception;
use yii\base\Model;
use yii\web\UploadedFile;
class TaskInputFile extends  Model
{
    public $TaskInputFiles;
    public $taskInputId;
    public $error=false;
    public function rules()
    {
        return [
            [['TaskInputFiles'], 'file', 'skipOnEmpty' => false,  'maxFiles' => 5],
        ];
    }

    public function upload()
    {

        $this->TaskInputFiles = UploadedFile::getInstances($this, 'TaskInputFiles['.$this->taskInputId.']');
        if($this->validate())
            foreach($this->TaskInputFiles as $file){
                $path = Yii::$app->getModule('mentor')->uploads . '/tasks/';
                $fileurl=($path[0]=='/')?substr($path,1):$path;
                $path=Yii::getAlias('@'.$path);

                if (!is_dir($path)) {
                    BaseFileHelper::createDirectory($path, 0777, true);
                }
                $filename=Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $filepath=$path .$filename;
                $fileurl.=$filename;
                if($file->saveAs($filepath)){
                        $paths[]= $fileurl;
                    }
            }
        else{
            throw new Exception(serialize($this->errors));
        }
            return implode(';',$paths);

    }

}