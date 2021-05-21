<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\CompetitionQuestionnaire;
use qviox\mentor\models\search\CompetitionQuestionnaireSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompetitionQuestionnaireController implements the CRUD actions for CompetitionQuestionnaire model.
 */
class CompetitionQuestionnaireController extends RuleController
{

    /**
     * Lists all CompetitionQuestionnaire models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompetitionQuestionnaireSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompetitionQuestionnaire model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }






    /**
     * Finds the CompetitionQuestionnaire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompetitionQuestionnaire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompetitionQuestionnaire::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
