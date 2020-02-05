<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title =$arrayFullEvent['title'];

$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['/event']];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$arrayFullEvent['picture']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-9"><h3><?=$arrayFullEvent['title']?></h3>
			<div id="button_favorite">
				<?php
				if (Yii::$app->user->isGuest) {

	            } else {  if(empty($arrayViewFavoriteUserEvent)) { ?>
		
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite btn">Добавить в избранное</a>
				<?php } else { ?>
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite_del btn">Удалить из избранного</a>

				<?php } } ?>
        
        <?php
        if (Yii::$app->user->isGuest) {

              } else {  if(empty($getNoti)) { ?>
        
		<div class="notification-btn">
        <a useridnoti="<?=Yii::$app->user->id?>" class="btn btn-info notification-off glyphicon glyphicon-bell notification-tooltip" id="noti_add">
		<span class="notification-tooltiptext">Оповестить о начале</span>
		</a>
		</div>
        <?php } else { ?>
		<div class="notification-btn">
        <a useridnoti="<?=Yii::$app->user->id?>" class="btn btn-info notification-on glyphicon glyphicon-bell notification-tooltip" id="del_noti">
		<span class="notification-tooltiptext">Отказаться от оповещения</span>
		</a>
		</div>
        <?php } } ?>
			</div>
		</div>
	</div>	
	<div class=""><?=$arrayFullEvent['description']?></div>

	<div class="slider_prof">
	<?php if(!empty($getSlider)) { ?> 
    <h3><b>Слайдер</b></h3> 
  <?php } ?>
	<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel" style="margin:0px auto; width:100%;">
    	<!-- Carousel indicators 
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        Wrapper for carousel items -->
        <div class="carousel-inner">
        	<?php
        		if(empty($getSlider)) {

        		}
        		else {
	        		foreach ($getSlider as $keySlider) {
	        			print '
	        				<div class="item">
				                <img src="'.$keySlider['img'].'" alt="First Slide">
				         		<!--<div class="carousel-caption">
				                  <h3>First slide label</h3>
				                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				                </div>!-->
				            </div>
	        			';
	        		}
        		}
            ?>
        </div>
                <?php 
        if(empty($getSlider)) 
        {

        }
        else {
        	        print '
			        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
			            <span class="glyphicon glyphicon-chevron-left"></span>
			        </a>
			        <a class="carousel-control right" href="#myCarousel" data-slide="next">
			            <span class="glyphicon glyphicon-chevron-right"></span>
			        </a>';
        }
        ?>
    </div>
	</div>
	
	<div class="since_prof">
		<?php if(!empty($arrayOrg)) { ?><h3><b>Организация</b></h3> <?php } ?>
		<div class="multiple-items">
			<?php foreach ($arrayOrg as $keyOrg) { 
				print '
					<div class="prof_review">
						<a href="/jobview?id='.$keyOrg['id'].'">
							<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
							<h4>'.$keyOrg['name'].'</h4>
						</a>
					</div>
				';
				
		  	} ?>
		</div>
	</div>

	<?php if(!empty($arrayViewAddress)) { ?>
	<div class="map_prof">
		<h3><b>Карта</b></h3>
		<div id="map" style="width: 100%; height: 400px"></div>
	</div>
	<?php } ?>
</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


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
$('.favorite').on('click', function(e) {
	var id = $(this).attr('id');
	var userID = $(this).attr('userid');

    $.ajax({
       url: '/favoriteeventadd',
       type: 'POST',
       data: {'id_event': id, 'userID_event': userID},
       success: function(res){
       		console.log(res);
       		$('#button_favorite').empty();
       		$('#button_favorite').append('<a  userid="'+userID+'" id="'+id+'" class="favorite_del btn btn-danger">Удалить из избранного</a>')
       },
       error: function(){
            alert('Error!');
       }
    });
});
JS;
$this->registerJs($script);
?>
<?php
$script2 = <<< JS
$('.favorite_del').on('click', function(e) {
	var id = $(this).attr('id');
	var userID = $(this).attr('userid');
    $.ajax({
       url: '/favoriteeventdel',
       type: 'POST',
       data: {'id_event': id, 'userID_event': userID},
       success: function(res){
       		console.log(res);
       		$('#button_favorite').empty();
       		$('#button_favorite').append('<a  userid="'+userID+'" id="'+id+'" class="favorite btn btn-warning">Добавить в избранное</a>')

       },
       error: function(){
            alert('Error!');
       }
    });
});
JS;
$this->registerJs($script2);
?>

<?php
$script2 = <<< JS

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

$('#noti_add').on('click', function(e) {
  var id = $.urlParam('id');
  var userID = $(this).attr('useridnoti');
  
    $.ajax({
       url: '/addnoti',
       type: 'POST',
       data: {'idEventNoti': id, 'userIDnoti': userID},
       success: function(res){
          console.log(res);
          location.reload();
       },
       error: function(){
            alert('Error!');
       }
    });
});


$('#del_noti').on('click', function(e) {
  var id = $.urlParam('id');
  var userID = $(this).attr('useridnoti');
  
    $.ajax({
       url: '/delitnoti',
       type: 'POST',
       data: {'idEventNoti_del': id, 'userIDnoti_del': userID},
       success: function(res){
          console.log(res);
          location.reload();
       },
       error: function(){
            alert('Error!');
       }
    });
});

JS;
$this->registerJs($script2);
?>
