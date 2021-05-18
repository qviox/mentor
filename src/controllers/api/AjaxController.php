<?php
namespace qviox\mentor\controllers\api;

use qviox\mentor\controllers\api\base\ConfigController;
use qviox\mentor\models\CompetitionQuestionnaire;
use qviox\mentor\models\scores\Skill;
use qviox\mentor\models\scores\SkillUserPoint;
use qviox\mentor\models\scores\TaskInputValue;
use qviox\mentor\models\scores\Team;
use yii\web\Controller;
use qviox\mentor\models\scores\UserTask;
use qviox\mentor\models\scores\TaskInput;
use yii\db\Exception;
use Yii;
class AjaxController extends ConfigController {


    public function actionGetUsersRate()
    {

        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Не авторизированный пользователь');
        }
        return [
            [
                'name' => 'Рейтинг участников',
                'rangData' => UserTask::getTotalRate()
            ],
            [
                'name' => 'Задания участников',
                'taskData' => UserTask::getAllUserTasks()
            ]
        ];

    }
    public function actionGetTotalPointsBySession()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Не авторизированный пользователь');
        }

        return [
            'name' => 'Общий балл',
            'sessions' => SkillUserPoint::getTotalPointBySession()
        ];
    }
    public function actionGetUserSkills()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Не авторизированный пользовтель');
        }

        return Skill::getSkillsUserData();
    }
    public function actionGetTeamsRate()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Не авторизированный пользователь');
        }

        return Team::getTotalRate();
    }
    public function actionSetCompetitionQuestionnaire()
    {

        if (Yii::$app->request->isPost) {

            $q = new CompetitionQuestionnaire();

            $q->load(Yii::$app->request->post());
            if (!Yii::$app->user->isGuest) $q->user_id = Yii::$app->user->identity->id;
            if ($q->validate()) {

                $q->save();
                return true;
            } else return $q->errors;


        }

    }
    public function actionCheckTaskQuestionnaire($taskId)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Не авторизированный пользователь');
        }

        return TaskInputValue::find()
            ->joinWith('taskInput as ti')
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['ti.task_id' => $taskId])
            ->exists();
    }

    public function actionSaveTaskData(){

        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $post=Yii::$app->request->post();
            if($post){
                $TaskInputs=$post['TaskInput'];
                foreach($TaskInputs as $idTaskInput=>$item){
                    $taskInput=TaskInput::findOne($idTaskInput);
                    if(!$taskInput)
                        return false;
                    $taskInput->saveTaskInputValue($item);
                }
            }
            if($files=$_FILES['TaskInputFile']['name']['TaskInputFiles']){
                foreach($files as $key=>$filename){
                    $taskInput=TaskInput::findOne($key);
                    $paths[]= $taskInput->saveTaskInputValueFile();
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            foreach($paths as $path){
                foreach(explode(';',$path) as $p){
                    unlink(Yii::getAlias('@'.$p));
                }
            }
            $transaction->rollback();
            return $e->getMessage();
        }

        return 'success';
    }
}