<?php
include ('core/header.php'); ?>

<div class="container main">

<form id="test-form" method="POST">
	<div class="userName" id="userName">
		<label for="fio">Введите фамилию имя отчество</label>
		<input type="text" class="form-control" id="fio" name="fio">
	</div>
	
	<div id="question-group-for-otvet">
		<div class="questions" id="questions1">
			<label class="vopros" for="questions1">В школе я предпочитаю предметы:</label>
			<div class="form-check">
				<input name="q1_ch1" type="checkbox" id="q1_ch1" value="0">
				<label for="q1_ch1"><span class="fa fa-2x icon-checkbox"></span>математика</label>
		    </div>
		    <div class="form-check">
				<input name="q1_ch2" type="checkbox" id="q1_ch2" value="0">
				<label for="q1_ch2"><span class="fa fa-2x icon-checkbox"></span>иностранный язык</label>
		    </div>
		    <div class="form-check">
				<input name="q1_ch3" type="checkbox" id="q1_ch3" value="0">
				<label for="q1_ch3"><span class="fa fa-2x icon-checkbox"></span>естественные науки</label>
		    </div>
		    <div class="form-check">
				<input name="q1_ch4" type="checkbox" id="q1_ch4" value="0">
				<label for="q1_ch4"><span class="fa fa-2x icon-checkbox"></span>искусство</label>
		    </div>
		    <div class="form-check">
				<input name="q1_ch5" type="checkbox" id="q1_ch5" value="0">
				<label for="q1_ch5"><span class="fa fa-2x icon-checkbox"></span>история</label>
		    </div>
		</div>
		<div class="questions" id="questions2">
			<label class="vopros" for="questions2">Если бы мне нужно было выбрать одно дополнительное занятие в школе, я бы предпочел:</label>
			<div class="form-check">
				<input name="q2_ch" type="radio" id="q2_ch1" value="0">
				<label for="q2_ch1">технический</label>
		    </div>
		    <div class="form-check">
				<input name="q2_ch" type="radio" id="q2_ch2" value="0">
				<label for="q2_ch2">музыкальный</label>
		    </div>
		    <div class="form-check">
				<input name="q2_ch" type="radio" id="q2_ch3" value="0">
				<label for="q2_ch3">спортивный</label>
		    </div>
		    <!--<div class="form-check">
				<input name="q2_ch" type="radio" id="q2_ch4" value="0">
				<label for="q2_ch4">гуманитарный</label>
		    </div>-->
		</div>
		<div class="questions" id="questions3">
			<label class="vopros" for="questions3">Какой из видов работ я предпочту:<!--Какой из видов работ мне предпочтительнее:--></label>
			<div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch1" value="6">
				<label for="q3_ch1">осуществлять психологическую и физическую подготовку к соревнованиям, турнирам, выступлениям</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch2" value="3">
				<label for="q3_ch2">налаживать работу компьютеров, оборудования</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch3" value="7">
				<label for="q3_ch3">управлять автомобилем или другим транспортным средством</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch4" value="4">
				<label for="q3_ch4">проектировать новые спутники, ракеты, космодромы</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch5" value="1">
				<label for="q3_ch5">изучать генетику, выводить новые сорта растений</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch6" value="2">
				<label for="q3_ch6">строить дома по планам, делать разводку электричества соответственно с проектом</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch7" value="10">
				<label for="q3_ch7">анализировать состояние растений и животных в загрязненных условиях среды</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch8" value="8">
				<label for="q3_ch8">разрабатывать новые технологии производства (сверх-легкие металлы, прочный пластик)</label>
		    </div>
		    <div class="form-check">
				<input name="q3_ch" type="radio" id="q3_ch9" value="9">
				<label for="q3_ch9">проектировать новые электростанции</label>
		    </div>
		</div>
		<div class="questions" id="questions4">
			<label class="vopros" for="questions4">Я бы скорее предпочел работу:</label>
			<div class="form-check">
				<input name="q4_ch" type="radio" id="q4_ch1" value="0">
				<label for="q4_ch1">с разными людьми</label>
		    </div>
		    <div class="form-check">
				<input name="q4_ch" type="radio" id="q4_ch2" value="0">
				<label for="q4_ch2">с разработкой технологий</label>
		    </div>
		</div>
		<div class="questions" id="questions5">
			<label class="vopros" for="questions5">Мне интересно читать статьи о:</label>
			<div class="form-check">
				<input name="q5_ch" type="radio" id="q5_ch1" value="8">
				<label for="q5_ch1">новых изобретениях</label>
		    </div>
		    <div class="form-check">
				<input name="q5_ch" type="radio" id="q5_ch2" value="6">
				<label for="q5_ch2">спорте и здоровье</label>
		    </div>
		    <div class="form-check">
				<input name="q5_ch" type="radio" id="q5_ch3" value="10">
				<label for="q5_ch3">научных исследованиях</label>
		    </div>
		    <div class="form-check">
				<input name="q5_ch" type="radio" id="q5_ch4" value="4">
				<label for="q5_ch4">компьютерах и технических разработках</label>
		    </div>
		    <div class="form-check">
				<input name="q5_ch" type="radio" id="q5_ch5" value="2">
				<label for="q5_ch5">новых поселениях и неизведанных территориях</label>
		    </div>
		</div>
		<div class="questions" id="questions6">
			<label class="vopros" for="questions6">Если бы я получил премию, то она была бы в области:</label>
			<div class="form-check">
				<input name="q6_ch" type="radio" id="q6_ch1" value="10">
				<label for="q6_ch1">науки</label>
		    </div>
		    <div class="form-check">
				<input name="q6_ch" type="radio" id="q6_ch2" value="2">
				<label for="q6_ch2">географии</label>
		    </div>
		    <div class="form-check">
				<input name="q6_ch" type="radio" id="q6_ch3" value="4">
				<label for="q6_ch3">математики и информатики</label>
		    </div>
		    <div class="form-check">
				<input name="q6_ch" type="radio" id="q6_ch4" value="6">
				<label for="q6_ch4">медицины и спорта</label>
		    </div>
		    <div class="form-check">
				<input name="q6_ch" type="radio" id="q6_ch5" value="8">
				<label for="q6_ch5">новых технологий</label>
		    </div>
		</div>
		<div class="questions" id="questions7">
			<label class="vopros" for="questions7"> Я хотел бы попробовать:</label>
			<div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch1" value="8">
				<label for="q7_ch1">ставить различные опыты, эксперименты</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch2" value="11">
				<label for="q7_ch2">изучать экологию мира</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch3" value="6">
				<label for="q7_ch3">тренироваться и развивать свое тело</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch4" value="2">
				<label for="q7_ch4">увлекаться архитектурой</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch5" value="4">
				<label for="q7_ch5">писать компьютерные программы</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch6" value="10">
				<label for="q7_ch6">обогнать Эйнштейна в научных открытиях</label>
		    </div>
		    <div class="form-check">
				<input name="q7_ch" type="radio" id="q7_ch7" value="1">
				<label for="q7_ch7">ухаживать за животными</label>
		    </div>
		</div>
		<div class="questions" id="questions8">
			<label class="vopros" for="questions8">Сейчас мне интересно:</label>
			<div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch1" value="9">
				<label for="q8_ch1">тренировать спортивную команду</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch2" value="3">
				<label for="q8_ch2">разрабатывать компьютерные программы и алгоритмы</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch3" value="1">
				<label for="q8_ch3">исследовать поведение животных в лабораториях</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch4" value="5">
				<label for="q8_ch4">лечить людей или помогать им психологически</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch5" value="9">
				<label for="q8_ch5">писать статьи для научных журналов</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch6" value="10">
				<label for="q8_ch6">отправиться в исследовательскую экспедицию</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch7" value="7">
				<label for="q8_ch7">конструировать новые машины</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch8" value="4">
				<label for="q8_ch8">исследовать поверхность Марса</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch9" value="8">
				<label for="q8_ch9">открыть завод по производству экологичных материалов</label>
		    </div>
		    <div class="form-check">
				<input name="q8_ch" type="radio" id="q8_ch10" value="2">
				<label for="q9_ch10">построить туристический городок</label>
		    </div>
		</div>

	</div>		
	<div id="buttondDiv">
			<button class="btn btn-info" id="sendButton">Ответить</button>
	</div>
	<div id="response">
	</div>
</form>

</div>

<?php include ('core/footer.php'); ?>
