<?php

namespace qviox\mentor\models\search;


use qviox\mentor\models\scores\TeamTask;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * Class TeamTaskSearch
 * @package app\models\search
 */
class TeamTaskSearch extends TeamTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'team_id'], 'integer']
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
     * @param null $teamId
     * @return ActiveDataProvider
     */

    public function search($params, $teamId = null)
    {
        $query = TeamTask::find()
         ->with(['task']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'team_id' => $teamId ? $teamId : $this->team_id,
            'task_id' => $this->task_id
        ]);

        return $dataProvider;
    }
}
