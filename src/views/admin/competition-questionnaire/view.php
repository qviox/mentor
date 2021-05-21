<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CompetitionQuestionnaire */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Анкеты Конкурсного отбора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="competition-questionnaire-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
           // 'user_id',
            'fio',
            'email',
            'phone',
            'gender',
            'age',
            'region',
            'education',
            'work',
            'work_experience',
            'experience',
            'member_voluntary',
            'professional_qualities',
            'leader_social_change',
            'expectations',
            'created_at',
        ],
    ]) ?>

</div>
