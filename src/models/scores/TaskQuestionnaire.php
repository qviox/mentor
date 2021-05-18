<?php

namespace qviox\mentor\models\scores;

use qviox\mentor\models\User;
use Yii;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "{{%task_questionnaire}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property string $file_path
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Task $task
 * @property User $user
 */
class TaskQuestionnaire extends \yii\db\ActiveRecord
{
    public $point;
    public $file;
    public $extension;
    public $fileData;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_task_questionnaire}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'file_path'], 'required'],
            [['user_id', 'task_id', 'point'], 'integer'],
            [['created_at', 'updated_at', 'file', 'extension'], 'safe'],
            [['file_path'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'task_id' => 'Задание',
            'file_path' => 'Фаил',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'point' => 'Баллы'
        ];
    }

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function beforeValidate()
    {
        if ($this->file) {
            $file = str_replace(' ', '+ ', $this->file);
            $this->fileData = base64_decode(explode(',', $file)[1]);
            $this->file_path = Yii::$app->security->generateRandomString() . '.' . $this->extension;

            $dir = Yii::getAlias('@uploads') . '/tasks/' . $this->task_id;
            if (!is_dir($dir)) {
                BaseFileHelper::createDirectory($dir, 0777, true);
            }

            $this->file_path = '/uploads/tasks/' . $this->task_id . '/' . $this->file_path;
        }

        return true;
    }

    public function afterFind()
    {
        $this->point = $this->userTask->point ?? 0;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\base\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->point) {
            $userTask = $this->userTask ?? new UserTask();
            $userTask->user_id = $this->user_id;
            $userTask->task_id = $this->task_id;
            $userTask->point = $this->point;
            $userTask->save();
        }

        if ($this->file) {
            $this->upload();
        }

        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTask()
    {
        return $this->hasOne(UserTask::class, ['user_id' => 'user_id', 'task_id' => 'task_id']);
    }

    /**
     * @return bool|int
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        return file_put_contents(Yii::getAlias('@webroot') . $this->file_path, $this->fileData);
    }
}
