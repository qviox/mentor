<?php

namespace qviox\mentor\controllers\mentor;

use qviox\mentor\models\scores\Skill;
use qviox\mentor\models\search\SkillSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SkillController implements the CRUD actions for Skill model.
 */
class SkillController extends RuleController
{
    /**
     * @param $user_id
     * @param $session_id
     * @return array
     */
    public function actionGetAvailableSkills($user_id, $session_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ArrayHelper::map(Skill::getAvailableSkills($user_id, $session_id), 'id', 'name');
    }
}
