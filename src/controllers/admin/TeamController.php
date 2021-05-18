<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Team;
use qviox\mentor\models\search\TeamSearch;
use qviox\mentor\models\search\TeamTaskSearch;
use qviox\mentor\models\search\UserSearch;
use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends RuleController
{
    /**
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Team();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Команда успешно создан');
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'mentors' => ArrayHelper::map(User::getMentors(), 'id', 'email')
        ]);
    }


    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Team();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $userSearchModel = new UserSearch();
        $userDataProvider = $userSearchModel->searchParticipant(Yii::$app->request->queryParams, $model->id);

        $teamTaskModel = new TeamTaskSearch();
        $taskDataProvider = $teamTaskModel->search(Yii::$app->request->queryParams, $model->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Команда успешно обновлена');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'userDataProvider' => $userDataProvider,
            'taskDataProvider' => $taskDataProvider,
            'mentors' => ArrayHelper::map(User::getMentors(), 'id', 'email')
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
