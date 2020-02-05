<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

include(Yii::getAlias('@app/views/site/include/smsc_api.php')); // Подключаем api smsc
$this->title = 'Зарегистрируйся в системе';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
/*КЛЮЧИ*/
#define('SITE_KEY', '6LeyVbcUAAAAANxML0_dB3ytPshrz5y2sb41MMIc');
#define('SECRET_KEY', '6LeyVbcUAAAAAHF5esuXPD_yQEbljsYBkPNGRTQM');

// если в массиве $_POST существует ключ g-recaptcha-response, то...
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

<div class="site-signup">
	<div class="row top_page">
		<h2><?= Html::encode($this->title) ?></h2>
		<p>Регистрация даст тебе полный доступ ко всем функциям ресурса, это не займет много времени</p>
	</div>
    <!--<p>Please fill out the following fields to signup:</p>!-->
	<?php 
		#if(isset($_GET['phone'])) { //Данные полученные с 1-ой формы в самом низу
			#$phone = $_GET['phone'];
			#$_SESSION['phone'] = $phone; //Добавляем телефон в сессию
			#$code = rand(1000,9999);
			#$send_sms_control = 0;
			#$_SESSION['code'] = $code; //Добавляем код в сессию 
			#echo '<script>url = window.location.href; var url = url.split("?")[0]; var url = url.substring(0,1); window.history.replaceState({}, document.title, "/" + url);</script>';
			#if(empty($_SESSION['SEND_SMS_CONTROL'])){
			#	list($sms_id, $sms_cnt, $cost, $balance) = send_sms($phone, "Your code: ".$code , 1); // Отправляем смс с кодом юзеру
			#	$send_sms_control = $send_sms_control + 1;
			#	$_SESSION['SEND_SMS_CONTROL'] = $send_sms_control;
			#} 
			#print '
			#<div class="bgreg row">
			#	<form class="form-login form" id="form_code" action="/signup" method="get" accept-charset="utf-8">
			#		<div class="form-group">
			#		<!--<h2><b>Ваш код</b></h2>!-->
			#		<div class="g-recaptcha" data-sitekey="6LeyVbcUAAAAANxML0_dB3ytPshrz5y2sb41MMIc"></div>

			#		<div class="text-danger" id="recaptchaError"></div>
			#		<!--<p style="color:#aaa;font-size:10pt;">Введите код, отправленный вам по номеру Х(ХХХ) ХХХ ХХ ХХ в предыдущем шаге</p>
			#		<input id="code" name="code" class="input-login  form-control" type="text" placeholder="Введите код" value="" maxlength="4" required="required">!-->
			#		<input id="phone" name="phone" class="form-control" type="hidden" value="'.$phone.'" required="required" readonly>
			#		</div>
			#		<input type="submit" value="Отправить" id="go_reg" class="login_btn btn btn-info">
			#	</form>
			#</div>
			#';
		#if($_SESSION['robot']  == 'not robot' && isset($_GET['phone']) == $_SESSION['phone']) { // Показываем форму регистрации
			?>
			<script>
				//document.getElementById("form_code").remove(); //Удаляем форму, чтобы не дать хитрым юзерам спамить 
			</script>
		    <div class="bgreg row">
		        <div class="form-login">
		            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

		            	<?php
		            		if ($_COOKIE['gameCookie'] == 'KRxVuPXq5j38ZU') {
		            			echo 'Для получения сертификата <a href="/login">войдите</a> или <a href="/signup">зарегистрируйтесь</a>,<br> затем отредактируйте профиль, добавив имя и фамилию,<br>после чего в профиле в разделе портфолио Вы обнаружите свой сертификат';
		            		}
		            	?>

						<h2><b>Придумайте логин и пароль</b></h2>
						<p style="color:#aaa;font-size:10pt;">А так же введите e-mail</p>
						
		                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

		                <?= $form->field($model, 'email')->label('Email') ?>
						<?php #$phones = $_SESSION['phone']; ?> <!-- Номер телефона пользователя из сессии !-->
		                <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::className(),['mask' => '+7 999 999-99-99'])->label('Ваш номер телефона') ?>

		                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

		                <div class="form-group">
		                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'login_btn btn btn-primary', 'name' => 'signup-button']) ?>
		                </div>
						<p>Нажимая на кнопку, вы принимаете <a href="/doc/Политика в отношении обработки персональных данных.pdf" target="_blank">политику конфиденциальности</a> и даёте разрешение на обработку персональных данных.
		            <?php ActiveForm::end(); ?>
		        </div>
		    </div>
		<?php
		#}

		#}
		#else {
		#		// 1-ая форма с номером телефона
		#		print '
		#		<div class="bgreg row">
		#			<form class="form-login form" id="phone_form" action="/signup" method="GET" accept-charset="utf-8">
		#				<div class="form-group">
		#				<h2><b>Ваш номер телефона</b></h2>
		#				<p style="color:#aaa;font-size:10pt;">Пожалуйста, используйте действительный номер, на него придет SMS с кодом для подтверждения</p>
		#				<input id="phone" name="phone" class="input-login form-control" type="text" placeholder="Введите номер телефона" required="required">
		#				</div>
		#				<input type="submit" value="Отправить" id="go_code" class="login_btn btn btn-info">
		#			</form>
		#		</div>
		#		';
		#	
		#
	?>


</div>

  <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
var captcha = grecaptcha.getResponse();
 
// 2. Если ответ пустой, то выводим сообщение о том, что пользователь не прошёл тест.
// Такую форму не будем отправлять на сервер.
if (!captcha.length) {
  // Выводим сообщение об ошибке
  $('#recaptchaError').text('* Вы не прошли проверку "Я не робот"');
} else {
  // получаем элемент, содержащий капчу
  $('#recaptchaError').text('');
}
 
// 3. Если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
if ((formValid) && (captcha.length)) {
  ...
  // добавить в formData значение 'g-recaptcha-response'=значение_recaptcha
  formData.append('g-recaptcha-response', captcha);
  ...
}  
  
// 4. Если сервер вернул ответ error, то делаем следующее...
// Сбрасываем виджет reCaptcha
grecaptcha.reset();
// Если существует свойство msg у объекта $data, то...
if ($data.msg) {
  // вывести её в элемент у которого id=recaptchaError
  $('#recaptchaError').text($data.msg);
}
    </script>
