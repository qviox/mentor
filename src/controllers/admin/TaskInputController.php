<?php
namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Task;
use qviox\mentor\models\scores\TaskInput;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use Yii;
use yii\filters\VerbFilter;
class TaskInputController extends RuleController
{
    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }
    public function actionCreate()
    {
        $model = new TaskInput();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Поле успешно добавлено');
            return $this->redirect(Url::to(['admin/task/update','id'=>$model->task->id]));
        }
        $errors=[];
        if($model->errors)
            foreach($model->errors as $error)
                $errors[]=$error[0];
        Yii::$app->session->setFlash('error', 'Произошла ошибка ('.implode(' | ',$errors).')');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id){

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Поле успешно обновлено');
            return $this->redirect(Url::to(['admin/task/update','id'=>$model->task->id]));
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }
    public function actionDelete($id)
    {
        die();
        $model=$this->findModel($id);
        if($model->delete())
            Yii::$app->session->setFlash('success', 'Поле удаленно');
        return $this->redirect(Url::to(['admin/task/update','id'=>$model->task->id]));
    }
    protected function findModel($id)
    {
        if (($model = TaskInput::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}