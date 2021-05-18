<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Task;
use qviox\mentor\models\scores\Team;
use qviox\mentor\models\scores\TeamTask;
use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class TeamTaskController
 * @package app\modules\admin\controllers
 */
class TeamTaskController extends RuleController
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/admin']);
    }

    /**
     * @param $teamId
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($teamId)
    {
        $team = Team::find()
            ->where(['id' => $teamId])
            ->limit(1)
            ->one();

        if (!$team) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new TeamTask();
        $model->loadDefaultValues();
        $model->team_id = $team->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задание успешно обновлено');
            return $this->redirect(['admin/team/update', 'id' => $team->id, '#' => 'tasks']);
        }

        return $this->render('create', [
            'team' => $team,
            'model' => $model,
            'availableTasks' => ArrayHelper::map(Task::getAvailableCommandTasks($team->id), 'id', 'name')
        ]);
    }

    /**
     * @param $team_id
     * @param $task_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($team_id, $task_id)
    {
        $model = $this->findModel($team_id, $task_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задание успешно обновлено');
            return $this->redirect(['team/update', 'id' => $team_id, '#' => 'tasks']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($team_id, $task_id)
    {
        $this->findModel($team_id, $task_id)->delete();

        return $this->redirect(['team/update', 'id' => $team_id, '#' => 'tasks']);
    }

    /**
     * @param $team_id
     * @param $task_id
     * @param $session_id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($team_id, $task_id)
    {
        if (($model = TeamTask::find()
                ->where(['team_id' => $team_id, 'task_id' => $task_id])
                ->limit(1)
                ->one())
            !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
