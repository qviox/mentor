<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $skillUserProvider yii\data\ActiveDataProvider */
/* @var $teams array */
/* @var $team \app\models\scores\Team */

$this->title = 'Участник: ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Участник', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->email;
?>
<div class="user-update">

    <div class="nav-tabs-custom">

        <div class="tab-content">



            <div class=" skin-green" id="user_role">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',

                ]); ?>
                    <?= $form->field($role, 'user_id')->hiddenInput(['value' => $model->id])->label(false);?>
                     <?= $form->field($role, 'user_role_id')->dropDownList(array_merge(["0"=>"Без роли"],$roles))->label('Роль') ?>

                <?= $form->field($utype, 'user_id')->hiddenInput(['value' => $model->id])->label(false);?>
                <?= $form->field($utype, 'user_type_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => \qviox\mentor\models\UType::getLabels(),
                    'options' => ['placeholder' => 'Выберите тип'],

                ])->label('Тип') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>


        </div>
    </div>
</div>


