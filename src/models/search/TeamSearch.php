<?php

namespace qviox\mentor\models\search;


use qviox\mentor\models\scores\Team;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TeamSearch represents the model behind the search form of `app\models\scores\Team`.
 */
class TeamSearch extends Team
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mentor_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @param null $mentorId
     * @return ActiveDataProvider
     */
    public function search($params, $mentorId = null)
    {
        $query = Team::find()
            ->with(['userTeams', 'userTeams.user', 'userTeams.user.userTasks', 'mentor'])
            ->joinWith(['teamTasks'])
            ->select([
                'mentor_team.*',
                'sum(mentor_team_task.point) as teamPoints'
            ]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = [
            'total_points' => SORT_DESC
        ];

        $dataProvider->sort->attributes['teamPoints'] = [
            'asc' => ['teamPoints' => SORT_ASC],
            'desc' => ['teamPoints' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'mentor_id' => $mentorId ?? $this->mentor_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->groupBy('id');

        return $dataProvider;
    }
}
