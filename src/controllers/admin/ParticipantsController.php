<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Skill;
use qviox\mentor\models\scores\SkillSession;
use qviox\mentor\models\scores\Team;
use qviox\mentor\models\scores\UserTeam;
use qviox\mentor\models\search\SkillUserSearch;
use qviox\mentor\models\search\UserTaskSearch;
use Yii;
use qviox\mentor\models\User;
use qviox\mentor\models\search\UserSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipantsController implements the CRUD actions for User model.
 */
class ParticipantsController extends RuleController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchParticipant(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $skillSearchModel = new SkillUserSearch();
        $skillUserProvider = $skillSearchModel->search(Yii::$app->request->queryParams, $model->id);

        $taskSearchModel = new UserTaskSearch();
        $taskUserProvider = $taskSearchModel->search(Yii::$app->request->queryParams, $model->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Пользователь успешно изменен');

            return $this->redirect(['update', 'id' => $model->id]);
        }

        $skills     = ArrayHelper::map(Skill::find()->asArray()->all(), 'id', 'name');
        $sessions   = ArrayHelper::map(SkillSession::find()->asArray()->all(), 'id', 'name');
        $teams      = ArrayHelper::map(Team::find()->all(), 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'skillUserProvider' => $skillUserProvider,
            'skillSearchModel' => $skillSearchModel,
            'taskUserProvider' => $taskUserProvider,
            'skills' => $skills,
            'sessions' => $sessions,
            'teams' => $teams,
            'team' => $model->userTeam ?? new UserTeam()
        ]);
    }


    /**
     * @param $email
     * @return array
     */
    public function actionSearch($email)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = ['results' => ['id' => '', 'email' => '']];

        $usersInTeamsId = UserTeam::find()->select('user_id')->column();

        $users = User::find()
            ->select('id, email')
            ->where(['not in', 'id', $usersInTeamsId])
            ->andWhere(['type' => USER::TYPE_PARTICIPANT])
            ->andWhere(['like', 'email', $email])
            ->asArray()
            ->limit(10)
            ->all();

        $response['results'] = array_values($users);

        return $response;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
