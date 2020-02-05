<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Профессии';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="">
	<div class="container" style="width: 100%;">
		<div class="row top_page">
			<h2>Кем стать - это твой выбор!</h2>
			<p>Здесь ты можешь увидеть все востребованные и перспективные направления с подробными описаниями каждого из них</p>
		</div>
		<div class="row filter_horizon">
			<div class="col-lg-6">
				<h3>Фильтры профессий</h3>
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
			<h2>Профессии</h2>
			<div class="prof-content-flex" id="result_search">
			</div>
			<div class="prof-content-flex" id="static_content">
			<?php
				foreach ($varArrayProf as $viewProf) {
					print '
						<div class="prof_review" style="margin-top: 20px;">
							<a href="/viewprof?id='.$viewProf['id'].'">
								<img  src="'.$viewProf['img'].'"   width="270" height="180">
								<h4>'.$viewProf['name'].'</h4>
							</a>
						</div>
					';
				}
			?>
			</div>
		</div>
		<center><p class="reed_more btn">Показать еще</p></center>
		<center><p class="reed_more_hide btn btn-info" id="prof-hide" style="display: none;">Скрыть</p></center>

		<div class="row prof-content">
			
					
					<?php

					if (Yii::$app->user->isGuest) {
					}
					else {
						if(!empty($varArrayProfFavorite)) { 
					print '
					<h2>Избранные профессии</h2>
					<div class="multiple-items">';	
						  $len_obr = count($varArrayProfFavorite);
						  foreach ($varArrayProfFavorite as $profesions_vyzs) {
						  	$bg = "'".$profesions_vyzs['img_prof']."'"; 
								print '<div id="bg" class="favourites" style="width: 300px;height: 250px;">
								<a href="/viewprof?id='.$profesions_vyzs['id_profession'].'">
								<img src="'.$profesions_vyzs['img_prof'].'" alt="" width="270" height="180">
								<h4>'.$profesions_vyzs['name_prof'].'</h4></a>
								</div>';
						  }
					print '</div>
					<div class="action">
						<input id="action_one_range" type="range" min="1" max="'.$len_obr.'"  value="0" step="1">
					</div>';
						}}
					  ?>
					
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

if($('.prof-content-flex .prof_review').length < 3) { $('.reed_more').hide(); } 

JS;
$this->registerJs($script);
?>

