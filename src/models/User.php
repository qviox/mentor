<?php
namespace qviox\mentor\models;
use qviox\mentor\models\rbac\URole;
use qviox\mentor\models\rbac\UserURole;
use qviox\mentor\models\scores\Skill;
use qviox\mentor\models\scores\SkillUserPoint;
use qviox\mentor\models\scores\Task;
use qviox\mentor\models\scores\Team;
use qviox\mentor\models\scores\UserTask;
use qviox\mentor\models\scores\UserTeam;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    // Статусы пользователей на сайте
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INVITED = 2;
    const STATUS_HOLD = 3;

    const TYPE_TEACHER = 1; // Учасник
//    const TYPE_ORGANIZER = 2; // Организатор проекта
//    const TYPE_LEADER = 3; // Руководитель организации/движения
//    const TYPE_SEMI_FINALIST = 4; // Полуфиналист конкурса "Доброволец России"
    const TYPE_EXPERT = 2; // Эксперт
    const TYPE_VIEWER = 3; // Эксперт
    const TYPE_PARTICIPANT = 4; // Участник
//
//    const BACKEND_STATUS_INACTIVE = 0;
//
//    // const BACKEND_STATUS_CLUB_ADMINISTRATOR = 1;
//    const BACKEND_STATUS_ADMINISTRATOR = 2;
//    const BACKEND_STATUS_SUPER_ADMINISTRATOR = 3;
//    const BACKEND_STATUS_MENTOR = 4;


    public $userPoints;


    public function getTypeLabel()
    {
        return $this->typeLabels()[$this->getType()];

    }
    public function getType(){
        $type=$this->userUType->user_type_id;
        return $type?$type:4;
    }
    public static function typeLabels()
    {
        return UType::getLabels();
    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' =>
            [
                self::STATUS_ACTIVE,
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        $module = Yii::$app->getModule('mentor');
        return $module->userTable;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['email'], 'required'],
//            [['status', 'backend_status', 'api_status', 'club_id', 'district_id', 'type', 'dobro_id'], 'integer'],
//            ['status', 'default', 'value' => self::STATUS_INACTIVE],
//            ['status', 'in', 'range' => [
//                self::STATUS_INACTIVE,
//                self::STATUS_ACTIVE,
//                self::STATUS_INVITED
//            ],
//            ],
//
//            ['type', 'default', 'value' => self::TYPE_TEACHER],
//            ['club_id', 'default', 'value' => 1],
//
//
//            ['backend_status', 'default', 'value' => self::BACKEND_STATUS_INACTIVE],
//            ['backend_status', 'in', 'range' => [
//                self::BACKEND_STATUS_INACTIVE,
//                self::BACKEND_STATUS_ADMINISTRATOR,
//                self::BACKEND_STATUS_SUPER_ADMINISTRATOR,
//                self::BACKEND_STATUS_MENTOR,
//            ],
//            ],
//            [['created_at', 'updated_at'], 'safe'],
//            [['surname', 'name', 'middle_name', 'password_hash', 'password_reset_token', 'email','image'], 'string', 'max' => 255],
//            [['email'], 'unique'],
//            ['email', 'email'],
//            [['club_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clubs::class, 'targetAttribute' => ['club_id' => 'id']],


        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Статус',
            'type' => 'Тип',
            'userPoints' => 'Баллы',
            'backend_status' => 'Статус администрирования',
            'api_status' => 'Статус Апи',
            'club_id' => 'Клуб',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillUserPoints()
    {
        return $this->hasMany(SkillUserPoint::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSkills()
    {
        return $this->hasMany(Skill::class, ['id' => 'skill_id'])->viaTable('{{%mentor_skill_user_point}}', ['user_id' => 'id']);
    }
    /**
     * Gets query for [[UserTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTask::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id'])->viaTable('{{%mentor_user_task}}', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserTeams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeam()
    {
        return $this->hasOne(UserTeam::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id'])->viaTable('{{%mentor_user_team}}', ['user_id' => 'id']);
    }
    public function getUserRole()
    {
        return $this->hasOne(URole::class, ['id' => 'user_role_id'])->viaTable('{{%mentor_user_urole}}', ['user_id' => 'id']);
    }

    public function getUserURole()
    {
        return $this->hasOne(UserURole::class, ['user_id' => 'id']);
    }
    public function getUserType()
    {
        return $this->hasOne(UType::class, ['id' => 'user_type_id'])->viaTable('{{%mentor_user_utype}}', ['user_id' => 'id']);
    }
    public function getUserUType()
    {
        return $this->hasOne(UserUType::class, ['user_id' => 'id']);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getMentors()
    {
        return self::find()
//            ->where(['backend_status' => self::BACKEND_STATUS_MENTOR])
                ->joinWith('userURole ur')
                ->where(['ur.user_role_id'=>URole::ROLE_MENTOR])
            ->all();
    }
}
