<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\bootstrap\ActiveForm;
use backend\models\Organisation;
use backend\models\Address;
use backend\models\Type;
use backend\models\Profession;

use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Organisation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organisation-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    if(!empty($model->img)){ 
        if(stristr($model->img,'upload/organisation/')){
            $ht = 'http';
            if (isset($_SERVER['HTTPS'])) $ht =' https';
            echo Html::img($ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->img, $options = ['class' => 'postImg img-thumbnail', 'id'=>'postImgOrg', 'style' => ['width' => '180px']]);
        } else {
            echo Html::img($model->img, $options = ['class' => 'postImg img-thumbnail', 'id'=>'postImgOrg', 'style' => ['width' => '180px']]);
        }
        echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['organisation/deleteimage', 'id' => $model->id], [
            'onclick'=>
                 "$.ajax({
                     type:'POST',
                     cache: false,
                     url: '".Url::to(['organisation/deleteimage', 'id' => $model->id])."',
                     success  : function(response) {
                        $('.link-del').html(response);
                        if(response == 'Удалено') {
                          $('img#postImgOrg').remove();
                          $('input#organisation-img').attr('value', '');
                       }
                     }
                  });
             return false;
             ",
             'class' => 'link-del'
        ]);
    } 
    ?>

    <p>Выберите картинку или введите адрес</p>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true])?>

    <?php
      if(!empty($model->logo)){ 
          if(stristr($model->logo,'upload/organisation/')){
              $ht = 'http';
              if (isset($_SERVER['HTTPS'])) $ht =' https';
              echo Html::img($ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->logo, $options = ['class' => 'postImg img-thumbnail', 'id'=>'postImgOrgLogo', 'style' => ['width' => '180px']]);
          } else {
              echo Html::img($model->logo, $options = ['class' => 'postImg img-thumbnail', 'id'=>'postImgOrgLogo', 'style' => ['width' => '180px']]);
          }
          echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['organisation/deletelogo', 'id' => $model->id], [
              'onclick'=>
                   "$.ajax({
                       type:'POST',
                       cache: false,
                       url: '".Url::to(['organisation/deletelogo', 'id' => $model->id])."',
                       success  : function(response) {
                           $('.link-del2').html(response);
                           //console.log(response);
                           if(response == 'Удалено'){
                              $('img#postImgOrgLogo').remove();
                              $('input#organisation-logo').attr('value', '');
                            } 
                       }
                    });
               return false;
               ",
               'class' => 'link-del2'
          ]);
      } 
    ?>

    <p>Выберите логотип или введите адрес</p>
    
    <?= $form->field($model, 'fileLogo')->fileInput() ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => true])?>

    <p>используется только добавление картинок в слайдер</p>

    <?= $form->field($model, 'sliderFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>
    
    <!--захочется выпадающий список checkboxList заменить на DropDownList -->
   	<?#$form->field($model, 'typesArray')->checkboxList(Type::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <?php $listType = Type::find()->select(['name', 'id'])->indexBy('id')->column(); ?>
    <?=$form->field($model, 'typesArray')->widget(Select2::classname(),[ 
                'data' => $listType,
                'options' => [
                  'multiple' => true,
                  'placeholder' => 'Choose publishers'

    ]]); ?>

   	<? #$form->field($model, 'addressesArray')->checkboxList(Address::find()->select(['st_addr', 'id'])->indexBy('id')->column()) ?>
    
    <?php $listAdr = Address::find()->select(['st_addr', 'id'])->indexBy('id')->column(); ?>
    <?=$form->field($model, 'addressesArray')->widget(Select2::classname(),[ 
                'data' => $listAdr,
                'options' => [
                  'multiple' => true,
                  'placeholder' => 'Choose publishers'

    ]]); ?>

   	<? #$form->field($model, 'professionsArray')->checkboxList(Profession::find()->select(['name', 'id'])->indexBy('id')->column()) ?>
   
    <?php $listProf =Profession::find()->select(['name', 'id'])->indexBy('id')->column(); ?>
    <?=$form->field($model, 'professionsArray')->widget(Select2::classname(),[ 
                'data' => $listProf,
                'options' => [
                  'multiple' => true,
                  'placeholder' => 'Choose publishers'

    ]]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
