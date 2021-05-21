<?php
namespace qviox\mentor\models\search;
use qviox\mentor\models\scores\TaskInput;
use qviox\mentor\models\scores\TaskInputValue;
use qviox\mentor\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Query;
class TaskQuestionnaireSearch extends TaskInputValue
{
    public $email;
    public $id;
    public function rules()
    {
        return [
            [['id','email'], 'safe'],
        ];
    }
    public function getQueryForSearch($task_inputs){

    }
    public function search($task_id,&$task_inputs,$params, $userIds = null)
    {
        $query=new Query();
        $task_inputs=TaskInput::find()->where(['task_id'=>$task_id])->andWhere(['!=','type',TaskInput::TYPE_TEXT])->all();
        $tast_input_name_as_col='';

        foreach($task_inputs as $task_input){
            $taskInputsIds[]=$task_input->id;
            $tast_input_name_as_col.=',(SELECT val FROM `mentor_task_input_value` as tiv  WHERE tiv.user_id=u.id AND tiv.task_input_id='.$task_input->id.' limit 1) AS "'.$task_input->name.'"';

            $task_inputs_label[$task_input->name]=$task_input->title;
        }
        $userIdsFilledTIV=TaskInputValue::find()->select('user_id')->where(['in','task_input_id',$taskInputsIds])->groupBy('user_id')->column();

        $query->select(' u.id,u.email '.$tast_input_name_as_col)
            ->from('user u')
            ->where(['in','u.id',$userIdsFilledTIV])
//            ->where(['u.id'=>89])
//            ->andWhere(['tiv.val'=>1])
//            ->where(['u.id'=>$userIds ?? $this->user_id])
//            ->where(['user_id'=>$user_id])
        ;


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andFilterWhere(['or', ['like', 'email', $this->email]]);
        $query->andFilterWhere(['or', [ 'u.id'=> $this->id]]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'user_id' => $userIds ?? $this->user_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//        ]);


//            ->andFilterWhere(['like', 'project_name', $this->project_name])
//            ->andFilterWhere(['like', 'fio', $this->fio]);

        return $dataProvider;
    }
}