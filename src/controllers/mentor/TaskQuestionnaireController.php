<?php
namespace qviox\mentor\controllers\mentor;

use qviox\mentor\controllers\mentor\RuleController;
use qviox\mentor\models\rbac\URole;
use qviox\mentor\models\scores\Task;
use qviox\mentor\models\scores\TaskInput;
use qviox\mentor\models\scores\TaskInputValue;
use qviox\mentor\models\scores\TaskQuestionnaire;
use qviox\mentor\models\scores\Team;
use qviox\mentor\models\scores\UserTask;
use qviox\mentor\models\scores\UserTeam;
use qviox\mentor\models\search\TaskQuestionnaireSearch;
use qviox\mentor\models\User;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FifthTaskQuestionnaireController implements the CRUD actions for FifthTaskQuestionnaire model.
 */
class TaskQuestionnaireController extends RuleController
{


    /**
     * Lists all FifthTaskQuestionnaire models.
     * @return mixed
     */
    public function actionTask($taskId)
    {
        $teamIds = Team::getMentorTeamIds(Yii::$app->user->id);
        $availableUserIds = UserTeam::find()
            ->select('user_id')
            ->where(['team_id' => $teamIds])
            ->column();

        $task_inputs=null;
        $searchModel = new TaskQuestionnaireSearch();
        $dataProvider = $searchModel->search($taskId,$task_inputs,Yii::$app->request->queryParams, $availableUserIds);

        return $this->render('index', [
            'task_inputs'=>$task_inputs,
            'taskId'=>$taskId,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing FourthTaskQuestionnaire model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($userId,$taskId)
    {
        $user = User::findOne($userId);
        $task = Task::findOne($taskId);
        if ($user && $task) {
            $mentor = Yii::$app->user;
            $userTask = UserTask::findOne(['user_id' => $user->id, 'task_id' => $task->id])??new UserTask();

            if ((!$user->team || $user->team->mentor_id != $mentor->id) && !URole::checkUserAccess('RBAC')) {
                Yii::$app->session->setFlash('error', 'Нет прав для данного действия');
                return $this->redirect(Yii::$app->request->referrer);
            }
            if (Yii::$app->request->post()) {

                if($userTask->load(Yii::$app->request->post())){
                    if($userTask->isNewRecord){
                        $userTask->user_id = $user->id;
                        $userTask->task_id = $task->id;
                    }
                    $userTask->save();
                }

                if ($TaskInputs = Yii::$app->request->post()['TaskInput']) {
                    foreach ($TaskInputs as $taskInputId => $TaskInput) {

                        $input = TaskInput::findOne($taskInputId);
                        if ($input) {
                            $taskInputValue = $input->getTaskInputValueByUser($user->id)??new TaskInputValue();
                            if ($TaskInput) {
                                if ($taskInputValue->isNewRecord) {
                                    $taskInputValue->user_id = $user->id;
                                    $taskInputValue->task_input_id = $input->id;
                                }
                                $taskInputValue->val = $TaskInput;
                                $taskInputValue->save();

                            } else {
                                TaskInputValue::deleteAll(['user_id' => $user->id, 'task_input_id' => $input->id]);
                            }

                        }
                    }
                }
                return $this->redirect(Yii::$app->request->referrer);
            }



//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect('index');
//            }

            return $this->render('update', [
                'user' => $user,
                'task'=>$task,
                'userTask'=>$userTask
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);

    }



    /**
     * Finds the FifthTaskQuestionnaire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FifthTaskQuestionnaire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

}
