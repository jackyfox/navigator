<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;


include(Yii::getAlias('@app/views/site/include/yandex-geo/autoload.php'));

$api = new \Yandex\Geo\Api();



$this->title = 'Карта';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="">
	<div class="container" style="width: 100%;">
		<div class="row top_page">
			<h2>Карта</h2>
			<p>Найди свои возможности на карте</p>
		</div>

		<div class="row map-filter">
			<div class="col-lg-3">
			<div class="form-check">
					<label>
						<div class="panel1" style="margin-top: 20px;">

						<div class="panel panel-default">
 							<div class="panel-heading">
								<button type="button" class="btn btn-default btn-xs spoiler-push pull-right" data-toggle="collapse">&#9660</button>
 								<h3 class="panel-title">Фильтр по профессиям</h3>
 							</div>
							<div class="panel-collapse collapse out">
 								<div class="panel-body">
									<div class="filter_block">
										<div class="filter-list" id="prof-list">
											<?php
											foreach ($varArrayProf as $keyProf) {

												print '<div class="filters_map"><input type="checkbox" id="prof_'.$keyProf['id'].'" name=prof[]><label for="prof_'.$keyProf['id'].'"><i class="fa fa-2x icon-checkbox"></i>'.$keyProf['name'].'</label><br></div>';
											}
											?>
										</div>
									</div>
 								</div>
 							</div>
						</div>

						</div>

						<hr>
						<div class="panel2">

						<div class="panel panel-default">
 							<div class="panel-heading">
								<button type="button" class="btn btn-default btn-xs spoiler-push pull-right" data-toggle="collapse">&#9660</button>
 								<h3 class="panel-title">Фильтр по образовательному учереждению</h3>
 							</div>
							<div class="panel-collapse collapse out">
								<div class="filter_block" style="padding: 15px;">
									<div class="filter-list" id="education-list">
										<?php
											foreach ($varArrayOrg as $keyOrg) {
								
												print ' <div class="filters_map"><input type="checkbox" id="org_'.$keyOrg['id'].'" name=org[]><label for="org_'.$keyOrg['id'].'"><i class="fa fa-2x icon-checkbox"></i>'.$keyOrg['name'].'</label><br></div>';
											}
										?>
									</div>
								</div>
							</div>
						</div>

						</div>
						
						<hr>
						<div class="panel3">

						<div class="panel panel-default">
 							<div class="panel-heading">
								<button type="button" class="btn btn-default btn-xs spoiler-push pull-right" data-toggle="collapse">&#9660</button>
 								<h3 class="panel-title">Фильтр по направлению</h3>
 							</div>
							<div class="panel-collapse collapse out">
								<div class="filter_block" style="padding: 15px;">
									<div class="filter-list" id="education-list">
										<?php
											foreach ($varArrayComp as $keyComp) {
												print ' <div class="filters_map"><input type="checkbox" id="comp_'.$keyComp['id'].'" name=comp[]><label for="comp_'.$keyComp['id'].'"><i class="fa fa-2x icon-checkbox"></i>'.$keyComp['name'].'</label><br></div>';
										}
										?>
									</div>
								</div>
							</div>
						</div>

						</div>



					</label>
				</div>
			</div>
			<div class="col-lg-9" style="margin-top: 20px;">
				<div id="map" style="width: 100%; height: 700px;"></div>
				<div class="newmap">
					
				</div>
			</div>
		</div>
		
	</div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


<script>
$(document).ready(function() {
$(".spoiler-push").click(function() {
	$(this).parent().next().collapse('toggle');
});

    ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map("map", {
            center: [59.9386300, 30.3141300],
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        }),

    <?php 
	foreach($varArrayMap as $keyMap){
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
            balloonContentHeader: "Организация",
            balloonContentBody: "'.str_replace('"','',$keyMap['name']).'",
            balloonContentFooter: "'.$keyMap['st_addr'].'",
            hintContent: "'.str_replace('"','',$keyMap['name']).'",
        	locationUrl: "'.$link.'"
				    }, {
				        // Опции.
				 
				        // Необходимо указать данный тип макета.
				        iconLayout: "default#image",
				 
				        // Своё изображение иконки метки.
				        iconImageHref: "'.$img.'",
				        // Размеры метки.
				        iconImageSize: [44, 44],
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
$script2 = <<< JS
$('.form-check input:checkbox').change(function(event) {

		var checkbox_prof = [];
		var checkbox_org = [];
		var checkbox_comp = [];

		$('.form-check input[name="prof[]"]:checked').each(function() {
    		checkbox_prof.push($(this).attr('id'));
    		//console.log(checkbox_prof);

		});
		$('.form-check input[name="org[]"]:checked').each(function() {
    		checkbox_org.push($(this).attr('id'));
    		//console.log(checkbox_org);

		});
		$('.form-check input[name="comp[]"]:checked').each(function() {
    		checkbox_comp.push($(this).attr('id'));
    		//console.log(checkbox_comp);

		});


		$.ajax({
		       url: '/filter',
		       type: 'POST',
			   dataType: 'json',
		       data: {checkbox_prof: checkbox_prof, checkbox_org:checkbox_org, checkbox_comp:checkbox_comp},
		       success: function(res){
		
		       		maps(res);
		       		console.log(res);
					
		       },
		       error: function(res){
		       	console.log(res);
		       	//debugger;
		            alert('Error!');
		       }
		});

});
JS;
$this->registerJs($script2);
?>

<script>
	function maps(res) {

		//var json = $.parseJSON(res);

		var json = res;
		//var clean= json.filter((arr, index, self) =>
		//  index === self.findIndex((t) => (t.name === arr.name
		//  )));
			$('.newmap').empty();
			$('#map').fadeOut('fast');
			$('.newmap').append('<div id="map2" style="width: 100%; height: 500px;"></div>');

    		ymaps.ready(function () {
    			var myMap2 = new ymaps.Map('map2', {
            	center: [59.9386300, 30.3141300],
            	zoom: 9
        	}, {
            	searchControlProvider: 'yandex#search'
        	});
    			
				$.each(json, function(index) {
					
					var id =  json[index].id;
		       		var cardination =  json[index].coords; 
		       		var street =  json[index].st_addr;
		       		var name =  json[index].name;
		       		var type =  json[index].name_type;
		       		var type_id =  json[index].type_id;
		       		//var image = data[index].image;
		       		var Container = {};
		       		var placemarks = "placemarks_" + id;
		       		var cardination = cardination.replace(/\[|\]/g, '');
		       		var cardination = cardination.split(',');
		       		var k1 =  cardination[0];
		       		var k2 =  cardination[1];		    
					
					if(type_id == 1) {
						var link = '/sinceview?id='+id;
						var img = '/img/layouts/vuz.png';
					}
					if(type_id == 2) {
						var link = '/sinceview?id='+id;
						var img = '/img/layouts/spo.png';
					}
					if(type_id == 3) {
						var link = '/sinceview?id='+id;
						var img = '/img/layouts/do.png';
					}
					if(type_id == 5) {
						var link = '/sinceview?id='+id;
						var img = '/img/layouts/sch2.png';
					}
					if(type_id == 6) {
						var link = '/sinceview?id='+id;
						var img = '/img/layouts/do.png';
					}
					if(type_id == 4) {
						var link = '/jobview?id='+id;
						var img = '/img/layouts/emp.png';
					}



					console.log(json[index]);

					Container[placemarks] = new ymaps.Placemark([k1,k2], {
				        hintContent: "Улица: "+street+" <br> Организация : "+name+"",
				        locationUrl: link,
				    }, {
				        // Опции.
				 
				        // Необходимо указать данный тип макета.
				        iconLayout: "default#image",
				 
				        // Своё изображение иконки метки.
				        iconImageHref: ""+img+"",
				        // Размеры метки.
				        iconImageSize: [32, 32],
				        // Смещение левого верхнего угла иконки относительно
				        // её "ножки" (точки привязки).
				        iconImageOffset: [-16, -16],
				    });

				   	  myMap2.geoObjects.add(Container['placemarks_' + id]);

				      myMap2.geoObjects.events.add("click", function (e) {
					        // Объект на котором произошло событие
					        var target = e.get("target");
					        
					        window.location.href = target.properties.get("locationUrl");
					    });
				
				    
				});
			});
	
		//console.log(res);

	}
</script>


