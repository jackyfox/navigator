<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Редактирование профиля';
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['/profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php  if (Yii::$app->user->isGuest) { echo "Доступ запрещен!"; } else { ?>
<div class="site-about">
    <div class="row top_page">
		<h2><?= Html::encode($this->title) ?></h2>
		<p>Расскажите о себе</p>
	</div>
	<div class="bgreg container">
		<?php if(isset($_GET['id'])) { ?>
			 <p> Доступ запрещен! </p>
		<?php } else { ?>
				
			<div class="form-login row">
			<div class="block-profile-edit">
				<form id="upload_ava" enctype="multipart/form-data">
					<center><img id="img-user" class="img-circle" width="100" height="100" src="<?=Yii::$app->user->identity->avatar?>" alt=""></center>
					<br>
					<input type="file" name="avatar_user" id="avatar_user" class="form-control">
					<br>
					<span class="upload btn btn-success">Загрузить</span>
				</form>
			</div>
				<div class="block-profile-edit">
				<h3>Мои компетенции</h3>
				<select name="comp_user" id="comp_user">
					<?php
					foreach ($arrayComp as $keyComp) {
						print'<option value="'.$keyComp['id'].'">'.$keyComp['name'].'</option>';
					}	
					?>
				</select>
				<br>
				<span class="add_comp btn btn-info">Добавить</span>
				<br>
				</div>
				<?php 
				if(!empty($arrayUserComp)) {
					print '<ul style="margin-top: 20px;text-align: left;">';
					foreach ($arrayUserComp as $keyUserComp) {
						print '
							<li>'.$keyUserComp['name'].'<span style="margin-left:20px;" class="del_comp btn btn-danger" idcomp="'.$keyUserComp['id'].'">&#10006</span></li>
						';
					}
					print '</ul>';
				}
				?>
				
				<div class="block-profile-edit">
				<h3>Основная информация</h3>
				<form id="edit_prof">
				  <div class="form-group">
				    <label for="email">Email адрес</label>
				    <input name="email" type="email" class="form-control" id="email" placeholder="Введите email" value="<?=Yii::$app->user->identity->email?>">
				   
				  </div>
				  <div class="form-group">
				    <label for="name">Имя</label>
				    <input name="name" type="text" class="form-control" id="name" placeholder="Введите Имя" value="<?=Yii::$app->user->identity->last_name?>">
				   
				  </div>
				  <div class="form-group">
				    <label for="family">Фамилия</label>
				    <input name="family" type="text" class="form-control" id="family" placeholder="Введите Фамилию" value="<?=Yii::$app->user->identity->first_name?>">
				   
				  </div>
				 <!--<div class="form-group">
				 	<label for="competenc">Мои компетенции</label>
				 	<ul>
				 		<li>Название <span class="btn btn-danger">Убрать</span></li>
				 	</ul>
				 	<select name="" id="" class="form-control"></select>
				 </div>
				 <div class="form-group">
				 	 <label for="family">Где я учусь</label>
				 <select name="schoolUser"  class="form-control" id="schoolUser">!-->
				<div class="form-group">
					<label for="family">Где я учусь</label>
					<?php
					$userSchool = Yii::$app->user->identity->school;
					echo Select2::widget([
                		'name' => 'schoolUser',
                		'data' =>  ArrayHelper::map($getSchoolUser,'id', 'name'),
                		'options' => ['prompt' => 'Выберите из списка ...' , 'value' => $userSchool],
                		'pluginOptions' => [
                  			'allowClear' => true
                		],
            		]);
					#foreach ($getSchoolUser as $getSchoolUser) {
					#	print'<option value="'.$getSchoolUser['id'].'">'.$getSchoolUser['name'].'</option>';
					#}	
					?>
				</div>
				 <!--</select>!-->
				</div>
				 <div class="form-group">
				    <label for="about">Обо мне</label>
				    <textarea class="form-control" name="about"><?=Yii::$app->user->identity->about?></textarea>
									   
				  </div>

				  <button type="submit" class="login_btn btn btn-primary">Сохранить</button>
				</form>
			</div>
			</div>
		<?php } ?>

	</div>
</div>
<?php } ?>

<?php
$script2 = <<< JS
$("#edit_prof").submit(function(e) {
	e.preventDefault(); 
	tinyMCE.triggerSave();
	var data = $(this).serializeArray();

    $.ajax({
       url: '/edituserajax',
       type: 'POST',
       data: data,
       success: function(res){
  
	       		if(res == 'заполните все поля') {
	       			alert('заполните все поля!');
	       		}
	       		if(res == 'данные успешно обновлены!') {
	       			alert('данные успешно обновлены!');
	       			window.location.href = '';
	       		}
       },
       error: function(){
            alert('Error!');
       }
    });

});


$('.add_comp').click(function(){
	var comp_user = $('#comp_user option:selected').val();
	
	$.ajax({
       url: '/editcompuserajax',
       type: 'POST',
       data: {'comp_user': comp_user},
       success: function(res){
  			if(confirm(res)){
			    window.location.reload();  
			}
       },
       error: function(){
            alert('Error!');
       }
    });

});

$('.del_comp').click(function(){
	var del_comp = $(this).attr('idcomp');
	
	$.ajax({
       url: '/delitcompuserajax',
       type: 'POST',
       data: {'del_comp': del_comp},
       success: function(res){
  			if(confirm(res)){
			    window.location.reload();  
			}
       },
       error: function(){
            alert('Error!');
       }
    });

});


$('.upload').on('click', function(e) {
	var file_data = $('#avatar_user').prop('files')[0];

    	if(file_data != undefined) {
			var form_data = new FormData();                  
            form_data.append('avatar_user', file_data);

		    $.ajax({
		       url: '/uploadnewavatar',
		       type: 'POST',
			   contentType: false,
		       processData: false,
		       data: form_data,
		       success: function(res){
		       		if(confirm(res)){
			    		window.location.reload();  
					}
		       		
		       },
		       error: function(){
		            alert('Error!');
		       }
		    });
		 }
    return false;
});



JS;
$this->registerJs($script2);
?>
<script>
	var userSchool = <?php echo Yii::$app->user->identity->school;?>;
	if(userSchool != '') {
		document.querySelector('#schoolUser [value="' + userSchool + '"]').selected = true;

	}
</script>
