<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title =$varArrayTest['title'];

$this->params['breadcrumbs'][] = ['label' => 'Моя компания', 'url' => ['/mycompany?id='.$_GET['OrgID'].'']];
$this->params['breadcrumbs'][] = $this->title;
$userName = Yii::$app->user->identity->username;
?>
<?php Pjax::begin(); ?>

<form id="editEvent">
<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$varArrayTest['img']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-4 title-editmyevent">
      <h3><input type="text" id="nameTest" name="nameTest" class="form-control" style="width: 100%; float: left;margin-bottom: 20px;height:50px;font-size: 20pt;" value="<?=$varArrayTest['title']?>" style="color:black;"></h3>

      <form  enctype="multipart/form-data"></form>
      <input type="file" name="imageFileTest" id="bgtestedit" idtestbg="<?=$_GET['idTest']?>" style="padding-top: 10px;"> 
	 
			<div id="preview-test-main" style="overflow: hidden;">
										
			</div>
      <span id="send_bg" class="send_bg btn btn-info">Изменить фон шапки</span>
		</div>
	</form>
		<span class="btn btn-success" id="save_test" style="float: right;">Сохранить основные изменения</span>
	</div>	
	<input type="hidden" id="idTest" name="idTest" value="<?=$_GET['idTest']?>">
	
	<div class="edit-block">
	<h3 class="edit-title">Выдавать сертификат?</h3>
	<?php 
		if((int)$varArrayTest['certificate'] == 1) {
			$checked = 'checked';
		}
	?>
	<input id="certificate-on" type="checkbox" name="certifikat" <?=$checked?>>
	<label class="certificate-on" for="certificate-on">Поставьте галочку для выдачи сертификата</label><br>
	<style>


iframe
{
    width: 1280px !important;
    height: 786px !important;
    border: 0;

    -ms-transform: scale(0.45);
    -moz-transform: scale(0.45);
    -o-transform: scale(0.45);
    -webkit-transform: scale(0.45);
    transform: scale(0.45);

    -ms-transform-origin: 0 0;
    -moz-transform-origin: 0 0;
    -o-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
}
	</style>
	<a href="#sertChekModal" data-toggle="modal" class="btn btn-info" id="chek_sert">Просмотреть пример сертификата</a>
    <div id="sertChekModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Пример сертификата</h4>
                </div>
                <div class="modal-body">
                	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="/certificate/certificate_main/index.php?idCompany=<?=$_GET['OrgID']?>&idTest=<?=$_GET['idTest']?>&userName=<?=$userName?>"></iframe>
					</div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

	<h3 class="edit-title">Количество опыта за тест</h3>
	<input type="text" class="form-control" name="exp" id="exp" value="<?=$varArrayTest['exp']?>">
	<h3 class="edit-title">Время на прохождение теста</h3>
	<input type="text" class="form-control" name="timeTest" id="timeTest" value="<?=$varArrayTest['timeTest']?>">
	<h3 class="edit-title">Период доступа к тестированию</h3>
	с <input type="text" class="form-control" name="dataStart" id="dataStart" value="<?=$varArrayTest['data_start']?>">
	до <input type="text" class="form-control" name="dataEnd" id="dataEnd" value="<?=$varArrayTest['data_end']?>">
	<h3 class="edit-title">Описание</h3>
	<textarea class="form-control" style="width:100%;" rows="6" name="descriptionTest" id="descriptionTest"><?=$varArrayTest['description']?></textarea>
	</div>
</form>
	<div class="edit-block">

	<h3 class="edit-title">Слайдер</h3>
	<div id="preview-test-slider-main" style="overflow: hidden;">
										
	</div>
	<!-- <form  enctype="multipart/form-data"></form>
      <input type="file"  multiple="multiple" name="imageFileEventSlider[]" id="sliderevent" ideventslider="<?#$_GET['idEvent']?>"> 
      <span class="slider_add btn btn-info" id="slider_add">Добавить слайд</span> 
     </form>!-->
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'product-form',
                'enableAjaxValidation' => true]]) ?>

   <?= $form->field($model, 'sliderTest[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('',['class'=>'label label-primary']); ?>
   <p style="font-size: 9pt;color:#4FACFE;margin-left: 0px;margin-top: -12px;">*Выберете от 2 до 10  картинок для загрузки</p>
   <div style=""><button class="btn btn-info" id="go">Загрузить</button></div>

<?php ActiveForm::end() ?>
   
		<p style="color:#4FACFE; margin-left: 0; padding-left:0;">Вы можете вывести только одну картинку на главную страницу событий!*</p>
	<div class="row">
		<?php foreach ($sliderArray as $slider) {
			if($slider['test_main_page'] == 0) {
				print '<div class="col-lg-3" id="sliderdiv'.$slider['id'].'" style="text-align:center;"><center><a data-fancybox="gallery-new" href="'.$slider['img'].'"><img width="150" style="margin-right: 10px;" src="'.$slider['img'].'" class="img img-thumbnail" alt=""></a></center><center><span class="del_slide btn btn-danger" style="margin-top:10px;" edit_slide_del_id="'.$slider['id'].'" edit_slide_del_test_id="'.$_GET['idTest'].'" name_slide_del="'.$slider['img'].'">Удалить</span><br><span style="margin-top:10px;" class="add_slide_main_page btn btn-success" id_slide="'.$slider['id'].'" id_test_slide="'.$_GET['idTest'].'" >Добавить на главную</span></center></div>';
			}
			else {
				print '<div id="sliderdiv'.$slider['id'].'" class="col-lg-3" style="text-align:center;"><center><a data-fancybox="gallery-new" href="'.$slider['img'].'"><img width="150" style="margin-right: 10px;" src="'.$slider['img'].'" class="img img-thumbnail" alt=""></a></center><center><span class="del_slide btn btn-danger" style="margin-top:10px;" edit_slide_del_id="'.$slider['id'].'" edit_slide_del_test_id="'.$_GET['idTest'].'" name_slide_del="'.$slider['img'].'">Удалить</span><br><span style="margin-top:10px;" class="del_slide_main_page btn btn-danger" id_slide_del="'.$slider['id'].'" id_test_slide_del="'.$_GET['idTest'].'">Удалить с главной</span></center></div>';
			}
			
		}
		?>
		
	</div>	
	</div>
	<div class="edit-block edit-test">
	<h3 class="edit-title">Вопросы тестирования</h3>
	<?php 

		if(!empty($varArrayTest['ArrayWithQuerstion'])) {

			#print '<h2>Тест: '.$varArrayTest['title'].'</h2>';

			$json_str = '{"tests":'.$varArrayTest['ArrayWithQuerstion'].'}';

			$obj = json_decode($json_str); // получим объект
		

			$tests = $obj->tests;


			echo '<form id="test-form">
				<div id="question-group">';
		

			foreach ($tests as $key => $keyJson) {
				$key_count = (int)$key;
				if ($key_count == 0) continue;
				 //это тоже самое что count в tp.js
				echo '<div class="questions" id="questions'.$key_count.'"/>';
				if(!empty($keyJson->qustion)) {
					//echo '<p>Вопрос:</p><input class="question" name="qustion" type="text" value="'.$keyJson->qustion.'"/>';
					//echo '<p>Ответы:</p>';
					echo '<div class="form-group">
						<label for="test-question" class="col-form-label">Вопрос №'.$key_count.'</label>
						<input type="text" class="form-control" id="test-question'.$key_count.'" name ="test-question'.$key_count.'" value="'.$keyJson->qustion.'" required>
					</div>
					<p>Варианты ответа вопроса №'.$key_count.':</p>';

				}
				#echo $key;
				#var_dump(count($keyJson->truevariant));
				foreach ($keyJson->variant as $key => $variant) {
					echo '<div class="form-check">';
					$key_variant = $key; //это тоже самое что variant в tp.js
					#var_dump($key_variant);

					foreach ($keyJson->truevariant as $key => $truevariant) {
						#var_dump($truevariant);
						if($key_variant == $truevariant) {
							$checked = 'checked';
							break 1; 
						}
						else if(empty($truevariant)) {
							$checked = '';
						}
						else {
							$checked = '';
						}

					}
					#var_dump($checked);	
						$id = $variant->inpId;
						$variant_name = $variant->inpVal;
						
						if($keyJson->type == 'radio') {	
							echo '<label class="form-check-label" for="q'.$key_count.'_variant'.$key_variant.'">Вариант '.$key_variant.'</label>
								<input type="text" class="f" id="q'.$key_count.'_variant'.$key_variant.'" name="q'.$key_count.'_variant'.$key_variant.'" value="'.$variant_name.'" required >
								<input class="form-check-input" type="radio" value="" '.$checked.' id="q'.$key_count.'_ch'.$key_variant.'" name="q'.$key_count.'_ch" for="q'.$key_count.'_variant'.$key_variant.'">';
							//print '<div class="answer"><input name="radio_variant" '.$checked.' type="radio" ><input type="text" value="'.$variant.'" required/></div>';
						}
						if($keyJson->type == 'checkbox') {
							echo '<label class="form-check-label" for="q'.$key_count.'_variant'.$key_variant.'">Вариант '.$key_variant.'</label>
								<input type="text" class="f" id="q'.$key_count.'_variant'.$key_variant.'" name="q'.$key_count.'_variant'.$key_variant.'" value="'.$variant_name.'" required >
								<input class="form-check-input" type="checkbox" value="" '.$checked.' id="q'.$key_count.'_ch'.$key_variant.'" name="q'.$key_count.'_ch'.$key_variant.'" for="q'.$key_count.'_variant'.$key_variant.'">';
							//print '<div class="answer"><input name="checkbox_variant" '.$checked.' type="checkbox" ><input type="text" value="'.$variant.'"required></div>';
						}

					echo "</div>";
				}
				echo '</div>';
			}
			print '</div>
			<div id="button-group">
				<hr>
	        	<p style="background: transparent !important;">Добавление вопроса теста</p>
	        	<p style="background: transparent !important;">Выберите тип вопроса:</p>
	          	<button type="button" class="btn btn-info" id="checkbox-group">Checkbox groop</button>
	            <button type="button" class="btn btn-info" id="radio-group">Radio groop</button>
	        </div>
			<span id="test_send" class="btn btn-info">Отправить</span>';

			echo "</form>";

		}
	?>
	</div>
	<div class="edit-block">
	<h3 class="edit-title">Управления организациями - тестирования</h3>

	<div class="since_prof">
		<h3><b>Организация</b></h3>
		<select name="org_add_select" class="form-control">
			<?php
				foreach ($getAllCompany as $keyAllOrg) {
					# code...
					print '<option value="'.$keyAllOrg['id'].'" id_test='.$_GET['idTest'].'>'.$keyAllOrg['name'].'</option>';
				}
			?>
			
			
		</select><br>
		<span class="add_org btn btn-info" id="add_org">Добавить компанию</span>
		<div class="alert alert-success" id="alert_org_add" style="display: none"></div>
		<div class="slider_slick row">
			<?php foreach ($varArrayOrg as $keyOrg) { 
				print '
					<div class="prof_review col-lg-4">
						
							<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
							<h4>'.$keyOrg['name'].'</h4>
							<span class="delit_company btn btn-danger" id_org="'.$keyOrg['id'].'" id_test="'.$_GET['idTest'].'">Удалить</span>
						
					</div>
				';
				
		  	} ?>
		</div>
		<div class="alert alert-danger" id="alert_org_del" style="display: none"></div>
	</div>
	</div>


	</div>
</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>




	<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-test-main').empty();
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<div class="col-lg-3" style="margin-top: 10px;"><a data-fancybox="gallery-new-test-main" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-test-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('bgtestedit').addEventListener('change', handleFileSelect, false);
});


</script>


<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-test-slider-main').empty();
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<div class="col-lg-3" style="margin-top: 10px;"><a data-fancybox="gallery-new-test-main-slider" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-test-slider-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('testedit-slidertest').addEventListener('change', handleFileSelect, false);


});



</script>



<?php 

$script = <<< JS

$('.send_bg').on('click', function(e) {
	var file_data = $('#bgtestedit').prop('files')[0];
	var idTest= $('#bgtestedit').attr('idtestbg');
    	if(file_data != undefined) {
			var form_data = new FormData();                  
            form_data.append('bgtestedit', file_data);
			form_data.append('idTest', idTest);

		    $.ajax({
		       url: '/editmainimagetest',
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


$('#save_test').on('click', function(e) {
	tinyMCE.triggerSave();
	
	if($('input[name=certifikat]').is(':checked')) {
       var certifikat = 1;
    }
    else {
	   var certifikat = 0;
    }
	
	var descriptionTest = $('#descriptionTest').val();
	var exp = $('#exp').val();
	var timeTest = $('#timeTest').val();
	var dataStart = $('#dataStart').val();
	var dataEnd = $('#dataEnd').val();
	var idTest = $('#idTest').val();
	var nameTest = $('#nameTest').val();

	certifikat = certifikat.toString();

	
	$.ajax({
       url: '/edittest',
       type: 'POST',
       data: {'idTest': idTest, 'certifikat': certifikat,'nameTest': nameTest, 'descriptionTest': descriptionTest,'exp': exp,'timeTest': timeTest,'dataStart': dataStart,'dataEnd': dataEnd,},
       success: function(res){
       		console.log(res);

			if(confirm(res)){
			    window.location.reload();  
			}
       },
       error: function(){
            alert('Error!');
       }
    });

});


$('span.add_org').on('click', function(e) {
	var id_org = $('select[name="org_add_select"] option:selected').attr('value');
	var id_test = $('select[name="org_add_select"] option:selected').attr('id_test');
	
   $.ajax({
       url: '/addcompanyintest',
       type: 'POST',
       data: {'id_test': id_test, 'id_orgtest': id_org},
       success: function(res){
       		console.log(res);
       		$('#alert_org_add').empty();
       		$('#alert_org_add').fadeIn('fast');
			$('#alert_org_add').append('<p>'+res+'</p>');
			$('#alert_org_add').fadeOut('slow');

			if(confirm(res)){
			    window.location.reload();  
			}
       },
       error: function(){
            alert('Error!');
       }
    });
});

$('.delit_company').on('click', function(e) {
	var id_org_del = $(this).attr('id_org');
	var id_test_del = $(this).attr('id_test');
	
    $.ajax({
       url: '/delitcompanytest',
       type: 'POST',
       data: {'id_org_del': id_org_del, 'id_test_del': id_test_del},
       success: function(res){
       		console.log(res);
       		$('#alert_org_del').empty();
       		$('#alert_org_del').fadeIn('fast');
			$('#alert_org_del').append('<p>'+res+'</p>');
			$('#alert_org_del').fadeOut('slow');

			if(confirm(res)){
			    window.location.reload();  
			}

       },
       error: function(){
            alert('Error!');
       }
    });
});



$('.add_slide_main_page').on('click', function(e) {
	var id_test_slide = $(this).attr('id_test_slide');
	var id_slide = $(this).attr('id_slide');
	
   $.ajax({
       url: '/mainpageslidetest',
       type: 'POST',
       data: {'id_test_slide': id_test_slide, 'id_slide': id_slide},
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

$('.del_slide_main_page').on('click', function(e) {
	var id_test_slide_del = $(this).attr('id_test_slide_del');
	var id_slide_del = $(this).attr('id_slide_del');
	
   $.ajax({
       url: '/mainpageslidedeltest',
       type: 'POST',
       data: {'id_test_slide_del': id_test_slide_del, 'id_slide_del': id_slide_del},
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


$('.del_slide').on('click', function(e) {
	var edit_slide_del_id = $(this).attr('edit_slide_del_id');
	var edit_slide_del_test_id = $(this).attr('edit_slide_del_test_id');
	var name_slide_del = $(this).attr('name_slide_del');
	
	$('#sliderdiv'+edit_slide_del_id).remove();

   $.ajax({
       url: '/delitslidtest',
       type: 'POST',
       data: {'edit_slide_del_id': edit_slide_del_id, 'edit_slide_del_test_id': edit_slide_del_test_id,'name_slide_del': name_slide_del},
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


JS;
$this->registerJs($script);

?>
<?php Pjax::end(); ?>

