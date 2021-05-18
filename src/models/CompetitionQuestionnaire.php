<?php

namespace qviox\mentor\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "competition_questionnaire".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property int|null $gender
 * @property int|null $age
 * @property string|null $region
 * @property string|null $education
 * @property string|null $work
 * @property string|null $work_experience
 * @property string|null $experience
 * @property string|null $member_voluntary
 * @property string|null $professional_qualities
 * @property string|null $leader_social_change
 * @property string|null $expectations
 * @property string|null $created_at
 */
class CompetitionQuestionnaire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {

        return '{{%mentor_competition_questionnaire}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'age'], 'integer'],
            [['fio', 'email', 'phone', 'experience', 'member_voluntary', 'professional_qualities', 'leader_social_change', 'expectations', 'gender', 'age', 'education', 'work'], 'required'],
            [['created_at'], 'safe'],

            [['fio', 'email', 'phone', 'region', 'work_experience'], 'string', 'max' => 100],
            [['education', 'work'], 'string', 'max' => 1000],
            [['experience', 'member_voluntary', 'professional_qualities', 'leader_social_change', 'expectations'], 'string', 'max' => 1500],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function () {
                    return (new \DateTime())->modify('+3 hour')->format('Y-m-d H:i:s');
                },
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fio' => 'Фамилия Имя Отчество',
            'email' => 'Email',
            'phone' => 'Телефон',
            'gender' => 'Пол',
            'age' => 'Возраст',
            'region' => 'Населённый пункт и регион проживания',
            'education' => 'Образование (учебное заведение, специальность, уровень образования, год выпуска)',
            'work' => 'Место работы (учреждение, должность)',
            'work_experience' => 'Ваш стаж работы в профессии',
            'experience' => 'Есть ли у Вас опыт организации школьных сообществ и других общественных объединений? Опишите его.',
            'member_voluntary' => 'Являетесь ли Вы лидером/участником каких-либо добровольных школьных  или общественных объединений в данный момент? Опишите суть проекта и Вашу роль в нём.',
            'professional_qualities' => 'Какие Ваши личностные и профессиональные качества выделяют Вас среди коллег?',
            'leader_social_change' => 'Почему именно Вам необходимо стать лидером общественных изменений? Каковы Ваши цели в проекте и после него?',
            'expectations' => 'Каковы Ваши ожидания от программы «Лидеры общественных изменений»?',
            'created_at' => 'Время создания',
        ];
    }
}
