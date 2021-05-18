<?php

namespace qviox\mentor\models\scores;

use qviox\mentor\components\presenters\TeamPresenter;
use qviox\mentor\models\User;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property int $id
 * @property int|null $mentor_id
 * @property string|null $name
 * @property string|null $description
 * @property integer|null $total_points
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $mentor
 * @property TeamTask[] $teamTasks
 * @property User[] $users
 * @property UserTeam[] $userTeams
 */
class Team extends \yii\db\ActiveRecord
{
    public $teamPoints = 0;

    public $userPoints = 0;

    public $totalPoints = 0;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_team}}';
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTotalRate()
    {
        $teamId = UserTeam::find()
            ->select('team_id')
            ->where(['user_id' => \Yii::$app->user->id])
            ->limit(1)
            ->scalar();

        if (!$teamId) {
            return null;
        }

        $team = Team::find()
            ->with(['teamTasks', 'teamTasks.task', 'userTeams', 'userTeams.user', 'userTeams.user.userTasks'])
            /*->joinWith(['teamTasks', 'teamTasks.task', 'userTeams', 'userTeams.user', 'userTeams.user.userTasks'])
            ->select([
                'team.*',
                'sum(team_task.point) as teamPoints',
                'sum(user_task.point) as userPoints',
                '(sum(team_task.point) + sum(user_task.point)) as totalPoints'
            ])*/
            ->where(['id' => $teamId])
            ->limit(1)
            ->one();


        $team = (new TeamPresenter($team))->present();

        /*usort($teams, function ($a, $b) {
            return $b['totalPoints'] <=> $a['totalPoints'];
        });*/

        return $team;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mentor_id', 'total_points'], 'integer'],
            [['description'], 'string'],
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
            'mentor_id' => 'Ментор',
            'name' => 'Название',
            'teamPoints' => 'Командные баллы',
            'userPoints' => 'Баллы участников',
            'totalPoints' => 'Общий балл',
            'total_points' => 'Общий балл',
            'description' => 'Описание',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Mentor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMentor()
    {
        return $this->hasOne(User::class, ['id' => 'mentor_id']);
    }

    /**
     * Gets query for [[TeamTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTasks()
    {
        return $this->hasMany(TeamTask::class, ['team_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id'])->viaTable('{{%mentor_team_task}}', ['team_id' => 'id']);
    }

    /**
     * Gets query for [[UserTeams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::class, ['team_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('{{%mentor_user_team}}', ['team_id' => 'id']);
    }

    /**
     * @return int|null
     */
    public function getUserPoints()
    {
        if (!$this->userTeams) {
            $this->userPoints;
        }

        foreach ($this->userTeams as $user) {
            foreach ($user->user->userTasks as $task) {
                $this->userPoints += $task->point;
            }
        }

        return $this->userPoints;
    }

    /**
     * @return int
     */
    public function getTotalPoints() {
        return $this->teamPoints + $this->userPoints;
    }

    /**
     * @param null $oldTeamId
     */
    public function reCount($oldTeamId = null)
    {
        if ($oldTeamId) {
            /** @var Team $oldTeam */
            $oldTeam = self::find()->where(['id' => $oldTeamId])->limit(1)->one();
            if ($oldTeam) {
                $oldTeam->reCount();
            }
        }

        $teamPoints = (int) TeamTask::getAllTeamPoints($this->id);
        $userPoints = (int) UserTeam::getAllUserPoints($this->id);;

        $this->total_points = $teamPoints + $userPoints;
        $this->save();
    }

    /**
     * @return false|int|null|string
     */
    public function getPlace()
    {
        return self::find()
            ->select('COUNT(*) + 1 as place')
            ->where(['>', 'total_points', $this->total_points])
            ->scalar();
    }

    /**
     * @param $mentorId
     * @return array
     */
    public static function getMentorTeamIds($mentorId)
    {
        return self::find()
            ->select('id')
            ->where(['mentor_id' => $mentorId])
            ->column();
    }
}
