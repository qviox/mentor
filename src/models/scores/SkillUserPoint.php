<?php

namespace qviox\mentor\models\scores;

use qviox\mentor\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%skill_user_point}}".
 *
 * @property int $user_id
 * @property int $skill_id
 * @property int $session_id
 * @property int|null $point
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SkillSession $session
 * @property Skill $skill
 * @property User $user
 */
class SkillUserPoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_skill_user_point}}';
    }

    /**
     * @return array
     */
    public static function getTotalPointBySession()
    {
        $sessions = SkillSession::find()->select(['id','name'])->all();

        $result = [];
        foreach ($sessions as $session) {
            $total = self::find()
                ->where(['user_id' => Yii::$app->user->id, 'session_id' => $session->id])
                ->sum('point');

            $userIds = self::find()->select('user_id')
                ->where(['session_id' => $session->id])
                ->groupBy('user_id')
                ->column();

            $rate = self::find()
                ->select('sum(mentor_skill_user_point.point) as total')
                ->where(['session_id' => $session->id, 'user_id' => $userIds])
                ->asArray()
                ->groupBy(['user_id'])
                ->orderBy('total')
                ->all();

            $min = null;
            $max = null;

            if (!empty($rate)) {
                $min = $rate[0]['total'];
                $max = $rate[count($rate) - 1]['total'];
            }

            $result[] = [
                'session_id' => $session->id,
                'name' => $session->name,
                'point' => $total,
                'min' => $min,
                'max' => $max,
            ];
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'skill_id', 'session_id'], 'required'],
            [['user_id', 'skill_id', 'session_id', 'point'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'skill_id', 'session_id'], 'unique', 'targetAttribute' => ['user_id', 'skill_id', 'session_id']],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillSession::class, 'targetAttribute' => ['session_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::class, 'targetAttribute' => ['skill_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'skill_id' => 'Skill ID',
            'session_id' => 'Сессия',
            'point' => 'Баллы',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Session]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(SkillSession::class, ['id' => 'session_id']);
    }

    /**
     * Gets query for [[Skill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'skill_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
