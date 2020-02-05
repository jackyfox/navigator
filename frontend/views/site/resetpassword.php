<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

include(Yii::getAlias('@app/views/site/include/smsc_api.php')); // Подключаем api smsc
$this->title = 'Забыли пароль?';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row top_page">
        <h2><?= Html::encode($this->title) ?></h2>
        <p></p>
    </div>
    <!--<p>Please fill out the following fields to signup:</p>!-->
        <?php
                // 1-ая форма с номером телефона
            $session = Yii::$app->session;

            if(empty($session->get('newpwd'))) {
                print '
                <div class="bgreg row"><center>
                    <form class="form-reset-one form">
                        <div class="form-group">
                        <h2><b>Ваш email</b></h2>
                        <p style="color:#aaa;font-size:10pt;">Введите email указанный при регистрации на него придет письмо с подтверждением</p>
                         <input id="email" name="emailResetPwd" class="input-login form-control" type="text" placeholder="Введите email" required="required">
                        </div>
                        <input type="submit" value="Отправить" id="resetpwd" class="resetpwd btn btn-info">
                    </form></center>
                </div>
                ';
            }
            else if(!empty($session->get('newpwd'))  && $session->get('newpwd') == $_GET['hash']) {
                print '
                <div class="bgreg row"><center>
                    <form class="form-reset-two form">
                        <div class="form-group">
                        <h2><b>Новый пароль</b></h2>
                        <p style="color:#aaa;font-size:10pt;">Введите email указанный при регистрации</p>
                         <input id="passnew" name="passwordnew" class="input-login form-control" type="password" placeholder="Введите парооль" required="required">
                         <input id="hash" name="hash" class="input-login form-control" type="hidden" value="'.$_GET['hash'].'" required="required">
                        </div>
                        <input type="submit" value="Отправить" id="sendnewpwd" class="sendnewpwd btn btn-info">
                    </form></center>
                </div>
                ';
            }
            else{
                echo "Ошибка загрузки формы!";
            }
            
        ?>

        

</div>

<?php
$script2 = <<< JS

$(".form-reset-one").submit(function(e) {
    e.preventDefault(); 
    var data = $(this).serializeArray();

    $.ajax({
       url: '/resetpasswordajax',
       type: 'POST',
       data: data,
       success: function(res){
  
                if(res == 'На вашу почту была отпралвенна ссылка для востановления пароля') {
                    alert(res);
                    window.location.reload;
                }
                else{
                    alert(res);
                    window.location.reload;
                }
       },
       error: function(){
            alert('Error!');
       }
    });

});

$(".form-reset-two").submit(function(e) {
    e.preventDefault(); 
    var data = $(this).serializeArray();

    $.ajax({
       url: '/resetpasswordajaxfinal',
       type: 'POST',
       data: data,
       success: function(res){
  
                if(res == 'Данные успешно обновлены!') {
                    alert(res);
                    window.location = '/login';
                }
                else{
                    alert(res);
                    window.location.reload;
                }
       },
       error: function(){
            alert('Error!');
       }
    });

});

JS;
$this->registerJs($script2);
?>
