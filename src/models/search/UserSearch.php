<?php

namespace qviox\mentor\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use qviox\mentor\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $type,$role;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','role'],'string'],
            [['id', 'status' , 'backend_status', 'club_id'], 'integer'],
            [['auth_key', 'password_hash', 'password_reset_token', 'email', 'created_at', 'updated_at'], 'safe'],
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
     * @param integer $clubId
     *
     * @return ActiveDataProvider
     */
    public function search($params, $clubId = null)
    {
        $query = User::find()->joinWith('userPointsTable')->select('user.*, sum(user_points.points) as userPoints');

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

        $dataProvider->sort->attributes['userPoints'] = [
            'asc' => ['userPoints' => SORT_ASC],
            'desc' => ['userPoints' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'backend_status' => $this->backend_status,
            'club_id' => $clubId ? $clubId : $this->club_id,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);
        if (!empty($this->created_at))
            $query->andWhere(['between', 'created_at', $this->created_at . ' 00:00:00', $this->created_at . ' 23:59:59']);
        if (!empty($this->updated_at))
            $query->andWhere(['between', 'updated_at', $this->updated_at . ' 00:00:00', $this->updated_at . ' 23:59:59']);


        $query->groupBy('user.id');

        return $dataProvider;
    }

    /**
     * @param array $params
     * @param null $teamIds
     * @return ActiveDataProvider
     */
    public function searchParticipant(array $params, $teamIds = null)
    {
        $query = User::find()
            ->joinWith(['userTasks', 'userTeam'])
            ->select('user.*, sum(mentor_user_task.point) as userPoints')
            ->where(['type' => User::TYPE_PARTICIPANT]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->sort->defaultOrder = [
            'userPoints' => SORT_DESC
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['userPoints'] = [
            'asc' => ['userPoints' => SORT_ASC],
            'desc' => ['userPoints' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id
        ]);

        if ($teamIds) {
            $query->andFilterWhere(['mentor_user_team.team_id' => $teamIds]);
        }

        $query->andFilterWhere(['like', 'email', $this->email]);

        $query->groupBy('user.id');


        return $dataProvider;
    }
    public function searchUserRole(array $params)
    {
        $query = User::find()
            ->joinWith(['userRole'])
            ->joinWith(['userType'])
            ->select('user.*')
            ->orderBy('mentor_user_urole.user_role_id DESC')
             ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);


        $dataProvider->sort->attributes['role'] = [
            'asc' => ['mentor_user_urole.user_role_id' => SORT_ASC],
            'desc' => ['mentor_user_urole.user_role_id' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id
        ]);



        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere([  'mentor_user_urole.user_role_id'=> $this->role]);
        $query->andFilterWhere([  'mentor_user_utype.user_type_id'=> $this->type]);

        $query->groupBy('user.id');


        return $dataProvider;
    }
}
