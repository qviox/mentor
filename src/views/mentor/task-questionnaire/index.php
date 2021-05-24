<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaskQuestionnaireSearch */
/* @var $task \app\models\scores\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $task->name;
$this->params['breadcrumbs'][] = $this->title;

$columns = require __DIR__ . '/_columns.php';
$beforeRow=require __DIR__.'/_filter.php'
?>
<div class="task-questionnaire-index">
    <form id="task_questionnare_form" method="get">
        <input type="hidden" name="taskId" value="<?=$taskId?>">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $columns,
        'beforeRow'=>$beforeRow
    ]); ?>
    </form>
</div>
<?php
$this->registerJs("
document.getElementById('task_questionnare_form').addEventListener('keydown', function(e){
  if (e.keyCode == 13) {
    this.submit();
  } 
})
");
?>