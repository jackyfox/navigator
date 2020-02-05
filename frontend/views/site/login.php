<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Уже есть аккаунт?';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="">
	<div class="row top_page">
		<h2><?= Html::encode($this->title) ?></h2>
		<p> </p>
	</div>

    

    <div class="row"  style="background-color: #f8f8f8;">
        <div class="form-login" style="">
            <?php 
                if ($_COOKIE['gameCookie'] == 'KRxVuPXq5j38ZU') {
                    echo 'Для получения сертификата <a href="/login">войдите</a> или <a href="/signup">зарегистрируйтесь</a>,<br> затем отредактируйте профиль, добавив имя и фамилию,<br>после чего в профиле в разделе портфолио Вы обнаружите свой сертификат';
                }
            ?>
        	<h2><b>Введите логин и пароль</b></h2>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

				
                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class'=>'input-login form-control'])->label('Логин') ?>

                <?= $form->field($model, 'password')->passwordInput(['class'=>'input-login form-control'])->label('Пароль') ?>
                <font color="#dedede" style="font-size: 9pt;"><?= Html::a('Забыли пароль?', ['/resetpassword']) ?></font>

                <div class="btn-remember">

               	  <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>
                  <a href="/signup" style="color: #aaa;float: right;margin-top: 0px;">Нет аккаунта?</a>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'login_btn btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
