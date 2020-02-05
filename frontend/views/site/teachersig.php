<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

include(Yii::getAlias('@app/views/site/include/smsc_api.php')); // Подключаем api smsc
$this->title = 'Регистрация в системе в качестве учителя';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

if(isset($_GET['g-recaptcha-response']) && $_GET['g-recaptcha-response']) {
	$secret = '6LeyVbcUAAAAAHF5esuXPD_yQEbljsYBkPNGRTQM';
	$ip = $_SERVER['REMOTE_ADDR'];
	$response = $_GET['g-recaptcha-response'];
	$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
	$arr = json_decode($rsp, TRUE);
	if($arr['success']){
		$_SESSION['robot'] = 'not robot';
		echo "<script>console.log('good')</script>";
	}
	else {
		$_SESSION['robot'] = 'robot';
		echo "<script>console.log('not good')</script>";
	}
}
?>
<style type="text/css">
	input.form-control{
		width: 100%;
	}
</style>

<!-- Модальное окно -->  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Заполните форму ниже</h4>
      </div>
      <div class="modal-body">
      	<div id="alert" class="alert-success" style="display: none;"></div>
        <form id="getRole">
  			<div class="form-group">
  			  <label for="exampleInputEmail1">Ваш Email - указанный при регистрации</label>
  			  <input type="emailteach" class="form-control" name="emailteach" id="emailteach" aria-describedby="emailHelp" placeholder="email">
  			</div>
  			<div class="form-group">
  			  <label for="exampleInputPassword1">Ваш пароль -  указанный при регистрации</label>
  			  <input type="password" class="form-control" name="passwordteach" id="passwordteach" placeholder="Пароль">
  			</div>
  			<div class="form-group form-check">
  			  <label>Организация в которой вы работаете</label>

          <?php 
            $getSchools = $getSchool;
            echo Select2::widget([
                'name' => 'orgwork',
                'data' =>  ArrayHelper::map($getSchools,'id', 'name'),
                'options' => ['prompt' => 'Выберите из списка ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
            ]);
          ?>
  			</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" id="sendRole" class="btn btn-primary">Отправить</button>
      </div>
    </div>
  </div>
</div>


<div class="site-signup">
	<div class="row top_page">
		<h2><?= Html::encode($this->title) ?></h2>
		<p>Регистрация даст вам расширенный доступ к функциям ресурса, это не займет много времени</p>
	</div>
	<script>
		//document.getElementById("form_code").remove(); //Удаляем форму, чтобы не дать хитрым юзерам спамить 
	</script>
    <div class="bgreg row">
        <div class="form-login">

        <center><p class="btn-info" style="width:100%;cursor: pointer; padding: 10px; border-radius: 5px;" data-toggle="modal" data-target="#myModal"><b>Если вы уже зарегестрированы в системе то нажмите на эту кнопку для <br> получения роли - "Педагог"</b></p></center>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
			
				<h2><b>Придумайте логин и пароль</b></h2>
				<p style="color:#aaa;font-size:10pt;">А также заполните остальные поля регистрационной анкеты</p>
				
                <?= $form->field($model, 'first_name')->textInput(['autofocus' => true])->label('Фамилия') ?>

                <?= $form->field($model, 'last_name')->textInput()->label('Имя') ?>

                <?= $form->field($model, 'patronymic')->textInput()->label('Отчество') ?>
 
                <?=$form->field($model, 'myOrganisation')->widget(Select2::classname(), [
					    'data' => ArrayHelper::map($getSchool,'id', 'name'),
					    'options' => ['prompt' => 'Выберите из списка ...'],
					    'pluginOptions' => [
					        'allowClear' => true
					    ],
					])->label('Место работы');
				?>
				<!--$form->field($model, 'myOrganisation')->dropDownList(ArrayHelper::map($getSchool,'id', 'name'),['options'=>['class'=>'form-control'],'prompt'=>'Выберите из списка ...'])->label('Место работы')*/ -->

                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>

                <?= $form->field($model, 'email')->label('Email') ?>
				
                <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::className(),['mask' => '+7 999 999-99-99'])->label('Ваш номер телефона') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'login_btn btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
				<p>Нажимая на кнопку, вы принимаете <a href="/doc/Политика в отношении обработки персональных данных.pdf" target="_blank">политику конфиденциальности</a> и даёте разрешение на обработку персональных данных.
            <?php ActiveForm::end(); ?>

            
        </div>
    </div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>

<script>

$('#sendRole').on('click', function(e) {

	var emailteach = $('#emailteach').val();
    var passwordteach = $('#passwordteach').val();
    var orgwork = 	$('select[name=orgwork] option:selected').val();

    $.ajax({
       url: '/teacheraddrole',
       type: 'POST',
       data: {'emailteach': emailteach, 'passwordteach': passwordteach, 'orgwork': orgwork},
       success: function(res){
       		console.log(res);
       		if(res == 'Ошибка POST!') {
       			alert('Ошибка POST!');
       		}
       		if(res == 'Ошибка Ajax') {
       			alert('Ошибка Ajax');
       		}
       		if(res == 'Пользователь с такими данными ненайден, если вы уверены в том что вы ввели все верно обратитесь в службу поддеркжи - navigator@adtspb.ru !') {
       			alert('Пользователь с такими данными ненайден, если вы уверены в том что вы ввели все верно обратитесь в службу поддеркжи - navigator@adtspb.ru !');
       		}
       		if(res == 'Роль успешно присовена, войдите в ваш аккаунт <a href="/login" class="btn btn-primary">Войти</a>') {
       			$('#alert').empty();
       			$('#alert').fadeIn('fast');
				    $('#alert').append('<p>'+res+'</p>');
				    $('#sendRole').prop('disabled', true); 
				    $('#getRole').fadeOut('fast');
			    }
          if(res == 'Вы указали не верный пароль') {
            alert('Вы указали не верный пароль!');
          }
			    if(res == '') {
				    console.log('возникла неизвестная ошибка');
			    }

       },
       error: function(){
            alert('Error!');
       }
    });
});


</script>

