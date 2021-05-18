<?php

use qviox\mentor\models\scores\UserTeam;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $team app\models\scores\Team */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['admin/participants/search']);
$userTeam = new UserTeam();
?>

<div class="team-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['admin/user-team/create', 'toTeamList' => true]
    ]); ?>

    <?= $form->field($userTeam, 'team_id')->hiddenInput(['value' => $team->id])->label(false);?>

    <?= $form->field($userTeam, 'user_id')->widget(Select2::class, [
        'data' => $data,
        'options' => ['multiple' => false, 'placeholder' => 'Поиск участников по email...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Поиск...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {
                    email:params.term              
                }; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(user) { return user.email; }'),
            'templateSelection' => new JsExpression('function (user) { return user.email; }'),
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
