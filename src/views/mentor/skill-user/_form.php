<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user \app\models\User */
/* @var $model app\models\scores\SkillUserPoint */
/* @var $form yii\widgets\ActiveForm */
/* @var $availableSkills array */

$availableSessions = $model->isNewRecord ? $availableSessions : [$model->session_id => $model->session->name];
$availableSkills = $model->isNewRecord ? [] : [$model->skill_id => $model->skill->name];
?>
    <div class="skill-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php if ($user && $model->isNewRecord): ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value' => $user->id])->label(false) ?>
        <?php endif; ?>

        <?= $form->field($model, 'session_id')->dropDownList($availableSessions, ['prompt' => 'Укажите навык', 'disabled' => !$model->isNewRecord ? true : false])->label('Ассесмент-сессия') ?>

        <?= $form->field($model, 'skill_id')->dropDownList($availableSkills, ['prompt' => 'Укажите навык', 'disabled' => !$model->isNewRecord ? true : false])->label('Навык') ?>

        <?= $form->field($model, 'point')->textInput(['type' => 'number', 'default' => 0, 'min' => 0, 'max' => 5000]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php if ($user && $model->isNewRecord): ?>
    <?php ob_start(); // output buffer the javascript to register later ?>
    <script>
        $(document).ready(function () {
            $("#skilluserpoint-session_id").change(function () {
                var userId = $("#skilluserpoint-user_id").val();
                var sessionId = $("#skilluserpoint-session_id").val();

                $.ajax({
                    url: "<?=Url::to(['skill/get-available-skills'])?>",
                    type: 'GET',
                    data: {'user_id' : userId, 'session_id' : sessionId},
                    dataType: 'json',
                    success: function (response) {
                        $('#skilluserpoint-skill_id')
                            .find('option')
                            .remove();

                        $.each(response, function(i, value) {
                            $('#skilluserpoint-skill_id').append($('<option>').text(value).attr('value', i));
                        });
                    }
                });
            });
        });
    </script>
    <?php $this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean()), View::POS_END); ?>
<?php endif; ?>