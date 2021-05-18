<?php

namespace qviox\mentor\components\presenters;

use qviox\mentor\models\CompetitionQuestionnaire;
use qviox\mentor\models\scores\Team;

/**
 * Class TeamPresenter
 * @package app\components\enums
 */
class TeamPresenter
{
    protected $teamData;

    protected  $team;

    protected $teamPoints = 0;

    protected $userPoints = 0;

    /**
     * TeamPresenter constructor.
     * @param Team $team
     */
    public function __construct($team)
    {
        $this->teamData = $team;
    }

    /**
     * @return array
     */
    public function present()
    {
        $this->setMainData();
        $this->setTeamTask();
        $this->setUserMembers();
        $this->setPoints();

        //$this->transformTaskData();
        //$this->transformUserData();
        return $this->team;
    }

    /**
     * @param $email
     * @return false|int|null|string
     */
    private function getPhone($email)
    {
        if (!$email) {
            return null;
        }

        return CompetitionQuestionnaire::find()
            ->select('phone')
            ->where(['email' => $email])
            ->limit(1)
            ->orderBy(['id' => SORT_DESC])
            ->scalar();
    }

    /**
     * @param $tasks
     * @return int
     */
    private function getPoints($tasks)
    {
        if (!$tasks) {
            return 0;
        }

        $points = 0;
        foreach ($tasks as $task) {
            $points += $task->point ?? 0;
        }

        $this->userPoints += $points;

        return $points;
    }

    private function setMainData()
    {
        $this->team['id'] = $this->teamData->id;
        $this->team['name'] = $this->teamData->name;
    }

    private function setTeamTask()
    {
        if (!$this->teamData->teamTasks) {
            $this->team['tasks'] = [];
            return;
        }

        foreach ($this->teamData->teamTasks as $task) {
            $this->team['tasks'][] = [
                'id' => $task->task->id,
                'name' => $task->task->name,
                'point' => $task->point ?? 0
            ];
        }
    }

    private function setUserMembers()
    {
        if (!$this->teamData->userTeams) {
            $this->team['team_members'] = [];
            return;
        }

        foreach ($this->teamData->userTeams as $user) {
            $this->team['team_members'][] = [
                'name' => $user->user->name ?? null,
                'surname' => $user->user->surname ?? null,
                'middle_name' => $user->user->middle_name ?? null,
                'email' => $user->user->email ?? null,
                'phone' => $this->getPhone($user->user->email ?? null),
                'point' => $this->getPoints($user->user->userTasks ?? null)
            ];

            $this->teamPoints += $task->point ?? 0;
        }
    }

    private function setPoints()
    {
        $this->team['teamPoints'] = $this->teamPoints;
        $this->team['userPoints'] = $this->userPoints;
        $this->team['totalPoints'] = $this->teamData->total_points;
        $this->team['place'] = $this->teamData->getPlace();
    }
}