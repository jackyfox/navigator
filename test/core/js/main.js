var lang = 'ru';
$('.language').on('click', 'img[alt=ru]', function() {
	//console.log(lang);
	lang = 'ru';
	$('.language').html('<img src="core/img/flag/lang__en.png" alt="en" data-google-lang="en" class="language__img" style="width: 23px !important;">')
	$('.header-page div.container').html(
		'<h1>Узнай свое профессиональное направление</h1>'+
		'<p>Ответь на несколько вопросов</p>'
	);
	$('#sendButton').html('Отправить');
	$('label[for="fio"]').html('Введите фамилию имя отчество');
	$('#question-group-for-otvet').html(
		'<div class="questions" id="questions1">'+
			'<label class="vopros" for="questions1">В школе я предпочитаю предметы:</label>'+
			'<div class="form-check">'+
				'<input name="q1_ch1" type="checkbox" id="q1_ch1" value="0">'+
				'<label for="q1_ch1"><span class="fa fa-2x icon-checkbox"></span>математика</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch2" type="checkbox" id="q1_ch2" value="0">'+
				'<label for="q1_ch2"><span class="fa fa-2x icon-checkbox"></span>иностранный язык</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch3" type="checkbox" id="q1_ch3" value="0">'+
				'<label for="q1_ch3"><span class="fa fa-2x icon-checkbox"></span>естественные науки</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch4" type="checkbox" id="q1_ch4" value="0">'+
				'<label for="q1_ch4"><span class="fa fa-2x icon-checkbox"></span>искусство</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch5" type="checkbox" id="q1_ch5" value="0">'+
				'<label for="q1_ch5"><span class="fa fa-2x icon-checkbox"></span>история</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions2">'+
			'<label class="vopros" for="questions2">Если бы мне нужно было выбрать одно дополнительное занятие в школе, я бы предпочел:</label>'+
			'<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch1" value="0">'+
				'<label for="q2_ch1">технический</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch2" value="0">'+
				'<label for="q2_ch2">музыкальный</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch3" value="0">'+
				'<label for="q2_ch3">спортивный</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions3">'+
			'<label class="vopros" for="questions3">Какой из видов работ я предпочту:<!--Какой из видов работ мне предпочтительнее:--></label>'+
			'<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch1" value="6">'+
				'<label for="q3_ch1">осуществлять психологическую и физическую подготовку к соревнованиям, турнирам, выступлениям</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch2" value="3">'+
				'<label for="q3_ch2">налаживать работу компьютеров, оборудования</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch3" value="7">'+
				'<label for="q3_ch3">управлять автомобилем или другим транспортным средством</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch4" value="4">'+
				'<label for="q3_ch4">проектировать новые спутники, ракеты, космодромы</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch5" value="1">'+
				'<label for="q3_ch5">изучать генетику, выводить новые сорта растений</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch6" value="2">'+
				'<label for="q3_ch6">строить дома по планам, делать разводку электричества соответственно с проектом</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch7" value="10">'+
				'<label for="q3_ch7">анализировать состояние растений и животных в загрязненных условиях среды</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch8" value="8">'+
				'<label for="q3_ch8">разрабатывать новые технологии производства (сверх-легкие металлы, прочный пластик)</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch9" value="9">'+
				'<label for="q3_ch9">проектировать новые электростанции</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions4">'+
			'<label class="vopros" for="questions4">Я бы скорее предпочел работу:</label>'+
			'<div class="form-check">'+
				'<input name="q4_ch" type="radio" id="q4_ch1" value="0">'+
				'<label for="q4_ch1">с разными людьми</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q4_ch" type="radio" id="q4_ch2" value="0">'+
				'<label for="q4_ch2">с разработкой технологий</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions5">'+
			'<label class="vopros" for="questions5">Мне интересно читать статьи о:</label>'+
			'<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch1" value="8">'+
				'<label for="q5_ch1">новых изобретениях</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch2" value="6">'+
				'<label for="q5_ch2">спорте и здоровье</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch3" value="10">'+
				'<label for="q5_ch3">научных исследованиях</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch4" value="4">'+
				'<label for="q5_ch4">компьютерах и технических разработках</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch5" value="2">'+
				'<label for="q5_ch5">новых поселениях и неизведанных территориях</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions6">'+
			'<label class="vopros" for="questions6">Если бы я получил премию, то она была бы в области:</label>'+
			'<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch1" value="10">'+
				'<label for="q6_ch1">науки</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch2" value="2">'+
				'<label for="q6_ch2">географии</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch3" value="4">'+
				'<label for="q6_ch3">математики и информатики</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch4" value="6">'+
				'<label for="q6_ch4">медицины и спорта</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch5" value="8">'+
				'<label for="q6_ch5">новых технологий</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions7">'+
			'<label class="vopros" for="questions7"> Я хотел бы попробовать:</label>'+
			'<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch1" value="8">'+
				'<label for="q7_ch1">ставить различные опыты, эксперименты</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch2" value="11">'+
				'<label for="q7_ch2">изучать экологию мира</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch3" value="6">'+
				'<label for="q7_ch3">тренироваться и развивать свое тело</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch4" value="2">'+
				'<label for="q7_ch4">увлекаться архитектурой</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch5" value="4">'+
				'<label for="q7_ch5">писать компьютерные программы</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch6" value="10">'+
				'<label for="q7_ch6">обогнать Эйнштейна в научных открытиях</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch7" value="1">'+
				'<label for="q7_ch7">ухаживать за животными</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions8">'+
			'<label class="vopros" for="questions8">Сейчас мне интересно:</label>'+
			'<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch1" value="9">'+
				'<label for="q8_ch1">тренировать спортивную команду</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch2" value="3">'+
				'<label for="q8_ch2">разрабатывать компьютерные программы и алгоритмы</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch3" value="1">'+
				'<label for="q8_ch3">исследовать поведение животных в лабораториях</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch4" value="5">'+
				'<label for="q8_ch4">лечить людей или помогать им психологически</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch5" value="9">'+
				'<label for="q8_ch5">писать статьи для научных журналов</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch6" value="10">'+
				'<label for="q8_ch6">отправиться в исследовательскую экспедицию</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch7" value="7">'+
				'<label for="q8_ch7">конструировать новые машины</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch8" value="4">'+
				'<label for="q8_ch8">исследовать поверхность Марса</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch9" value="8">'+
				'<label for="q8_ch9">открыть завод по производству экологичных материалов</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch10" value="2">'+
				'<label for="q9_ch10">построить туристический городок</label>'+
		    '</div>'+
		'</div>'
	);
});
$('.language').on('click', 'img[alt=en]', function() {
	//console.log('en');
	//console.log(lang);
	lang = 'en';
	$('.language').html('<img src="core/img/flag/lang__ru.png" alt="ru" data-google-lang="ru" class="language__img" style="width: 23px !important;">')
	$('.header-page div.container').html(
		'<h1>Find out your professional direction</h1>'+
		'<p>Answer a few questions</p>'
	);
	$('#sendButton').html('Send');
	$('label[for="fio"]').html('Your name(-s) and surname');
	$('#question-group-for-otvet').html(
		'<div class="questions" id="questions1">'+
			'<label class="vopros" for="questions1">Subjects I prefer at school:</label>'+
			'<div class="form-check">'+
				'<input name="q1_ch1" type="checkbox" id="q1_ch1" value="0">'+
				'<label for="q1_ch1"><span class="fa fa-2x icon-checkbox"></span>Maths</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch2" type="checkbox" id="q1_ch2" value="0">'+
				'<label for="q1_ch2"><span class="fa fa-2x icon-checkbox"></span>Foreign language</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch3" type="checkbox" id="q1_ch3" value="0">'+
				'<label for="q1_ch3"><span class="fa fa-2x icon-checkbox"></span>Natural sciences</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch4" type="checkbox" id="q1_ch4" value="0">'+
				'<label for="q1_ch4"><span class="fa fa-2x icon-checkbox"></span>Art</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q1_ch5" type="checkbox" id="q1_ch5" value="0">'+
				'<label for="q1_ch5"><span class="fa fa-2x icon-checkbox"></span>History</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions2">'+
			'<label class="vopros" for="questions2">If I needed to visit one extra lesson at school, I would rather choose:</label>'+
			'<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch1" value="0">'+
				'<label for="q2_ch1">Technical</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch2" value="0">'+
				'<label for="q2_ch2">Musical</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q2_ch" type="radio" id="q2_ch3" value="0">'+
				'<label for="q2_ch3">Sports</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions3">'+
			'<label class="vopros" for="questions3">I prefer next type of work:<!--Какой из видов работ мне предпочтительнее:--></label>'+
			'<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch1" value="6">'+
				'<label for="q3_ch1">Carry out physiological and physical preparation for different competitions, tournaments, performances</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch2" value="3">'+
				'<label for="q3_ch2">Establish work of computers and different equipment </label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch3" value="7">'+
				'<label for="q3_ch3">Drive a car or other vehicle</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch4" value="4">'+
				'<label for="q3_ch4">Design new satellites, rockets, spaceports</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch5" value="1">'+
				'<label for="q3_ch5">Study genetics and develop new varieties of plants</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch6" value="2">'+
				'<label for="q3_ch6">Build houses according to the building plans, do electrical wiring according to the project</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch7" value="10">'+
				'<label for="q3_ch7">Analyze the condition of plants and animals in polluted environment</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch8" value="8">'+
				'<label for="q3_ch8">Develop new types of production technologies (ultra-light metals, durable plastic)</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q3_ch" type="radio" id="q3_ch9" value="9">'+
				'<label for="q3_ch9">Engineering a new power plant</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions4">'+
			'<label class="vopros" for="questions4">I would rather prefer working:</label>'+
			'<div class="form-check">'+
				'<input name="q4_ch" type="radio" id="q4_ch1" value="0">'+
				'<label for="q4_ch1">With people</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q4_ch" type="radio" id="q4_ch2" value="0">'+
				'<label for="q4_ch2">With different computer devices</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions5">'+
			'<label class="vopros" for="questions5">I am interested in reading articles about:</label>'+
			'<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch1" value="8">'+
				'<label for="q5_ch1">New inventions</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch2" value="6">'+
				'<label for="q5_ch2">Sports and health</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch3" value="10">'+
				'<label for="q5_ch3">Scientific research</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch4" value="4">'+
				'<label for="q5_ch4">Technical developments</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q5_ch" type="radio" id="q5_ch5" value="2">'+
				'<label for="q5_ch5">New settlements and unknown territories</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions6">'+
			'<label class="vopros" for="questions6">If I have ever received a prize, it would be in the field of:</label>'+
			'<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch1" value="10">'+
				'<label for="q6_ch1">Science</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch2" value="2">'+
				'<label for="q6_ch2">Geography</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch3" value="4">'+
				'<label for="q6_ch3">Maths and computer science</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch4" value="6">'+
				'<label for="q6_ch4">Medicine and sports</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q6_ch" type="radio" id="q6_ch5" value="8">'+
				'<label for="q6_ch5">New technologies</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions7">'+
			'<label class="vopros" for="questions7">I would like to try:</label>'+
			'<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch1" value="8">'+
				'<label for="q7_ch1">Do different experiments</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch2" value="11">'+
				'<label for="q7_ch2">Study the ecology of the world</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch3" value="6">'+
				'<label for="q7_ch3">Train and develop my body</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch4" value="2">'+
				'<label for="q7_ch4">Get addicted with architecture</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch5" value="4">'+
				'<label for="q7_ch5">Write computer programs</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch6" value="10">'+
				'<label for="q7_ch6">Overtake Einstein in scientific discoveries</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q7_ch" type="radio" id="q7_ch7" value="1">'+
				'<label for="q7_ch7">Look after different animals</label>'+
		    '</div>'+
		'</div>'+
		'<div class="questions" id="questions8">'+
			'<label class="vopros" for="questions8">The area of my interests now consists of:</label>'+
			'<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch1" value="9">'+
				'<label for="q8_ch1">Training a sports team</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch2" value="3">'+
				'<label for="q8_ch2">Developing computer programs and algorithms</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch3" value="1">'+
				'<label for="q8_ch3">Studying the behavior of animals in laboratories</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch4" value="5">'+
				'<label for="q8_ch4">Treating people or helping them psychologically</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch5" value="9">'+
				'<label for="q8_ch5">Writing articles for scientific journals</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch6" value="10">'+
				'<label for="q8_ch6">Going on research expedition</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch7" value="7">'+
				'<label for="q8_ch7">Designing new cars</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch8" value="4">'+
				'<label for="q8_ch8">Exploring the surface of Mars</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch9" value="8">'+
				'<label for="q8_ch9">Opening a plant for the production of environmental materials</label>'+
		    '</div>'+
		    '<div class="form-check">'+
				'<input name="q8_ch" type="radio" id="q8_ch10" value="2">'+
				'<label for="q9_ch10">Building a town for tourists</label>'+
		    '</div>'+
		'</div>'
	);

});
$('#test-form').on('click', 'button#sendButton', function(e) {
	e.preventDefault();
	let userJson = TempSendUserFunction();
	let name = $("#fio").prop("value");
	if (name == "") {
		if (lang =='en') {$('#response').html('Not heve your names');} else {$('#response').html('Вы не ввели имя');}
		//console.log(name);
	}else{
		if (userJson) {
			//$('#response').html('Всё ок');
			//конец сдесь можно отправлять
			$.ajax({
		       url: '/core/config/MainClass.php',
		       type: 'POST',
		       metod:'JSON',
		       data:{"name": name,"responseArray":userJson,"language":lang},
		       success: function(res){
		       		//if(res == 'succes') location.href = 'succes.php';
		       		if (parseInt(res)) {
		       			let qrlink = 'https://test.profinavigator.ru/sertificat.php?user='+res;
						
						if (lang =='en') {
							$('#response').html('<p class="responseParagraf">You have successfully completed the test and can download the certificate.<br>Scan the QR code with your smartphone`s camera or press the download button.</p>'+
							'<div class="qr-code"><img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='+qrlink+'" class="img img-thumbnail"/><br>'+
							'<a href ="'+qrlink+'" class="btn btn-primary">Download</a>'+
							'<a href ="index.php" class="btn btn-success">Reset</a></div>');
							$('header.header-page .container p').html('Download certificate');
						} else {
							$('#response').html('<p class="responseParagraf">Вы удачно завершили тестирование и можете скачать сертификат.<br>Отсканируйте QR-код камерой смартфона или нажмите на кнопку.</p>'+
							'<div class="qr-code"><img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='+qrlink+'" class="img img-thumbnail"/><br>'+
							'<a href ="'+qrlink+'" class="btn btn-primary">Скачать</a>'+
							'<a href ="index.php" class="btn btn-success">Закрыть</a></div>');
							$('header.header-page .container p').html('Скачайте сертификат');
						}
						$('.language').remove();
						$('.questions').remove();
						$('#userName').remove();
						$('#buttondDiv').remove();
		       			console.log(res);
		       		} else{	       		
			       		//console.log(res);
			       		sleep(200); 
			       		$('#response').html(res);
		       		}
		       },
		       error: function(res){
		       		$('#response').html('Ошибка отправки на сервер');
		       }
		    });
			//конец сдесь можно отправлять
		} else{
			if(lang =='en') {$('#response').html('You did not answer all the test questions');} else {$('#response').html('Вы ответили не навсе вопросы теста');}
		}
	}	
});

function sleep(millis) {
    let t = (new Date()).getTime();
    let i = 0;
    while (((new Date()).getTime() - t) < millis) {
        i++;
    }
} 

function TempSendUserFunction(){
	let userJson
	let elements = $('div.questions');
	let questionCount = elements.length;	
	let mas1 = {};
	let sum = 0;
	outer: for (let i = 0; i < questionCount; i++) {
		//console.log(elements[i].children[0].firstChild.data);
		let mas2 = [];	
		let chtype ="";
		mas1[i+1] ={};
		mas1[i+1]["question"] = elements[i].children[0].firstChild.data;
		mas1[i+1]["variant"] = {};
		for (var j = 1; j <= elements[i].children.length-1; j++) {
			mas1[i+1]["variant"][j] = {};
			mas1[i+1]["variant"][j]["inpVal"] = $("label[for='q"+(i+1)+"_ch"+j+"']").text();
			mas1[i+1]["variant"][j]["inpPrice"] = Number($("#q"+(i+1)+"_ch"+j).attr("value"));
			mas1[i+1]["variant"][j]["inpId"] = "q"+(i+1)+"_variant"+j;
			if($("#q"+(i+1)+"_ch"+j).prop("checked")){
				let ch = $("#q"+(i+1)+"_ch"+j).attr("id").substring($("#q"+(i+1)+"_ch"+j).attr("id").indexOf('h')+1);
				sum = sum + Number($("#q"+(i+1)+"_ch"+j).attr("value"));
				chtype = $("#q"+(i+1)+"_ch"+j).attr("type");
				mas2[mas2.length] = ch;
				//console.log($("#q"+(i+1)+"_ch"+j).attr("id"));
			}

		}
		mas1[i+1]["givevariant"] = mas2;
		mas1[i+1]["type"] = chtype;
		mas1[i+1]["givecount"] = mas2.length;
		if (mas1[i+1]["givecount"] == 0) {
			userJson = false;
			sum = 0;
			break outer;
		}		
	}
	if(sum!=0){
		mas1["summa"] = sum;
		mas1["questioncount"] = ""+questionCount+"";
		userJson = JSON.stringify(mas1);
	}
	return userJson;
}