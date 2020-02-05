<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\data\Pagination;
use yii\base\Widget;
use yii\widgets\LinkPager;
use yii\data\ActiveDataProvider;


$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>

	<div class="container">
		<div class="row top_page">
			<h2><?= Html::encode($this->title) ?></h2>
			<p>Мероприятия, созданные организациями</p>
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
			foreach ($varTopSlider as $keySlider) {
				if($keySlider['event_main_page'] == 1) {
				print '
				<div class="item">
				<a href="/eventview?id='.$keySlider['id_event'].'">
					<div class="main-event" style="position: absolute; margin-left: 20px;">
						<h2 style="color: white;">'.$keySlider['title'].'</h2>
						<div class="data-event" style="color: white;">'.$keySlider['event_time'].'</div>
					</div>
					<img  style="box-shadow: inset 0 0 200px #000000;width: 100% !important;" src="'.$keySlider['img'].'" alt="Слайд">
				</a>
				</div>
				';
				}
				else {
					
				}
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
					<input type="text" id="search_prof_input" name="search_text" class="form-control" placeholder="Поиск по фильтрам">
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
			foreach ($varInView as $keyEvent) {
				print '
			
				<div class="row event">
					<div class="col-lg-3 data-event">'.$keyEvent['event_time'].'</div>
					<div class="col-lg-6 description-event">
						<h2>'.$keyEvent['title'].'<h2>
						<p>'.mb_substr($keyEvent['description'],0, 255,'UTF-8').'...</p>
						<div class="btn-event">
							<a href="/eventview?id='.$keyEvent['id'].'">Узнать больше</a>
						</div>
					</div>
					<div class="col-lg-3 event-img">
						<img src="'.$keyEvent['picture'].'" alt="'.$keyEvent['title'].'">
					</div>
				</div>

				';
			}
			?>

			
		</div>
	</div>

