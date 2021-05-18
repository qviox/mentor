<?php

namespace qviox\mentor\models\scores;



/**
 * This is the model class for table "{{%skill_session}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SkillUserPoint[] $skillUserPoints
 */
class SkillSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_skill_session}}';
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAvailableSessions()
    {
        return self::find()->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            'name' => 'Название',
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
        return $this->hasMany(SkillUserPoint::class, ['session_id' => 'id']);
    }
}
