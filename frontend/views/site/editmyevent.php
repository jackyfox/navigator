<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title =$arrayEventInfo['title'];

$this->params['breadcrumbs'][] = ['label' => 'Моя компания', 'url' => ['/mycompany?id='.$_GET['OrgID'].'']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin(); ?>
<form id="editEvent">
<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$arrayEventInfo['picture']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-4 title-editmyevent">
      <h3><input type="text" id="nameEvent" name="nameEvent" class="form-control" style="width: 100%; float: left;margin-bottom: 20px;height:50px;font-size: 20pt;" value="<?=$arrayEventInfo['title']?>" style="color:black;"></h3>

      <form  enctype="multipart/form-data"></form>
      <input type="file" name="imageFileEvent" id="bgevent" ideventbg="<?=$_GET['idEvent']?>" style="padding-top: 10px;"> 
	 
			<div id="preview-event-main" style="overflow: hidden;">
										
			</div>
      <span id="send_bg" class="send_bg btn btn-info">Изменить фон шапки</span>
		</div>
	</form>
		<span class="btn btn-success" id="save_event" style="float: right;">Сохранить основные изменения</span>
	</div>	
	<input type="hidden" id="idEvent" name="idEvent" value="<?=$_GET['idEvent']?>">
	
	<div class="edit-block">
	<h3 class="edit-title">Дата события</h3>
	<input type="text" class="form-control" name="event_time" id="event_time" value="<?=$arrayEventInfo['event_time']?>">
	<h3 class="edit-title">Описание</h3>
	<textarea class="form-control" style="width:100%;" rows="6" name="descriptionEvent" id="descriptionEvent"><?=$arrayEventInfo['description']?></textarea>
	</div>
</form>
	<div class="edit-block">

	<h3 class="edit-title">Слайдер</h3>
	<div id="preview-event-slider-main" style="overflow: hidden;">
										
	</div>
	<!-- <form  enctype="multipart/form-data"></form>
      <input type="file"  multiple="multiple" name="imageFileEventSlider[]" id="sliderevent" ideventslider="<?#$_GET['idEvent']?>"> 
      <span class="slider_add btn btn-info" id="slider_add">Добавить слайд</span> 
     </form>!-->
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'product-form',
                'enableAjaxValidation' => true]]) ?>

   <?= $form->field($model, 'sliderEvent[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('',['class'=>'label label-primary']); ?>
   <p style="font-size: 9pt;color:#4FACFE;margin-left: 0px;margin-top: -12px;">*Выберете от 2 до 10  картинок для загрузки</p>
   <div style=""><button class="btn btn-info" id="go">Загрузить</button></div>

<?php ActiveForm::end() ?>
   
		<p style="color:#4FACFE; margin-left: 0; padding-left:0;">Вы можете вывести только одну картинку на главную страницу событий!*</p>
	<div class="row">
		<?php foreach ($arrayEventSlider as $slider) {
			if($slider['event_main_page'] == 0) {
				print '<div class="col-lg-3" id="sliderdiv'.$slider['id'].'" style="text-align:center;"><center><a data-fancybox="gallery-new" href="'.$slider['img'].'"><img width="150" style="margin-right: 10px;" src="'.$slider['img'].'" class="img img-thumbnail" alt=""></a></center><center><span class="del_slide btn btn-danger" style="margin-top:10px;" edit_slide_del_id="'.$slider['id'].'" edit_slide_del_event_id="'.$_GET['idEvent'].'" name_slide_del="'.$slider['img'].'">Удалить</span><br><span style="margin-top:10px;" class="add_slide_main_page btn btn-success" id_slide="'.$slider['id'].'" id_event_slide="'.$_GET['idEvent'].'" >Добавить на главную</span></center></div>';
			}
			else {
				print '<div id="sliderdiv'.$slider['id'].'" class="col-lg-3" style="text-align:center;"><center><a data-fancybox="gallery-new" href="'.$slider['img'].'"><img width="150" style="margin-right: 10px;" src="'.$slider['img'].'" class="img img-thumbnail" alt=""></a></center><center><span class="del_slide btn btn-danger" style="margin-top:10px;" edit_slide_del_id="'.$slider['id'].'" edit_slide_del_event_id="'.$_GET['idEvent'].'" name_slide_del="'.$slider['img'].'">Удалить</span><br><span style="margin-top:10px;" class="del_slide_main_page btn btn-danger" id_slide_del="'.$slider['id'].'" id_event_slide_del="'.$_GET['idEvent'].'">Удалить с главной</span></center></div>';
			}
			
		}
		?>
		
	</div>	
	</div>
	<div class="edit-block">
	<h3 class="edit-title">Управления организациями события</h3>

	<div class="since_prof">
		<h3><b>Организация</b></h3>
		<select name="org_add_select" class="form-control">
			<?php
				foreach ($getAllCompany as $keyAllOrg) {
					# code...
					print '<option value="'.$keyAllOrg['id'].'" id_event='.$_GET['idEvent'].'>'.$keyAllOrg['name'].'</option>';
				}
			?>
			
			
		</select><br>
		<span class="add_org btn btn-info" id="add_org">Добавить компанию</span>
		<div class="alert alert-success" id="alert_org_add" style="display: none"></div>
		<div class="slider_slick row">
			<?php foreach ($arrayOrg as $keyOrg) { 
				print '
					<div class="prof_review col-lg-4">
						
							<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
							<h4>'.$keyOrg['name'].'</h4>
							<span class="delit_company btn btn-danger" id_org="'.$keyOrg['id'].'" id_event="'.$_GET['idEvent'].'">Удалить</span>
						
					</div>
				';
				
		  	} ?>
		</div>
		<div class="alert alert-danger" id="alert_org_del" style="display: none"></div>
	</div>
	</div>
	<div class="edit-block">
	<h3 class="edit-title">Управления картой события</h3>
	<select name="addrall" class="form-control">
		<?php
			foreach ($getAllAdress as $keyAllAddr) {
				print '
				<option value='.$keyAllAddr['id'].' id="'.$_GET['idEvent'].'">'.$keyAllAddr['st_addr'].'</option>
				';
			}
		?>
	</select>
	<br>
	<span class="btn btn-success" id="add_addres">Добавить</span>
	<div class="alert alert-info" id="alert_adres" style="display: none"></div>
	
	<ul class="list-address">
		<?php
		foreach ($arrayViewAddress as $keyAddr) {
			print '<li>'.$keyAddr['st_addr'].' <span class="del_addr btn btn-danger" id_addr_del="'.$keyAddr['id'].'" id_event_del="'.$_GET['idEvent'].'">&#10006</span></li>';
		}
		?>
		
	</ul>
	<div class="alert alert-danger" id="alert_adres_del" style="display: none"></div>
	</div>
	<div class="map_prof">
		<h3><b>Карта</b></h3>
		<div id="map" style="width: 100%; height: 400px"></div>
	</div>
</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script>
$(document).ready(function() {
    ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map("map", {
            center: [59.9386300, 30.3141300],
            zoom: 8
        }, {
            searchControlProvider: 'yandex#search'
        }),
    <?php 
	
	foreach($arrayViewAddress as $keyMap){
     print'myPlacemark'.$keyMap['id'].' = new ymaps.Placemark('.$keyMap['coords'].', {
            // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
            balloonContentHeader: "Организация",
            balloonContentBody: "'.$keyMap['name'].'",
            balloonContentFooter: "'.$keyMap['st_addr'].'",
            hintContent: "Хинт метки"
        });
    	myMap.geoObjects.add(myPlacemark'.$keyMap['id'].');
        ';
    
      }
    ?>

}
});
</script>

<?php
$script = <<< JS



$('#save_event').on('click', function(e) {
	tinyMCE.triggerSave();
	var nameEvent = $('input[name="nameEvent"]')[0].value;
	var description = $('textarea[name="descriptionEvent"]')[0].value;
	var event_id = $('input[name="idEvent"]')[0].value;
	var event_time = $('input[name="event_time"]')[0].value;

    $.ajax({
       url: '/updateevent',
       type: 'POST',
       data: {'nameEvent': nameEvent, 'descriptionEditEvent': description,'idEvent':event_id,'event_time':event_time},
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

$('#add_addres').on('click', function(e) {
	var id_addr = $('select[name="addrall"] option:selected').attr('value');
	var event_id = $('select[name="addrall"] option:selected').attr('id');
	
    $.ajax({
       url: '/addaddresevent',
       type: 'POST',
       data: {'id_event': event_id, 'id_addr': id_addr},
       success: function(res){
       		console.log(res);
       		$('#alert_adres').empty();
       		$('#alert_adres').fadeIn('fast');
			$('#alert_adres').append('<p>'+res+'</p>');
			$('#alert_adres').fadeOut('slow');

			if(confirm(res)){
			    window.location.reload();  
			}
       },
       error: function(){
            alert('Error!');
       }
    });
});


$('.del_addr').on('click', function(e) {
	var id_addr_del = $(this).attr('id_addr_del');
	var id_event_del = $(this).attr('id_event_del');
	
    $.ajax({
       url: '/delitaddresevent',
       type: 'POST',
       data: {'id_event_del': id_event_del, 'id_addr_del': id_addr_del},
       success: function(res){
       		console.log(res);
       		$('#alert_adres_del').empty();
       		$('#alert_adres_del').fadeIn('fast');
			$('#alert_adres_del').append('<p>'+res+'</p>');
			$('#alert_adres_del').fadeOut('slow');

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
	var event_id = $('select[name="org_add_select"] option:selected').attr('id_event');
	
   $.ajax({
       url: '/addcompanyinevent',
       type: 'POST',
       data: {'id_event': event_id, 'id_orgevent': id_org},
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
	var id_event_del = $(this).attr('id_event');
	
    $.ajax({
       url: '/delitcompanyevent',
       type: 'POST',
       data: {'id_org_del': id_org_del, 'id_event_del': id_event_del},
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

$('.send_bg').on('click', function(e) {
	var file_data = $('#bgevent').prop('files')[0];
	var idEvent = $('#bgevent').attr('ideventbg');
    	if(file_data != undefined) {
			var form_data = new FormData();                  
            form_data.append('bgevent', file_data);
			form_data.append('ideventbg', idEvent);

		    $.ajax({
		       url: '/uploadnewbgevent',
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

$('.add_slide_main_page').on('click', function(e) {
	var id_event_slide = $(this).attr('id_event_slide');
	var id_slide = $(this).attr('id_slide');
	
   $.ajax({
       url: '/mainpageslide',
       type: 'POST',
       data: {'id_event_slide': id_event_slide, 'id_slide': id_slide},
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
	var id_event_slide_del = $(this).attr('id_event_slide_del');
	var id_slide_del = $(this).attr('id_slide_del');
	
   $.ajax({
       url: '/mainpageslidedel',
       type: 'POST',
       data: {'id_event_slide_del': id_event_slide_del, 'id_slide_del': id_slide_del},
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
	var edit_slide_del_event_id = $(this).attr('edit_slide_del_event_id');
	var name_slide_del = $(this).attr('name_slide_del');
	
	$('#sliderdiv'+edit_slide_del_id).remove();

   $.ajax({
       url: '/delitslideevent',
       type: 'POST',
       data: {'edit_slide_del_id': edit_slide_del_id, 'edit_slide_del_event_id': edit_slide_del_event_id,'name_slide_del': name_slide_del},
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

$('.slider_add').on('click', function(e) {
	var ideventslider = $('#sliderevent').attr('ideventslider');
	var imgData = document.getElementById('sliderevent'); 
	
	var formData = new FormData();
	formData.append('ideventslider', ideventslider);

	for (var i = 0; i < imgData.files.length; i++) {                                 
    	formData.append('slider[]', imgData.files[i], imgData.files[i].name);
    } 

   $.ajax({
       url: '/uploadnewslide',
       type: 'POST',
       data: formData,
       processData: false,
       contentType: false,
       multiple: true,
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




	var data_php = $('#event_time').val();

   $("#event_time").datetimepicker({
   	format: 'YYYY-MM-DD HH:mm:Ss'
   	});

   	var time = $("#event_time").data("DateTimePicker");
   	time.date("'+data_php+'");

	

JS;
$this->registerJs($script);
?>


	<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-event-main').empty();
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
          span.innerHTML = ['<div class="col-lg-3" style="margin-top: 10px;"><a data-fancybox="gallery-new-event-main" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-event-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('bgevent').addEventListener('change', handleFileSelect, false);
});


</script>


<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-event-slider-main').empty();
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
          span.innerHTML = ['<div class="col-lg-3" style="margin-top: 10px;"><a data-fancybox="gallery-new-event-main-slider" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-event-slider-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('editmyevent-sliderevent').addEventListener('change', handleFileSelect, false);
});


</script>
<?php Pjax::end(); ?>

