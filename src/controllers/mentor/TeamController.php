<?php

namespace qviox\mentor\controllers\mentor;

use qviox\mentor\models\scores\Team;
use qviox\mentor\models\search\TeamSearch;
use qviox\mentor\models\search\TeamTaskSearch;
use qviox\mentor\models\search\UserSearch;
use Yii;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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

        return $this->render('update', [
            'model' => $model,
            'userDataProvider' => $userDataProvider,
            'taskDataProvider' => $taskDataProvider
        ]);
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
