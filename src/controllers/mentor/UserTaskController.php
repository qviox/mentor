<?php

namespace qviox\mentor\controllers\mentor;

use qviox\mentor\models\scores\Task;
use qviox\mentor\models\scores\UserTask;
use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class UserTaskController
 * @package app\modules\admin\controllers
 */
class UserTaskController extends RuleController
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/mentor/']);
    }

    /**
     * @param $userId
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($userId)
    {
        $user = User::find()
            ->where(['id' => $userId])
            ->andWhere(['type' => User::TYPE_PARTICIPANT])
            ->limit(1)
            ->one();

        if (!$user) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new UserTask();
        $model->loadDefaultValues();
        $model->user_id = $user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['participants/update', 'id' => $user->id, '#' => 'tasks']);
        }

        return $this->render('create', [
            'user' => $user,
            'model' => $model,
            'availableTasks' => ArrayHelper::map(Task::getAvailableIndividualTasks($user->id), 'id', 'name')
        ]);
    }

    /**
     * @param $user_id
     * @param $task_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($user_id, $task_id)
    {
        $model = $this->findModel($user_id, $task_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Навык успешно обновлен');
            return $this->redirect(['participants/update', 'id' => $user_id, '#' => 'tasks']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $user_id
     * @param $task_id
     * @param $session_id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($user_id, $task_id)
    {
        if (($model = UserTask::find()
                ->where(['user_id' => $user_id, 'task_id' => $task_id])
                ->limit(1)
                ->one())
            !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
