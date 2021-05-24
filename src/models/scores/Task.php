<?php

namespace qviox\mentor\models\scores;

use qviox\mentor\components\enums\TaskType;
use qviox\mentor\models\User;
use yii\db\Exception;
use Yii;
/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string $type
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property UserTask[] $userTasks
 * @property User[] $users
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_task}}';
    }

    /**
     * @param $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAvailableIndividualTasks($userId)
    {
        $usedTaskIds = UserTask::find()
            ->select('task_id')
            ->where(['user_id' => $userId])
            ->column();

        return self::find()
            ->where(['not in', 'id',  $usedTaskIds])
            ->andWhere(['type' => TaskType::INDIVIDUAL])
            ->all();
    }

    /**
     * @param $teamId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAvailableCommandTasks($teamId)
    {
        $teamTaskIds = TeamTask::find()
            ->select('task_id')
            ->where(['team_id' => $teamId])
            ->column();

        return self::find()
            ->where(['not in', 'id',  $teamTaskIds])
            ->andWhere(['type' => TaskType::COMMAND])
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
            [['type'], 'in', 'range' => TaskType::values()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'type' => 'Тип задания',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UserTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTask::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('{{%user_task}}', ['task_id' => 'id']);
    }
    public function getTaskInputs()
    {
        return $this->hasMany(TaskInput::class, ['task_id'=>'id']);
    }
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNewTaskForQuestionnaire()
    {
        return self::find()
//            ->where(['>', 'id', 9])
            ->orderBy('id')
            ->all();
    }
    public function getModelInputByName($name){
        return TaskInput::findOne(['name'=>$name,'task_id'=>$this->id]);
    }
    public function getFormInputByName($name){
       $model= $this->getModelInputByName($name);
       return $model->getFormInput();

    }
    public function saveTaskQuestionnaire($data,$user_id=null){
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
        $keys=null;
        foreach ($data as $key=>$item) {
            $keys[]=$key;
            $taskInput = $this->getModelInputByName($key);
            if(!$taskInput)
                throw new Exception('Cant find taskInput with name = '.$key);
            if($user_id)
                $taskInput->user_id=$user_id;
            else
                $taskInput->user_id=Yii::$app->user->id;
            $val = $taskInput->saveTaskInputValue($item);
            if ($taskInput->type == TaskInput::TYPE_FILE) {
                $paths[] = $val;
            }
        }
            $this->saveEmptyTaskInputValueWithDefaultValue($keys);

            $transaction->commit();
        } catch (Exception $e) {
            foreach($paths as $path){
                foreach(explode(';',$path) as $p){
                    unlink($p);
                }
            }
            $transaction->rollback();
            return $e->getMessage();
        }
        return true;
    }
    public function saveEmptyTaskInputValueWithDefaultValue($excludeTaskInputNames){
        $emptyTaskInputs=TaskInput::find()->where('not in','name',$excludeTaskInputNames)->andWhere(['not',['default_value'=>null]])->all();
        if($emptyTaskInputs)
            foreach ($emptyTaskInputs as $emptyTaskInput){
                $emptyTaskInputs->saveDefaultTaskInputValue();
            }
    }
    public static function getTaskListForMenu(){
    foreach(self::find()->all() as $task){
            $items[]=['label' => $task->name, 'icon' => 'users', 'url' => ['/mentor/admin/task-questionnaire','taskId'=>$task->id]];
        }
        return $items;
    }
}
