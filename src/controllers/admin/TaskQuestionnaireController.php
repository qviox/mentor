<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Task;
use qviox\mentor\models\search\TaskQuestionnaireSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * TaskQuestionnaireController implements the CRUD actions for TaskQuestionnaire model.
 */
class TaskQuestionnaireController extends RuleController
{
    /**
     * Lists all TaskQuestionnaire models.
     * @param $taskId
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($taskId)
    {
        $task = Task::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException();
        }

//        $params = Yii::$app->request->queryParams;
//        $params['TaskQuestionnaireSearch']['task_id'] = $task->id;
        $task_inputs=null;
        $searchModel = new  TaskQuestionnaireSearch();
        $dataProvider = $searchModel->search($taskId,$task_inputs,Yii::$app->request->queryParams);
        return $this->render('/mentor/task-questionnaire/index', [
            'task_inputs'=>$task_inputs,
            'taskId'=>$taskId,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing TaskQuestionnaire model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'taskId' => $model->task_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TaskQuestionnaire model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index', 'taskId' => $model->task_id]);
    }

    /**
     * Finds the TaskQuestionnaire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskQuestionnaire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskQuestionnaire::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
