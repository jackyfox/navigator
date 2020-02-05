<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\bootstrap\ActiveForm;
use backend\models\Competence;
/* @var $this yii\web\View */
/* @var $model backend\models\Profession */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profession-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <!-- $form->field($model, 'img')->textInput(['maxlength' => true]) -->
    <?php
    if(!empty($model->img)){ 
        if(stristr($model->img,'upload/profession/')){
            $ht = 'http';
            if (isset($_SERVER['HTTPS'])) $ht =' https';
            echo Html::img($ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->img, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
        } else {
            echo Html::img($model->img, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
        }
        echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['profession/deleteimage', 'id' => $model->id], [
            'onclick'=>
                 "$.ajax({
                     type:'POST',
                     cache: false,
                     url: '".Url::to(['profession/deleteimage', 'id' => $model->id])."',
                     success  : function(response) {
                         $('.link-del').html(response);
                         $('.postImg').remove();
                     }
                  });
             return false;
             $('.postImg').remove(); // Удалить превью картинки
             ",
             'class' => 'link-del'
        ]);
    } 
    ?>
    <?php/* 
            for ($i=0; $i < 10; $i++) { 
                $im = Yii::$app->getSecurity()->generateRandomString(16);
                print('<p>'.$im.'</p>');
            } */
    ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'low_salary')->textInput() ?>

    <?= $form->field($model, 'high_salary')->textInput() ?>

    <?=$form->field($model, 'competencesArray')->checkboxList(Competence::find()->select(['name','id' ])->indexBy('id')->column()) ?>
    <!--date("Y-m-d H:i:s")--> 
    <!--<?= $form->field($model, 'created_at')->textInput() ?>-->
    <?php if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='profession/update')
    echo $form->field($model, 'updated_at')->textInput(['readonly' => true,'value'=>date("Y-m-d H:i:s")]) ?>

    <?= $form->field($model, 'deleted_at')->hiddenInput(['value'=>''],)->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); 
    if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='profession/update') {?>
        <script type="text/javascript">
            var clock = document.getElementById('profession-updated_at');

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
