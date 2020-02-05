<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = $varArrayBlog['titleBlog'];

$this->params['breadcrumbs'][] = ['label' => 'Моя компания', 'url' => ['/mycompany?id='.$_GET['OrgID'].'']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin(); ?>
<form id="editBlog">
<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$varArrayBlog['imgBlog']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-4 title-editmyevent">
      <h3><input type="text" id="nameBlog" name="nameBlog" class="form-control" style="width: 100%; float: left;margin-bottom: 20px;height:50px;font-size: 20pt;" value="<?=$varArrayBlog['titleBlog']?>" style="color:black;"></h3>
	
      <form  enctype="multipart/form-data"></form>
      <input type="file" name="imageFileBlog" id="bgblog" idblogbg="<?=$_GET['idBlog']?>" style="padding-top: 10px;width: 97px;"> 
	 
			<div id="preview-blog-main" style="overflow: hidden;">
										
			</div>
      <span id="send_bg" class="send_bg btn btn-info">Изменить фон шапки</span>
		</div>
	</form>
		<span class="btn btn-success" id="save_blog" style="float: right;">Сохранить основные изменения</span>
	</div>	
	<input type="hidden" id="idBlog" name="idBlog" value="<?=$_GET['idBlog']?>">
	
	<div class="edit-block">
	<h3 class="edit-title">Описание</h3>
	<textarea class="form-control" style="width:100%;" rows="6" name="descriptionBlog" id="descriptionBlog"><?=$varArrayBlog['description']?></textarea>
	</div>
</form>

</div>

<div class="row bootstrap snippets">
    <div class="container">
        <div class="comment-wrapper">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Комментарии
                </div>
                <div class="panel-body">
                    <div class="clearfix"></div>
                    <hr>
                    <?php if(!empty($getComment)) { ?>
                    <ul class="media-list">
                    	<?php 
                    	foreach($getComment as $getComment) {
                    	
                    	$first_name = $getComment['first_name'];
                    	$last_name = $getComment['last_name'];
                    	$username = $getComment['username'];

                    	if(!empty($fist_name) || !empty($last_name)) {
                    		$name = $first_name.' '.$last_name;
                    	}
                    	else {
                    		$name = $username;
                    	}
                    	print '
                        <li class="media">
                            <a href="#" class="pull-left">
                                <img src="'.$getComment['avatar'].'" alt="" class="img-circle">
                            </a>
                            <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted">'.$getComment['commentsTime'].'</small>
                                </span>
                                <strong class="text-success">'.$name.'</strong>
                                <p>
                                    '.$getComment['commentsText'].'
                                </p>
                                <span class="delComment btn btn-danger" idcomment="'.$getComment['commentsID'].'">Удалить комментарий</span>
                            </div>
                        </li>
                        ';
                        #print_r($getComment);
                    	}
                        ?>
                        </ul>
                    </ul>
                	<?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>


$('#save_blog').on('click', function(e) {
	tinyMCE.triggerSave();
	var nameBlog = $('input[name="nameBlog"]')[0].value;
	var description = $('textarea[name="descriptionBlog"]')[0].value;
	var idBlog = $('input[name="idBlog"]')[0].value;
	var orgId = getUrlVars()["OrgID"];

    $.ajax({
       url: '/editblog',
       type: 'POST',
       data: {'titleBlog': nameBlog, 'textBlogs': description,'idBlog':idBlog,'orgId':orgId},
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

$('.delComment').on('click', function(e) {
	tinyMCE.triggerSave();

	var idBlog = $('input[name="idBlog"]')[0].value;
	var orgId = getUrlVars()["OrgID"];
	var idComment = $(this).attr("idcomment");

    $.ajax({
       url: '/delitcommentblog',
       type: 'POST',
       data: {'idComment': idComment, 'orgId': orgId,'idBlog':idBlog},
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

$('.send_bg').on('click', function(e) {
	var file_data = $('#bgblog').prop('files')[0];
	var idBlog = getUrlVars()["idBlog"];

  if(file_data != undefined) {
			var form_data = new FormData();                  
      form_data.append('bgblog', file_data);
			form_data.append('idblogbg', idBlog);

		    $.ajax({
		       url: '/uploadnewbgblog',
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

</script>


  <script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
  $('#preview-blog-main').empty();
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
          span.innerHTML = ['<div class="col-lg-3" style="margin-top: 10px;"><a data-fancybox="gallery-new-blog-main" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-blog-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('bgblog').addEventListener('change', handleFileSelect, false);
});


</script>


<?php 

Pjax::end(); ?>

