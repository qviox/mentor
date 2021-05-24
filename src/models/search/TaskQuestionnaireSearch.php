<?php
namespace qviox\mentor\models\search;
use qviox\mentor\models\scores\TaskInput;
use yii\data\ActiveDataProvider;
use yii\db\Query;
class TaskQuestionnaireSearch
{
    public  $query;
    public $task_inputs;
    public $task_inputs_all;
    public $filters=null;
    /*
     *  $filters=[
     *      'FilterByVal'=>['task_input_name'=>'filter_value', ..],
     *      'FilterByUserIds'=>[1,2,4],
     *      'FilterByAccessLevel'=>[1,2,5],
     *  ]
    */
    public $userIds;
    public $task_id;
    public $user_table;
    public $select_text_input=true;
    public $needTaskInput=null;

    const FilterByVal='FilterByVal';
    const FilterByUserIds='FilterByUserIds';
    const FilterByAccessLevel='FilterByAccessLevel';


    public  function makeQuery(){
        $this->query=new Query();
        $this->user_table=\Yii::$app->getModule('mentor')->userTable;
        $task_inputs=TaskInput::find()->where(['task_id'=>$this->task_id]);
        if($this->needTaskInput)
            $task_inputs->andWhere(['in','name',$this->needTaskInput]);
        if($this->filters[self::FilterByAccessLevel])
            $task_inputs->andWhere(['in','access_level',$this->filters[self::FilterByAccessLevel]]);
        if(!$this->select_text_input)
             $task_inputs->andWhere(['!=','type',TaskInput::TYPE_TEXT]);
        $task_inputs=$task_inputs->all();
        $task_inputs_all=TaskInput::find()->where(['task_id'=>$this->task_id])->all();
        foreach ($task_inputs_all as $item) {
            $this->task_inputs_all[$item->name]=$item;
        }
        if(!$task_inputs)
            $this->query->andWhere(['task_input_id'=>-1]);
        $tast_input_select_as_col=',(SELECT email FROM `'.$this->user_table.'` WHERE maintiv.user_id=id limit 1) as email';
        foreach($task_inputs as $task_input){
            $this->task_inputs[$task_input->name]=$task_input;
            $taskInputsIds[]=$task_input->id;
            $tast_input_select_as_col.=',(SELECT val FROM `mentor_task_input_value` WHERE maintiv.user_id=user_id AND task_input_id='.$task_input->id.' limit 1) AS "'.$task_input->name.'"';
            $task_inputs_label[$task_input->name]=$task_input->title;

        }
        if($taskInputsIds)
            $this->query->andWhere(['in','task_input_id',$taskInputsIds]);
        $this->query->groupBy('user_id');
        $this->query->select(' user_id, '.$tast_input_select_as_col)
            ->from('mentor_task_input_value as maintiv');

        if($this->filters)
            $this->makeFilters();

    }
    public function addFilterByVal($task_input,$filter_val){
            $filter_query=null;
            switch ($task_input->type){
                case TaskInput::TYPE_NUBMER:
                case TaskInput::TYPE_BOOL_YES_NO:
                    $filter_query='val = '.$filter_val.'';
                    break;
                case TaskInput::TYPE_TEXT:
                case TaskInput::TYPE_STRING:
                    $filter_query="val like '%".$filter_val."%'";
                    break;
                default:
                    break;
            }
            if($filter_query)
                $this->query->andWhere('exists (select id from mentor_task_input_value WHERE task_input_id='.$task_input->id.' AND '.$filter_query.' AND user_id=maintiv.user_id limit 1)');
    }
    public function makeFilters(){
        if($this->filters)
            foreach($this->filters as $filter_name=>$filter){
                switch($filter_name){
                    case self::FilterByVal:

                        foreach($filter as $field_name=>$field_value){

                            if(strlen($field_value))
                                $this->addFilterByVal($this->task_inputs_all[$field_name],$field_value);
                        }
                        if(strlen($filter['user_id']))
                            $this->query->andWhere(['user_id'=>$filter['user_id']]);
                        if(strlen($filter['email']))
                            $this->query->andWhere("exists (select id from ". $this->user_table." WHERE email like '%".$filter['email']."%' AND id=maintiv.user_id limit 1)");
                        break;
                    case self::FilterByUserIds:
                        $this->query->andWhere(['in','user_id',$filter]);


                    default:
                        break;

                }
            }
    }
    public function search()
    {
        $this->makeQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
        ]);

        return $dataProvider;
    }
}