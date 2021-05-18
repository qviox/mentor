<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\UserTeam;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class UserTeamController
 * @package app\modules\admin\controllers
 */
class UserTeamController extends RuleController
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/admin']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserTeam();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Добавлена команда');

            if (Yii::$app->request->get('toTeamList')) {
                $url = ['admin/team/update', 'id' => $model->team_id, '#' => 'members'];
            } else {
                $url = ['admin/participants/update', 'id' => $model->user_id, '#' => 'team'];
            }

            return $this->redirect($url);
        }

        return $this->render('create', [
            'model' => $model            
        ]);
    }

    /**
     * @param $userId
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($userId)
    {
        $model = $this->findModel($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Команда успешно обновлена');
            return $this->redirect(['admin/participants/update', 'id' => $userId, '#' => 'team']);
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
    public function actionDelete($userId)
    {
        $model = $this->findModel($userId);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Участник удален из команды');
        }

        return $this->redirect(['admin/team/update', 'id' => $model->team_id, '#' => 'members']);
    }

    /**
     * @param $user_id
     * @param $team_id
     * @param $session_id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($user_id)
    {
        if (($model = UserTeam::find()
                ->where(['user_id' => $user_id])
                ->limit(1)
                ->one())
            !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
