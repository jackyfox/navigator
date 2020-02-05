<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title =$varArrayBlog['title'];

$this->params['breadcrumbs'][] = ['label' => 'Блоги', 'url' => ['/blog']];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$varArrayBlog['img']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-9"><h3><?=$varArrayBlog['title']?></h3></div>
	</div>	
	<div class="text_prof"><?=$varArrayBlog['description']?></div>

</div>
<div class="row bootstrap snippets">
    <div class="container">
        <div class="comment-wrapper">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Комментарии
                </div>
                <div class="panel-body">
                    <?php $id_user = Yii::$app->user->identity->id; if(!empty($id_user)) { ?>
                    <textarea id="commentsTextNew" class="form-control" placeholder="write a comment..." rows="3"></textarea>
                    <br>
                    <button type="button" class="comment_add btn btn-info pull-right">Отправить</button>
                    <?php } ?>
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
                            </div>
                        </li>
                        ';
                    	}
                        ?>
                        </ul>
                    </ul>
                	<?php } else { $id_user = Yii::$app->user->identity->id; if(!empty($id_user)) {  print 'Оставь комментрий и стань первым :) !'; } else { print '<a href="/signup">Зарегестрируйтесь</a> или <a href="/login">войдите</a> что бы оставить комментарий!'; } } ?>
                </div>
            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>
function getUrlParameters(parameter, staticURL, decode){

       var currLocation = (staticURL.length)? staticURL : window.location.search,
           parArr = currLocation.split("?")[1].split("&"),
           returnBool = true;

       for(var i = 0; i < parArr.length; i++){
            parr = parArr[i].split("=");
            if(parr[0] == parameter){
                return (decode) ? decodeURIComponent(parr[1]) : parr[1];
                returnBool = true;
            }else{
                returnBool = false;            
            }
       }

       if(!returnBool) return false;  
}

$('.comment_add').on('click', function(e) {
	var idBlog = getUrlParameters("id", "", true);
    tinyMCE.triggerSave();
	var comments = $("#commentsTextNew").val();
    $.ajax({
       url: '/addcommentblog',
       type: 'POST',
       data: {'idBlog': idBlog, 'commentText': comments},
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

</script>
