<?php

use yii\helpers\Html;

$this->title = 'Где учиться';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="">
	<div class="container" style="width: 100%;">
		<div class="row top_page">
			<h2>Куда пойти учиться?</h2>
			<p>Ежегодно в петербургские ВУЗы поступают тысячи иногородних абитуриентов. Главное – определиться кем хочешь стать, и тогда для тебя откроются все возможности.</p>
		</div>
		<div class="row filter_horizon">
			<div class="col-lg-6">
				<h3>Фильтры учебных заведений</h3>
			</div>
			<div class="col-lg-6">
				<form class="filter_form_prof" id="filter_form_prof">
					<input type="text" id="search_prof_input" name="search_text" class="form-control" placeholder="Поиск по фильтрам">
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>
			<div class="col-lg-12" id="filter_enter" style="display: block;text-align: center;overflow: hidden;margin: 0 auto;">

			</div>
		</div>

		<div class="row prof-content">
			<div class="search-flex" id="result_search" style="width: 100%;margin: 0px auto;"">
			</div>
			<center><p class="reed_more btn" id="serach_btn_more_search" >Показать еще</p></center>
			<center><p class="reed_more_hide btn btn-info" id="serach-hide_search" style="display: none;">Скрыть</p></center>
		</div>
		<style>
			.search-flex {
				display: flex;
				flex-direction: row;
				justify-content: space-around;
				flex-wrap: wrap;
			}
		</style>

		<div id="static_content">
		<div class="row prof-content">
			<h2>ВУЗы</h2>
			<div class="prof-content-flex" id="vyz-flex">
			<?php
				
				foreach ($varArrayVyz as $keyVyz) {
					if((int)$keyVyz['type_id'] === 1) {
						print '
							<div class="prof_review" style="" id="'.$keyVyz['type_id'].'">
								<a href="/sinceview?id='.$keyVyz['id'].'">
									<img src="'.$keyVyz['img'].'" width="270" height="180">
									<h4>'.$keyVyz['name'].'</h4>
								</a>
							</div>
						';
					}
				}
			?>
			</div>
			<center><p class="reed_more btn" id="vyz">Показать еще</p></center>
			<center><p class="reed_more_hide btn btn-info" id="vyz-hide" style="display: none;">Скрыть</p></center>
		</div>
				
		<div class="row prof-content">
			<h2>СПО</h2>
			<div class="prof-content-flex" id="spo-flex">
			<?php
				$count = count($varArrayVyz);
				foreach ($varArrayVyz as $keyVyz) {
					if((int)$keyVyz['type_id'] === 2) {
						print '
							<div class="prof_review" style="" id="'.$keyVyz['type_id'].'">
								<a href="/sinceview?id='.$keyVyz['id'].'">
									<img src="'.$keyVyz['img'].'" width="270" height="180">
									<h4>'.$keyVyz['name'].'</h4>
								</a>
							</div>
						';
					}

				}
			?>
			</div>
			<center><p class="reed_more btn" id="spo">Показать еще</p></center>
				<center><p class="reed_more_hide btn btn-info" id="spo-hide" style="display: none;">Скрыть</p></center>
		</div>
				
		<div class="row prof-content">
			<h2>Школы</h2>
			<div class="prof-content-flex" id="school-flex">
			<?php
				$count = count($varArrayVyz);
				foreach ($varArrayVyz as $keyVyz) {
					if((int)$keyVyz['type_id'] === 5) {
						print '
							<div class="prof_review" style="" id="'.$keyVyz['type_id'].'">
								<a href="/sinceview?id='.$keyVyz['id'].'">
									<img src="'.$keyVyz['img'].'" width="270" height="180">
									<h4>'.$keyVyz['name'].'</h4>
								</a>
							</div>
						';
					}
				}
			?>
			</div>
			<center><p class="reed_more btn" id="school">Показать еще</p></center>
				<center><p class="reed_more_hide btn btn-info" id="school-hide" style="display: none;">Скрыть</p></center>
		</div>
		<div class="row prof-content">
			<h2>Детский сад</h2>
			<div class="prof-content-flex" id="sad-flex">
			<?php
				$count = count($varArrayVyz);
				foreach ($varArrayVyz as $keyVyz) {
					if((int)$keyVyz['type_id'] === 6) {
						print '
							<div class="prof_review" style="" id="'.$keyVyz['type_id'].'">
								<a href="/sinceview?id='.$keyVyz['id'].'">
									<img src="'.$keyVyz['img'].'" width="270" height="180">
									<h4>'.$keyVyz['name'].'</h4>
								</a>
							</div>
						';
					}
				}
			?>
			</div>
			<center><p class="reed_more btn" id="sad">Показать еще</p></center>
			<center><p class="reed_more_hide btn btn-info" id="sad-hide" style="display: none;">Скрыть</p></center>
		</div>

		<div class="row prof-content ">
			<h2>Дополнительное образование</h2>
			<div class="prof-content-flex" id="dop-flex">
			<?php
				$count = count($varArrayVyz);
				foreach ($varArrayVyz as $keyVyz) {
					if((int)$keyVyz['type_id'] === 3) {
						print '
							<div class="prof_review" style="" id="'.$keyVyz['type_id'].'">
								<a href="/sinceview?id='.$keyVyz['id'].'">
									<img src="'.$keyVyz['img'].'" width="270" height="180">
									<h4>'.$keyVyz['name'].'</h4>
								</a>
							</div>
						';
					}
				}
			?>
			</div>
			<center><p class="reed_more btn" id="dop">Показать еще</p></center>
			<center><p class="reed_more_hide btn btn-info" id="dop-hide" style="display: none;">Скрыть</p></center>
		</div>

		</div>	


		<div class="row prof-content favorite-content">

				<?php 
				
				if (Yii::$app->user->isGuest) {
				}
				else {
					if(!empty($varArrayOrgFavorite)) {
					print '		
					<h2>Избранные ОУ</h2>
					<div class="multiple-items">';
					$len_obr = count($varArrayOrgFavorite);
					foreach ($varArrayOrgFavorite as $keyFavorite) {
						if($keyFavorite['type_id'] != 4) {
					
							$bg = "'".$keyFavorite['img']."'"; 
								print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
								<a href="/sinceview?id='.$keyFavorite['organisation_id'].'">
								<img src="'.$keyFavorite['img'].'" alt="" width="270" height="180">
								<h4>'.$keyFavorite['name'].'</h4></a>
								</div>';
						}
				  	} 
				print '</div>
						<div class="action">
							<input id="action_one_range" type="range" min="1" max="'.$len_obr.'"  value="0" step="1">
						</div>';
				}}?>
		</div>
	</div>
</div>

<style>
	.prof_review:nth-child(n+4) {
		display: none;
	}
</style>

<?php
$script = <<< JS


$(function () {
    $('.reed_more').click(function () {
    	var id_reed_more =  $(this).attr('id');
    	var main_div = $(this).parent().prev('#'+id_reed_more+'-flex');
		
		var id_prof_content_flex = '#'+id_reed_more+'-flex';

        $(id_prof_content_flex+' .prof_review:hidden').slice(0, 4).fadeIn('slow');

        if ($(id_prof_content_flex+' .prof_review').length == $(id_prof_content_flex).find(".prof_review:visible").length) {
            
            $(this).hide();
            $('#'+id_reed_more+'-hide').fadeIn();
        }
       
    });

    $('.reed_more_hide').click(function() {
		var id_reed_more_hide =  $(this).attr('id');
    	var main_div = id_reed_more_hide.split('-')[0];
		
		var id_prof_content_flex = '#'+main_div+'-flex';
		console.log(id_prof_content_flex);
		$(id_prof_content_flex+' .prof_review:visible').slice(3, $(id_prof_content_flex+' .prof_review').length).fadeOut('slow');
		
		$(this).hide();
        $('#'+main_div).fadeIn();

    });
});

if($('#vyz-flex .prof_review').length < 3) { $('#vyz').hide(); } 
if($('#spo-flex .prof_review').length < 3) { $('#spo').hide(); } 
if($('#school-flex .prof_review').length < 3) { $('#school').hide(); } 
if($('#sad-flex .prof_review').length < 3) { $('#sad').hide(); } 
if($('#dop-flex .prof_review').length < 3) { $('#dop').hide(); } 
if($('#result_search .prof_review').length < 3) { $('#serach_btn_more').hide(); } else {
	$('#serach_btn_more').show();
}


	$('#serach_btn_more_search').click(function () {
        $('.search-flex .prof_review:hidden').slice(0, 4).fadeIn('slow');
        if ($('.search-flex .prof_review').length == $('.search-flex').find('.prof_review:visible').length) {
            $('.reed_more').hide();
            $('#prof-hide').fadeIn();
        }
    });

	 $('#serach-hide_search').click(function() {
		
		$('.search-flex .prof_review:visible').slice(3, $('.search-flex .prof_review').length).fadeOut('slow');
		
		$(this).hide();
        $('.reed_more').fadeIn();

    });

JS;
$this->registerJs($script);
?>

