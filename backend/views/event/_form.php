<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

use backend\models\Address;
use backend\models\Organisation;
use kartik\base\BootstrapInterface;

//use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker ;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <!--<p> загрузка изображения пока неработает</p>-->

    <?php
    if(!empty($model->picture)){ 
        if(stristr($model->picture,'upload/event/')){
            $ht = 'http';
            if (isset($_SERVER['HTTPS'])) $ht =' https';
            echo Html::img($ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->picture, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
        } else {
            echo Html::img($model->picture, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
        }
        echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['events/deleteimage', 'id' => $model->id], [
            'onclick'=>
                 "$.ajax({
                     type:'POST',
                     cache: false,
                     url: '".Url::to(['event/deleteimage', 'id' => $model->id])."',
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
    //var_dump($_SERVER['DOCUMENT_ROOT']);
    ?>

    

    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'sliderFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= $form->field($model, 'event_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время в формате Y-m-d H:m:s'],
    'pluginOptions' => [
        'autoclose' => true
    ]
]); ?>

    <?=$form->field($model, 'addressesArray')->checkboxList(Address::find()->select(['st_addr', 'id'])->indexBy('id')->column()) ?>

    <?=$form->field($model, 'organisationArray')->checkboxList(Organisation::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
