<?php

namespace qviox\mentor\models\search;


use qviox\mentor\models\scores\SkillSession;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SkillSessionSearch represents the model behind the search form of `app\models\scores\SkillSession`.
 */
class SkillSessionSearch extends SkillSession
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param integer $courseId
     * @return ActiveDataProvider
     */
    public function search($params, $courseId = null)
    {
        $query = SkillSession::find();

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
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
