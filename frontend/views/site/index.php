<?php

/* @var $this yii\web\View */

$this->title = 'ГИС «НАВИГАТОР ПРОФЕССИЙ САНКТ-ПЕТЕРБУРГА»';
?>
<div class="">
	<div class="col-lg-12">
		
		<center>
			<h2 style="font-weight: bolder;">Регистрация на мероприятии в Академии</h2>
			<a href="https://forms.gle/48CrSJcwoPU2CE3T7" class="btn btn-primary" target="_blank">Зарегистрироваться</a> <a href="https://test.profinavigator.ru/" class="btn btn-primary" target="_blank">Тест</a>
		</center>
		
		<!-- Билет в помойку
		<center>
			<h2 style="font-weight: bolder;">Билет в будущее</h2>
			<p>Федеральный проект ранней профориентации школьников</p>
			<p>Ознакомительный этап</p>
			<a href="https://profinavigator.ru/upload/other/Ticket.exe" class="btn btn-primary">Скачать</a>
			<p style="padding-top: 22px;padding-bottom: 22px;">
				<a style="padding:10px;color:black;" href="https://profinavigator.ru/upload/other/participant-tutorial.pdf" ><u><b>Инструкция для участников</b></u></a> | 
				<a style="padding:10px;color:black;" href="https://profinavigator.ru/upload/other/teacher-tutorial.pdf" ><u><b>Инструкция для педагогов</b></u></a>
			</p>
		</center>
		-->
	</div>
	<div class="row">
		<img class="col-lg-8" src="../img/layouts/index-1.svg">
		<div class="col-lg-4 index-title">
			<h2><a href="/prof" class="main_link">Кем стать?</a></h2>
			<hr>
			<p>Мы поможем ответить тебе на этот вопрос и подобрать профессию, соответствующую твоим интересам</p>
		</div>
	</div>
	<div class="row index-title-study">
		<div class="col-lg-4 index-title">
			<h2><a href="/since" class="main_link">Где учиться?</a></h2>
			<hr>
			<p>Вместе проанализируем и выберем подходящее учебное заведение</p>
		</div>
		<img class="col-lg-8" src="../img/layouts/index-2.svg">
	</div>
	<div class="row">
		<img class="col-lg-8" src="../img/layouts/index-3.svg">
		<div class="col-lg-4 index-title">
			<h2><a href="/job" class="main_link">Где работать?</a></h2>
			<hr>
			<p>Работодатели заинтересованы в молодых экспертах, поэтому вы сможете загружать для них портфолио и быть участниками их курсов</p>
		</div>
	</div>
	<div class="index-map">
		<img src="../img/layouts/index-map.svg">
		<div class="index-title">
			<h2><a href="/map" class="main_link">Профессиональная траектория</a></h2>
			<hr>
			<p>Мы подскажем путь, по которому тебе нужно двигаться. Отрисуем по карте путь от дома до учебного заведения и работадателя в твоем районе</p>
		</div>
	</div>
	<!--<div class="index-section">!-->
	<div class="col-lg-12" style="text-align: center; padding: 150px;">
		<h1 class="index-title-question">Остались вопросы?</h1>
		<div  class="index-button">
			<a href="/ourproject">Узнать больше</a>
		</div>
	</div>
	<div class="col-lg-12">
		<center><h1 class="index-title-question">Наши партнеры</h1></center>
		<ul class="partners">
			<li><a href="https://geropharm.ru/" target="_blank"><img src="../img/герофарм.png" alt="" class="img-thumbnail"></a></li>
			<li><a href="https://www.rusnano.com/" target="_blank"><img src="../img/роснано.png" alt="" class="img-thumbnail"></a></li>
			<li><a href="https://rostec.ru/" target="_blank"><img src="../img/ростех.png" alt="" class="img-thumbnail"></a></li>
			<li><a href="https://spcpu.ru/" target="_blank"><img src="../img/химфарм.png" alt="" class="img-thumbnail"></a></li>
			<li><a href="https://www.gazprom.ru/" target="_blank"><img src="../img/газпром.png" alt="" class="img-thumbnail"></a></li>
		</ul>
	</div>
</div>

<style>
	.main_link {
		font-family: 'Noto Sans', sans-serif;
		font-weight: bold;
		font-size: 36px;
		margin: 0;
		text-align: center;
		color:  #333333;
	}

	.main_link:hover {
		color: #333333;
	}
	.partners {
		text-align: center;
		padding: 0px;
	}
	ul.partners li {
		display: inline-block;
		list-style: none;
		background: #dedede;
		padding: 25px;
		margin: 10px;
	}
</style>