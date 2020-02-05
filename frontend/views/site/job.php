<?php

use yii\helpers\Html;

$this->title = 'Где работать';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="">
	<div class="container">
		<div class="row top_page">
			<h2>Чем ты хочешь заниматься?</h2>
			<p>Тебя интересуют компьютеры? Или, может быть, все, что связано с космосом? Нравится биология, любишь устраивать эксперименты в кабинете химии? Если определился с областью своих интересов, дальше есть смысл задуматься о деталях</p>
		</div>
		<div class="row filter_horizon">
			<div class="col-lg-6">
				<h3>Фильтры работодателей</h3>
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
			<h2>Где работать</h2>
			<div class="prof-content-flex" id="result_search">
			</div>
			<div class="prof-content-flex" id="static_content">
			<?php
				$count = count($varArrayJob);

				foreach ($varArrayJob as $keyJob) {
					#if($keyJob['type_id'] == '4' || $keyJob['type_id'] == '2') {
					if($keyJob['type_id'] == '4') {
						print '
							<div class="prof_review" style="margin-top: 20px;">
								<a href="/jobview?id='.$keyJob['id'].'">
									<img src="'.$keyJob['img'].'" width="270" height="180">
									<h4>'.$keyJob['name'].'</h4>
								</a>
							</div>
						';
					}
				}
			?>
			</div>
		</div>
				<center><p class="reed_more btn">Показать еще</p></center>
				<center><p class="reed_more_hide btn btn-info" id="prof-hide" style="display: none;">Скрыть</p></center>

		<div class="row prof-content favorite-content">
			<?php 
				
				if (Yii::$app->user->isGuest) {
				}
				else {
					if(!empty($varArrayJobFavorite)) { 
					print '
				
				<h2>Избранные Организации</h2>
				<div class="multiple-items">';
					
					foreach ($varArrayJobFavorite as $keyFavorite) {
						#if($keyFavorite['type_id'] != 1 && $keyFavorite['type_id'] != 3) {
						if($keyFavorite['type_id'] == 4) {
							#echo $keyFavorite['type_id'];
							$bg = "'".$keyFavorite['img']."'"; 
								print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
								<a href="/sinceview?id='.$keyFavorite['organisation_id'].'">
								<img src="'.$keyFavorite['img'].'" alt="" width="270" height="180">
								<h4>'.$keyFavorite['name'].'</h4></a>
								</div>';
							$len_obr +=1;	
						}						
				  	} 
			print '</div>
					<div class="action">
						<input id="action_one_range" type="range" min="1" max="'.$len_obr.'"  value="0" step="3">
					</div>';
				}}?>

			</div>
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
        $('.prof-content-flex .prof_review:hidden').slice(0, 4).fadeIn('slow');
        if ($('.prof-content-flex .prof_review').length == $('.prof-content-flex').find('.prof_review:visible').length) {
            $('.reed_more').hide();
            $('#prof-hide').fadeIn();
        }
    });

	 $('#prof-hide').click(function() {
		
		$('.prof-content-flex .prof_review:visible').slice(3, $('.prof-content-flex .prof_review').length).fadeOut('slow');
		
		$(this).hide();
        $('.reed_more').fadeIn();

    });


});

JS;
$this->registerJs($script);
?>
