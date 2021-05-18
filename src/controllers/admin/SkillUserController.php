<?php

namespace qviox\mentor\controllers\admin;

use qviox\mentor\models\scores\Skill;
use qviox\mentor\models\scores\SkillSession;
use qviox\mentor\models\scores\SkillUserPoint;
use qviox\mentor\models\search\SkillSearch;
use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class SkillUserController
 * @package app\modules\admin\controllers
 */
class SkillUserController extends RuleController
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/admin']);
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

        $model = new SkillUserPoint();
        $model->loadDefaultValues();
        $model->user_id = $user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin/participants/update', 'id' => $user->id, '#' => 'skills']);
        }

        return $this->render('create', [
            'user' => $user,
            'model' => $model,
            'availableSessions' => ArrayHelper::map(SkillSession::getAvailableSessions(), 'id', 'name')
        ]);
    }

    /**
     * @param $user_id
     * @param $skill_id
     * @param $session_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($user_id, $skill_id, $session_id)
    {
        $model = $this->findModel($user_id, $skill_id, $session_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Навык успешно обновлен');
            return $this->redirect(['admin/participants/update', 'id' => $user_id, '#' => 'skills']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $user_id
     * @param $skill_id
     * @param $session_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($user_id, $skill_id, $session_id)
    {
        $this->findModel($user_id, $skill_id, $session_id)->delete();

        return $this->redirect(['admin/participants/update', 'id' => $user_id, '#' => 'skills']);
    }

    /**
     * @param $user_id
     * @param $skill_id
     * @param $session_id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($user_id, $skill_id, $session_id)
    {
        if (($model = SkillUserPoint::find()
                ->where(['user_id' => $user_id, 'skill_id' => $skill_id, 'session_id' => $session_id])
                ->limit(1)
                ->one())
            !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
