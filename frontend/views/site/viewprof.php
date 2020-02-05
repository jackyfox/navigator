<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = $varArrayViewProf['name'];

$this->params['breadcrumbs'][] = ['label' => 'Профессии', 'url' => ['/prof']];

$this->params['breadcrumbs'][] = $this->title;

$enableCsrfValidation = false;
if($_post['id']) {
	echo "good";
}

?>

<div class="container text-description" style="background-color: #FCFCFC !important;width: 100%;">
	<div class="header_page_img row" style="background: url(<?=$varArrayViewProf['img']?>) 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-9"><h3><?=$varArrayViewProf['name']?></h3></div>
		<?php if (empty($varArrayViewProf['low_salary']) && empty($varArrayViewProf['high_salary'])) {
			print '
			<div class="prof_salary" style="float:right;color: white;font-size: 24pt;font-weight: bolder; margin-top: 15px;">';
		}
		else {
			print '
			<div class="prof_salary" style="float:right;color: white;font-size: 24pt;font-weight: bolder; margin-top: 25px;">'.$varArrayViewProf['low_salary'].' - '.$varArrayViewProf['high_salary'].' ₽  <br>';
		}
		?>
			<div id="button_favorite">
			<?php
			if (Yii::$app->user->isGuest) {

            }
            else {

			if(empty($getFavoriteUser)) { ?>
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite btn">Добавить в избранное</a>
			<?php } else { ?>
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite_del btn">Удалить из избранного</a>
			<?php } 
			}	?>
			</div>
		</div>
	</div>
	<p class="text_prof"><?=$varArrayViewProf['description']?></p>
	


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
        		if(empty($varArrayViewProfSlider)) {

        		}
        		else {
	        		foreach ($varArrayViewProfSlider as $keySlider) {
	        			print '
	        				<div class="item">
				                <img src="'.$keySlider['img_slider'].'" alt="First Slide">
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
        if(empty($varArrayViewProfSlider)) 
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
		<?php if(!empty($varArrayViewProfComp)) { ?><h3><b>Направления</b></h3> <?php }?>
		<ul>
			<?php 
				#Компетенции 
				$varArrayViewProfComp = array_unique($varArrayViewProfComp);
				foreach ($varArrayViewProfComp as $keyCompetence) {
					print '
						<li>'.$keyCompetence['competence_name'].'</li>
					';
				}
			?>
		
		</ul>
	</div>
	
	<div class="since_prof">
	<?php if(!empty($varArrayViewProfOrg)) { ?><h3><b>Где учиться</b></h3> <?php }?>

		<div class="slider_slick prof-content-flex">
			<?php /*$varArrayViewProfOrg = array_unique($varArrayViewProfOrg);*/ foreach ($varArrayViewProfOrg as $keyOrg) { 
				if($keyOrg['type_id'] != 4) {
					print '
						<div class="prof_review" style="margin-top:20px;">
							<a href="/sinceview?id='.$keyOrg['organisation_id'].'">
								<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
								<h4>'.$keyOrg['name'].'</h4>
							</a>
						</div>
					';
				}
		  	} ?>
		</div>
	</div>

	<div class="job_prof">
	<?php if(!empty($varArrayViewProfOrg)) { ?> <h3><b>Где работать</b></h3> <?php }?>
		<div class="slider_slick">
			<?php foreach ($varArrayViewProfOrg as $keyOrg) { 
				if($keyOrg['type_id'] == '4') {
					print '
						<div class="prof_review" style="margin-top:20px;">
							<a href="/jobview?id='.$keyOrg['organisation_id'].'">
								<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
								<h4>'.$keyOrg['name'].'</h4>
							</a>
						</div>
					';
				}
		  	} ?>
		</div>
	</div>
	<?php if(empty($varArrayViewProf['video'])){} else {?>

	<div class="prof_video">
		<h3><b>Видео</b></h3>
		<div class="scale-video">
		<?php 

		include(Yii::getAlias('@app/views/site/include/videoid.php'));
		$youtube_video_id = getYoutubeIdFromUrl($varArrayViewProf['video']);
					if($youtube_video_id)
					{
						print '<iframe id="video" width="560" height="315" src="https://www.youtube.com/embed/'.$youtube_video_id.'?controls=1&mute=1&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
					}
		?>
	</div>
	</div>

	<?php } ?>
	<?php if(!empty($varArrayViewAddress)) { ?>
	<div class="map_prof">
		<h3><b>Карта</b></h3>
	
		<div id="map" style="width: 100%; height: 400px"></div>
	</div>
	<?php }?>
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
	
	foreach($varArrayViewAddress as $keyMap){
		
		if($keyMap['type_id'] == 1) {
			$link = '/sinceview?id='.$keyMap['id'];
			$img = '/img/layouts/vuz.png';

		}
		if($keyMap['type_id'] == 2) {
			$link = '/sinceview?id='.$keyMap['id'];
			$img = '/img/layouts/spo.png';

		}
		if($keyMap['type_id'] == 3) {
			$link = '/sinceview?id='.$keyMap['id'];
			$img = '/img/layouts/do.png';

		}
		if($keyMap['type_id'] == 5) {
			$link = '/sinceview?id='.$keyMap['id'];
			$img = '/img/layouts/sch2.png';

		}
		if($keyMap['type_id'] == 6) {
			$link = '/sinceview?id='.$keyMap['id'];
			$img = '/img/layouts/do.png';

		}
		if($keyMap['type_id'] == 4) {
			$link = '/jobview?id='.$keyMap['id'];
			$img = '/img/layouts/emp.png';
		}

     print'myPlacemark'.$keyMap['id'].' = new ymaps.Placemark('.$keyMap['coords'].', {
            // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
            balloonContentHeader: "'.str_replace('"','',$keyMap['name']).'",
            balloonContentBody: "'.$keyMap['type_name'].'",
            balloonContentFooter: "'.$keyMap['st_addr'].'",
            locationUrl: "'.$link.'",
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
     myMap.geoObjects.events.add("click", function (e) {
					        // Объект на котором произошло событие
					        var target = e.get("target");
					        
					        window.location.href = target.properties.get("locationUrl");
					    });
    


}
});
</script>

<?php
$script = <<< JS

if($('.since_prof .slider_slick .prof_review').length == 0) {
	console.log('since 0');
	$('.since_prof').remove();
}

if($('.job_prof .slider_slick .prof_review').length == 0) {
	console.log('job 0');
	$('.job_prof').remove();
}


$('.favorite').on('click', function(e) {
	var id = $('.favorite').attr('id');
	var userID = $('.favorite').attr('userid');

    $.ajax({
       url: '/favoriteprofadd',
       type: 'POST',
       data: {id: id, 'userID': userID},
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
	var id = $('.favorite_del').attr('id');
	var userID = $('.favorite_del').attr('userid');
    $.ajax({
       url: '/favoriteprofdel',
       type: 'POST',
       data: {id: id, 'userID': userID},
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