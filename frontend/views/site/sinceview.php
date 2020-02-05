<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = $varArrayFullsince['name'];

$this->params['breadcrumbs'][] = ['label' => 'Где учиться', 'url' => ['/since']];

$this->params['breadcrumbs'][] = $this->title;


$type = $typeOrg['type_id'];

if($type == 4) {
	$id = (int)$_GET['id'];
	print '<script>window.location = "/jobview?id='.$id.'";</script>';
}

?>



<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url(<?=$varArrayFullsince['img']?>) 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-9"><h3><?=$varArrayFullsince['name']?></h3>
			<div id="button_favorite">
				<?php
				if (Yii::$app->user->isGuest) {

	            } else {  if(empty($varViewFavoriteUserSince)) { ?>
		
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite btn">Добавить в избранное</a>
				<?php } else { ?>
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite_del btn">Удалить из избранного</a>

				<?php } } ?>
			</div>
		</div>
		<img src="<?=$varArrayFullsince['logo']?>" id="logo_company" alt="" style="float: right;" width="170"  onerror="this.style.display='none'">
	</div>	
	<p class="text_prof"><?=$varArrayFullsince['description']?></p>

	<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel" style="margin:0px auto; width:78%;">
    	<!-- Carousel indicators 
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        Wrapper for carousel items -->
        <div class="carousel-inner">
        	<?php
        	if(empty($varArrayViewSinceSlider)) {

        	}
        	else {
        		foreach ($varArrayViewSinceSlider as $keySlider) {
        			print '
        				<div class="item">
			                <img src="'.$keySlider['img_org'].'" alt="First Slide">
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
        <!-- Carousel controls -->
        <?php 
        if(empty($varArrayViewSinceSlider)) 
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

	<div class="napravlenie">
		<?php if(!empty($varArrayCompSince)) { ?><h3><b>Направления</b></h3><?php } ?>
		<ul>
			<?php 
				#Компетенции 

				foreach ($varArrayCompSince as $keyCompetence) {
					print '
						<li>'.$keyCompetence['name'].'</li>
					';
				}
			?>
		
		</ul>
	</div>
	

	<div class="since_prof">
		<?php if(!empty($varArrayProfSince)) { ?><h3><b>Профессии</b></h3> <?php } ?>
		<div class="multiple-items-two">
		<?php $len_obr = count($varArrayProfSince);
			foreach ($varArrayProfSince as $keyOrg) { 
				print '
					<div class="prof_review" id="bg">
						<a href="/viewprof?id='.$keyOrg['id'].'">
							<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
							<h4>'.$keyOrg['name'].'</h4>
						</a>
					</div>
				';
		  	} ?>
		</div>
		<?php if(!empty($varArrayProfSince)) { ?>
		<div class="action">
			<?php print '<input id="action_one_range-two" type="range" min="1" max="'.$len_obr.'"  value="0" step="1">'; ?>
		</div>
		<?php } ?>
	</div>
	
	<?php if(empty($varArrayFullsince['video'])){} else {?>

	<div class="since_video">
		<h3><b>Видео</b></h3>
		<div class="scale-video">
		<?php 

		include(Yii::getAlias('@app/views/site/include/videoid.php'));
		$youtube_video_id = getYoutubeIdFromUrl($varArrayFullsince['video']);
					if($youtube_video_id)
					{
						print '<iframe id="video" width="560" height="315" src="https://www.youtube.com/embed/'.$youtube_video_id.'?controls=1&mute=1&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
					}
		?>
		</div>
	</div>
	<?php } ?>
	<?php if(!empty($varArrayMap)) { ?>
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
		if($typeOrg['type_id'] == 1) {
			$img = '/img/layouts/vuz.png';
		}
		if($typeOrg['type_id'] == 2) {
			$img = '/img/layouts/spo.png';
		}
		if($typeOrg['type_id'] == 3) {
			$img = '/img/layouts/do.png';
		}
		if($typeOrg['type_id'] == 5) {;
			$img = '/img/layouts/sch2.png';
		}
		if($typeOrg['type_id'] == 6) {
			$img = '/img/layouts/do.png';
		}
		if($typeOrg['type_id'] == 4) {
			$img = '/img/layouts/emp.png';
		}
	foreach($varArrayMap as $keyMap){
     print'myPlacemark'.$keyMap['id'].' = new ymaps.Placemark('.$keyMap['coords'].', {
            // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
            balloonContentHeader: "Организация",
            balloonContentBody: "'.str_replace('"','',$keyMap['name']).'",
            balloonContentFooter: "'.$keyMap['st_addr'].'",
            
        }, {
				        // Опции.
				 
				        // Необходимо указать данный тип макета.
				        iconLayout: "default#image",
				 
				        // Своё изображение иконки метки.
				        iconImageHref: "'.$img.'",
				        // Размеры метки.
				        iconImageSize: [32, 32],
				        // Смещение левого верхнего угла иконки относительно
				        // её "ножки" (точки привязки).
				        iconImageOffset: [-16, -16],
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
	var id = $('.favorite').attr('id');
	var userID = $('.favorite').attr('userid');
	console.log(id);
	console.log(userID);
    $.ajax({
       url: '/favoriteorgadd',
       type: 'POST',
       data: {'id_org': id, 'userID_org': userID},
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


uniqueLi = {};

$(".napravlenie ul li").each(function () {
  var thisVal = $(this).text();

  if ( !(thisVal in uniqueLi) ) {
    uniqueLi[thisVal] = "";
  } else {
    $(this).remove();
  }
})

$('.favorite_del').on('click', function(e) {
	var id = $('.favorite_del').attr('id');
	var userID = $('.favorite_del').attr('userid');
    $.ajax({
       url: '/favoriteorgdel',
       type: 'POST',
       data: {'id_job': id, 'userID_job': userID},
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