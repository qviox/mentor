<?php

namespace qviox\mentor\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use qviox\mentor\models\scores\CompetitionQuestionnaire;

/**
 * CompetitionQuestionnaireSearch represents the model behind the search form of `app\models\CompetitionQuestionnaire`.
 */
class CompetitionQuestionnaireSearch extends CompetitionQuestionnaire
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'gender', 'age'], 'integer'],
            [['fio', 'email', 'phone', 'region', 'education', 'work', 'work_experience', 'experience', 'member_voluntary', 'professional_qualities', 'leader_social_change', 'expectations', 'created_at'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CompetitionQuestionnaire::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'age' => $this->age,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'work_experience', $this->work_experience])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'member_voluntary', $this->member_voluntary])
            ->andFilterWhere(['like', 'professional_qualities', $this->professional_qualities])
            ->andFilterWhere(['like', 'leader_social_change', $this->leader_social_change])
            ->andFilterWhere(['like', 'expectations', $this->expectations]);

        return $dataProvider;
    }
}
