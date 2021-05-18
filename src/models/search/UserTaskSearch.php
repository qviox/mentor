<?php

namespace qviox\mentor\models\search;


use qviox\mentor\models\scores\UserTask;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * Class UserTaskSearch
 * @package app\models\search
 */
class UserTaskSearch extends UserTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'integer']
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
     * @param null $userId
     * @return ActiveDataProvider
     */

    public function search($params, $userId = null)
    {
        $query = UserTask::find()
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
            'user_id' => $userId ? $userId : $this->user_id,
            'task_id' => $this->task_id
        ]);

        return $dataProvider;
    }
}
