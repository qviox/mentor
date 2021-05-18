<?php

namespace qviox\mentor\models\scores;


use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%skill}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SkillUserPoint[] $skillUserPoints
 * @property User[] $users
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_skill}}';
    }

    /**
     * @param $userId
     * @param $sessionId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAvailableSkills($userId, $sessionId)
    {
        $usedSkills = SkillUserPoint::find()
            ->select('skill_id')
            ->where(['user_id' => $userId, 'session_id' => $sessionId])
            ->asArray()
            ->column();

        return self::find()
            ->where(['not in', 'id', $usedSkills])
            ->all();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название навыка',
            'sort' => 'Сортировка',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SkillUserPoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillUserPoints()
    {
        return $this->hasMany(SkillUserPoint::class, ['skill_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('{{%skill_user_point}}', ['skill_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getSkillsUserData()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $allSkills = self::find()
            ->select(['id', 'name'])
            ->orderBy('sort')
            ->asArray()
            ->all();

        /** @var Skill $skill */
        foreach ($allSkills as &$skill) {
            $skill['sessions'] = [];


            /** @var SkillUserPoint[] $userSkillPoints */
            $userSkillPoints = SkillUserPoint::find()
                ->with('session')
                ->where(['user_id' => $user->id, 'skill_id' => $skill['id']])
                ->all();

            if (empty($userSkillPoints)) {
                continue;
            }

            /** @var SkillUserPoint $point */
            foreach ($userSkillPoints as $point) {
                $skill['sessions'][] = [
                    'session_id' => $point->session->id,
                    'name' => $point->session->name,
                    'point' => $point->point,
                    'max' => (int) SkillUserPoint::find()->where(['session_id' => $point->session->id, 'skill_id' => $skill['id']])->max('point'),
                    'min' => (int) SkillUserPoint::find()->where(['session_id' => $point->session->id, 'skill_id' => $skill['id']])->min('point')
                ];
            }
        }

        return $allSkills;
    }
}