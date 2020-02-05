<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Competence */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competence-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'created_at')->textInput() ?>-->

    <?= $form->field($model, 'deleted_at')->hiddenInput(['value'=>''])->label(false) ?>

    <?php if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='competence/update') echo $form->field($model, 'updated_at')->textInput(['readonly' => true]) ;?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); 
    if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='competence/update') {?>
        <script type="text/javascript">
            var clock = document.getElementById('competence-updated_at');

            setInterval(function(){
              clock.value = getCurrentTime();
            }, 1);

            function getCurrentTime() {
              let currentDate = new Date();
              let hours = currentDate.getHours();
              let minutes = currentDate.getMinutes();
              let seconds = currentDate.getSeconds() < 10 ? '0' + currentDate.getSeconds() : currentDate.getSeconds();
              let phpdate = '<?= date("Y-m-d ")?>';
              var currentTime = phpdate + hours + ':' + minutes + ':' + seconds;
              return currentTime;
            }
        </script>
    <?php } ?>
</div>
