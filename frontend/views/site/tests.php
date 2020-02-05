<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;
?>

	<div class="container">
		<div class="row top_page">
			<h2><?= Html::encode($this->title) ?></h2>
			<p>Тесты от организаций</p>
		</div>
		
		<div id="myCarousel"  data-interval="3000" data-ride="carousel">
		<div id="carouselExampleIndicators" class="row carousel slide" data-ride="carousel">
			<ol class="carousel-indicators" style="display: none;">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			</ol>
		<div  class="carousel-inner carousel-slide">
			<?php
			
			foreach ($sliderArray as $keySlider) {
				
				print '
				<div class="item">
				<a href="/testview?id='.$keySlider['id'].'">
					<div class="main-event" style="position: absolute; margin-left: 20px;">
						<h2 style="color: white;">'.$keySlider['title'].'</h2>
						<div class="data-event" style="color: white;">'.$keySlider['data_start'].' - '.$keySlider['data_end'].'</div>
					</div>
					<img  style="box-shadow: inset 0 0 200px #000000;" src="'.$keySlider['img'].'" alt="Слайд">
				</a>
				</div>
				
				';
				
			}
			?>
				<!--
					<a class="carousel-control  left" href="#myCarousel" data-slide="prev">
			            <span class="glyphicon glyphicon-chevron-left"></span>
			        </a>
			        <a class="carousel-control right" href="#myCarousel" data-slide="next">
			            <span class="glyphicon glyphicon-chevron-right"></span>
			        </a>
			    !-->
		</div>
		</div>
		</div>
			
		<div class="row filter_horizon">
			<div class="col-lg-12">
				<form class="filter_form_prof" id="filter_form_prof">
					<input type="text" id="search_prof_input" name="search_text" class="form-control" placeholder="Поиск тестов">
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>

		</div>
		<div class="row">
			<div id="result_search" style="display: block;text-align: center;overflow: hidden;margin: 0 auto;">

			</div>
		</div>
		<div class="row" id="static_content">
			<?php
			if(empty($varArrayTests)) { print '<iframe src="https://test.profinavigator.ru" style="width:100%; height: 900px;"></iframe>';}
			foreach ($varArrayTests as $arrayTests) {
				if(!empty($arrayTests['certificate'])) {
					$certificate = 'Сертификат';
				}
				else {
					$certificate = 'Сертификат не выдается';
				}
				print '
				
				<div class="row test">
					<div class="col-lg-3 data-test">
						<p>'.$arrayTests['data_start'].' - '.$arrayTests['data_end'].'</p>
						<div class="test-item">
							<img class="time-test" src="../img/layouts/icon-time.svg">
							<p>'.$arrayTests['timeTest'].' </p>
						</div>
						<div class="test-item">
							<img class="time-test" src="../img/layouts/icon-smile.svg">
							<p>'.$arrayTests['exp'].' ед. опыта</p>
						</div>
						<div class="test-item">
							<img class="time-test" src="../img/layouts/icon-certificate.svg">
							<p>'.$certificate.'</p>
						</div>
					</div>
					<div class="col-lg-6 description-test">
						<h2>'.$arrayTests['title'].'<h2>
						<p>'.mb_substr($arrayTests['description'],0, 255,'UTF-8').'...</p>
						<div class="btn-test">
							<a href="/testview?id='.$arrayTests['id'].'">Узнать больше</a>
						</div>
					</div>
					<div class="col-lg-3 test-img">
						<img src="'.$arrayTests['img'].'" alt="'.$arrayTests['title'].'">
					</div>
				</div>

				';
			}
			?>

			
		</div>
	</div>


