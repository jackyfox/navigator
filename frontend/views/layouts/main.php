<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?><!--это подключение стилий и прочих функции-->
    <!-- файл для твоих стилей лежит в frontend/web/css/main.css в той же папке второй подключенный-->
</head>
<body class="page page_fix">

<?php $this->beginBody() ?>

<script>
Notification.requestPermission(function(permission){
// переменная permission содержит результат запроса
//console.log('Результат запроса прав:', permission);

	//function clickEventNoti() { alert('Пользователь кликнул на уведомление'); }

	if(permission == 'denied') {
		//console.log('Вы не дали прав на вывод уведомлений!');
	}

	if(permission == 'granted') {
		//Увидомления о событиях
		//var notification = new Notification('Названия события',{ body: 'краткое описание', dir: 'auto', icon: 'icon.jpg' });
		//notification.onclick = clickEventNoti;
	}

	if(permission == 'default') {
		Notification.permission;
	}


});


</script>

<style>

.page {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
}

.page_fix {
    top: 0 !important;
    position: static !important;
}

	/* Прячем панель гугла */

.skiptranslate {
    display: none !important;
}

/* language */

.language {
    position: fixed;
    left: 0px;
    background: #fff;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	padding: 7px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    z-index: 99999;
}

.language__img {
    margin: 2px;
    cursor: pointer;
    opacity: .5;
}

.language__img:hover,
.language__img_active {
    opacity: 1;
}

.chatbot {
 
  box-shadow: 0px 0px 5px #a9aeae;
  width: 350px;
  height: auto;
  z-index:99999;
  background: linear-gradient(270deg, #00C9FF 0%, #00F2FE 103.45%);
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  position: fixed;
  bottom:0px;
  right:50px;
  text-align:center;
  padding-top:25px;
  padding-bottom:25px;
  cursor:pointer;
  overflow: hidden;
}

.chatbot span {
  font-size: 15pt;
  color:white;
  font-weight:bolder;
  font-family: Arial;
  cursor:pointer;
}

.chatbot iframe {
  height:400px;
  margin-top: 20px;
  margin-bottom: -26px;
}


</style>
		<div class="language">
		<img src="img/flag/lang__ru.png" alt="ru" data-google-lang="ru" class="language__img" style="width: 23px !important;margin-bottom:12px;">
		<img src="img/flag/lang__en.png" alt="en" data-google-lang="en" class="language__img" style="width: 23px !important;">
		</div>
<div class="chatbot">
  <span>Задай свой вопрос!</span>
  <iframe src="https://profinavigator.ru/bot/" style="display:none;"></iframe>
</div>

<!--то что выше не трогать если понадобится что ещё пиши-->
<div class="wrap">
	<input type="checkbox" id="nav-toggle" hidden>
	<div class="menu-phone">
	<label for="nav-toggle" class="nav-toggle" onclick=""></label>
		<div class="bg-menu">
			<?php
	    if (Yii::$app->user->isGuest) {
	    	echo "<div><img class=img-circle width=70 height=70 src=https://profinavigator.ru/img/layouts/logo.png></div>";
	        echo Html::a("Вход", ['/site/login'], [
				    'data' => ['method' => 'post'],
				    'class' => 'white text-center',
				]);
	        echo Html::a("Регистрация", ['/site/signup'], [
				    'data' => ['method' => 'post'],
				    'class' => 'white text-center',
				]);
	    } else {
	    	$last_name = Yii::$app->user->identity->last_name;
	    	$first_name = Yii::$app->user->identity->first_name;
	    	$username = Yii::$app->user->identity->username;
	    	$id_user = Yii::$app->user->identity->id;
	    	$avatar_user = Yii::$app->user->identity->avatar;

	    	if(empty($last_name) || empty($first_name)) { 
	    		#$menuItems[] =  '<li><a href="/profile?id='.$id_user.'">Профиль</a></li>';
				echo "<div><img class=img-circle width=50 height=50 src='$avatar_user'></div>";
	    		echo '<p class="user-name">'.$username.'</p>';
	    		echo "<a href=/profile>Профиль</a>";
	    		#echo "<a href='".Yii::$app->createAbsoluteUrl('site/logout')."'>Выход</a>";
	    		echo Html::a("Выход", ['/site/logout'], [
				    'data' => ['method' => 'post'],
				    'class' => 'white text-center',
				]);
	    	
	    	}
	    	else {

				echo "<div><img class=img-circle width=50 height=50 src='$avatar_user'></div>";
	    		echo '<p class="user-name">'.$first_name .' '. $last_name.'</p>';
	    		echo "<a href=/profile>Профиль</a>";
	    		echo Html::a("Выход", ['/site/logout'], [
				    'data' => ['method' => 'post'],
				    'class' => 'white text-center',
				]);

	        }
	    }
			?>
		</div>

		<?= 
		 Nav::widget([
		    'items' => [
		        ['label' => 'Главная', 'url' => ['/site/index']],
		        [
		            'label' => 'Разделы',
		            'options' => ['class' => 'myclass_for_dropdown'],
		            'items' => [
		            	'<li class="divider"></li>',
		                [
			            'label' => 'Кем стать',
			            'url' => ['/site/prof'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Где учиться',
				            'url' => ['/site/since'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Где работать',
				            'url' => ['/site/job'],
				        ],
				        
				        '<li class="divider"></li>',
				        [
				            'label' => 'Карта',
				            'url' => ['/site/map'],
				        ],
				        '<li class="divider"></li>',
		            ],
		        ],
		        ['label' => 'События', 'url' => ['/site/event']],
		        ['label' => 'Блоги', 'url' => ['/site/blog']],
		        ['label' => 'Тесты', 'url' => ['/site/tests'],'visible' => !Yii::$app->user->isGuest],
	        	//['label' => 'Контакты', 'url' => ['/site/contact']],
	        	[
		            'label' => 'О проекте',
		            'url' => ['/site/ourproject'], 
		            'options' => ['class' => 'myclass_for_dropdown'],
		            'items' => [
		            	'<li class="divider"></li>',
		                [
			            'label' => 'Общая информация',
			            'url' => ['/site/ourproject'],
				        ],
		            	'<li class="divider"></li>',
		                [
			            'label' => 'Школьникам',
			            'url' => ['/site/shools'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Студентам',
				            'url' => ['/site/students'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Предприятиям и организациям',
				            'url' => ['/site/jobandorg'],
				        ],
				        
				        '<li class="divider"></li>',
				        [
				            'label' => 'Образовательным организациям',
				            'url' => ['/site/obrorg'],
				        ],
				        '<li class="divider"></li>',
		            ],
		        ],
		        [
		            'label' => 'Партнеры',
		            'url' => ['#'], 
		            'options' => ['class' => 'myclass_for_dropdown'],
		            'items' => [
		            	'<li class="divider"></li>',
		                [
			            'label' => 'WORLD SKILLS',
			            'url' => 'http://wsrnavi.tilda.ws/'
				        ],
		            	'<li class="divider"></li>',
		                [
			            'label' => 'БИЛЕТ В БУДУЩЕЕ',
			            'url' => 'http://biletnavi.tilda.ws/'
				        ],
				        '<li class="divider"></li>'
		            ],
		        ]
	        

		    ],
		    'options' => ['class' =>'navbar-nav'],
		]);
		?>
	</div>
    <?php
    //начало меню

    if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='site/index') {

    	//########################

    	//  ШАПКА ВЕРХ ГЛАВНАЯ 

    	//########################

    	NavBar::begin([
	        'brandLabel' =>'<div class="main-logo"><img src="img/layouts/logo.png" style="display:inline;" alt="' . Yii::$app->name . '"></div>',// div class=navbar-header
	        'brandUrl' => Yii::$app->homeUrl,
	        'options' => [
	            'class' => 'navbar-inverse navbar navbar-expand-lg navbar-dark bg-index-navigation',//классы всей панели навигации
	        ],
	    ]);
		
    }else {

    	//########################

    	//  ШАПКА ВЕРХ ОСТАЛЬНЫЕ СТРАНИЦЫ 

    	//########################

	    NavBar::begin([
	        'brandLabel' =>'<div class="main-logo"><img src="img/layouts/logo.png" style="display:inline;" alt="' . Yii::$app->name . '"></div>',// div class=navbar-header
	        'brandUrl' => Yii::$app->homeUrl,
	        
	        'options' => [
	            'class' => 'navbar-inverse navbar navbar-expand-lg navbar-dark bg-navigation',//классы всей панели навигации
	        ],
	    ]);
	}    
	//ниже описание массивов с элементами меню для работы виджета
	    $menuItems = [
	        ['label' => 'Главная', 'url' => ['/site/index']],
	        ['label' => 'Разделы', 'url' => ['#'],
		    'items' => [
			        [
			            'label' => 'Кем стать',
			            'url' => ['/site/prof'],
			        ],
			        [
			            'label' => 'Где учиться',
			            'url' => ['/site/since'],
			        ],
			        [
			            'label' => 'Где работать',
			            'url' => ['/site/job'],
			        ],
			       
			        [
			            'label' => 'Карта',
			            'url' => ['/site/map'],
			        ],
		       	]
    		],
	        ['label' => 'События', 'url' => ['/site/event']],
	        ['label' => 'Блоги', 'url' => ['/site/blog']],
	        ['label' => 'Тесты','url' => ['/site/tests'],'visible' => !Yii::$app->user->isGuest],
	        //['label' => 'Контакты', 'url' => ['/site/contact']],
	        [
		            'label' => 'О проекте',
		            'url' => ['/site/ourproject'], 
		            'options' => ['class' => 'myclass_for_dropdown'],
		            'items' => [
		            	'<li class="divider"></li>',
		                [
			            'label' => 'Общая информация',
			            'url' => ['/site/ourproject'],
				        ],
		            	'<li class="divider"></li>',
		                [
			            'label' => 'Школьникам',
			            'url' => ['/site/shools'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Студентам',
				            'url' => ['/site/students'],
				        ],
				        '<li class="divider"></li>',
				        [
				            'label' => 'Предприятиям и организациям',
				            'url' => ['/site/jobandorg'],
				        ],
				        
				        '<li class="divider"></li>',
				        [
				            'label' => 'Образовательным организациям',
				            'url' => ['/site/obrorg'],
				        ],
				        '<li class="divider"></li>',
		            ],
		        ],
		        [
		            'label' => 'Партнеры',
		            'url' => ['#'], 
		            'options' => ['class' => 'myclass_for_dropdown'],
		            'items' => [
		            	'<li class="divider"></li>',
		                [
			            'label' => 'WORLD SKILLS',
			            'url' => 'http://wsrnavi.tilda.ws/'
				        ],
		            	'<li class="divider"></li>',
		                [
			            'label' => 'БИЛЕТ В БУДУЩЕЕ',
			            'url' => 'http://biletnavi.tilda.ws/'
				        ],
				        '<li class="divider"></li>'
		            ],
		        ]
	        
	    ];

	    if (Yii::$app->user->isGuest) {
	       $menuItems[] = ['label' => 'Зарегистрироваться', 'url' => ['/site/signup']];
	        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
	    } else {
	    	$last_name = Yii::$app->user->identity->last_name;
	    	$first_name = Yii::$app->user->identity->first_name;
	    	$username = Yii::$app->user->identity->username;
	    	$id_user = Yii::$app->user->identity->id;
	    	$avatar_user = Yii::$app->user->identity->avatar;

	    	if(empty($last_name) || empty($first_name)) { 
	    		#$menuItems[] =  '<li><a href="/profile?id='.$id_user.'">Профиль</a></li>';
	    		$menuItems[] =  [
		    		'encode'=>false,
		    		'label' => '<span id="nickname">'.$username.'</span><img class="img-circle" width="30" height="30" src="'.$avatar_user.'">', 
		    		'url' => ['/site/profile'], 
		    		'options'=>['class'=>'profile_link dropdown'],
		    		'items' => [
		    			['label' => 'Профиль', 'url' => '/profile'],
		    			['encode'=>false, 'label' => '<li>'
		            . Html::beginForm(['/site/logout'], 'post')
		            . Html::submitButton(
		                'Выход (' . Yii::$app->user->identity->username . ')',
		                ['class' => 'btn btn-link logout']
		            )
		            . Html::endForm()
		            . '</li>', 'url' => '/site/logout'],
		    		]
	    		];
	    	
	    	}
	    	else {
	    		$menuItems[] =  [
		    		'encode'=>false,
		    		'label' => '<span id="nickname">'.$first_name.' <br> '.$last_name.' </span><img class="img-circle" width="50" height="50" src="'.$avatar_user.'">', 
		    		'url' => ['/site/profile'], 
		    		'options'=>['class'=>'profile_link dropdown'],
		    		'items' => [
		    			['label' => 'Профиль', 'url' => '/profile'],
		    			['encode'=>false, 'label' => '<li>'
		            . Html::beginForm(['/site/logout'], 'post')
		            . Html::submitButton(
		                'Выход (' . Yii::$app->user->identity->username . ')',
		                ['class' => 'btn btn-link logout']
		            )
		            . Html::endForm()
		            . '</li>', 'url' => '/site/logout'],
		    		],
	    		];
	        }
	    }	
	
	    echo Nav::widget([
	        'options' => ['class' => 'navbar-nav navbar-right'],// класс виджета кнопок меню, описанного выше
	        'items' => $menuItems,//массив заголовков виджета кнопок меню, описанного выше
	    ]);
	    NavBar::end();
	    //конец меню

    ?>
    <?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index') { ?>
    <div id="particles-js" style="position: absolute;top:0px;"></div>
	<?php } ?>
	<?php if (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id =='site/index') { ?>
		<div class="header-container">
			<p>ГОРОДСКАЯ ИНФОРМАЦИОННАЯ СИСТЕМА «НАВИГАТОР ПРОФЕССИЙ САНКТ-ПЕТЕРБУРГА»</p>
			<h1 class="main-title">ПРОБУЙ СЕБЯ ВО ВСЕМ!</h1>
			<?php if (Yii::$app->user->isGuest) { ?>
			<div class="btn-registration">
				<a href="/signup">РЕГИСТРАЦИЯ В СИСТЕМЕ</a>
			</div>
			<?php } ?>
		</div>
	<?php } ?>
	
    <!--после nav-->
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() //тут вызов?>
        <?= $content ?>
    </div>

</div>


<footer class="footer">
    <div class="container">
		<div class="row">
			<div class="col-lg-3 footer-item">
				<h2>© <?= $_SERVER['HTTP_HOST'] ?> 2019</h2>
				<h2>ВСЕ ПРАВА ЗАЩИЩЕНЫ</h2>
				<p><a href="/doc/Политика в отношении обработки персональных данных.pdf" target="_blank">Политика конфиденциальности</a></p>
				<!--<p><a href="#">Пользовательское соглашение</a></p>!-->
			</div>
			<!--меню футера-->
			<div class="col-lg-3 footer-item">
			<?php 
				array_splice($menuItems, 7, 0, "");
				$menuItems['7'] = [
					'label' => 'Конкурс инновационных продуктов', 'url' => ['/site/inno'],
		    	];

				echo Nav::widget([
					'items' => $menuItems,
					'options' => ['class' =>''],// класс виджета кнопок меню его можно менять!!! 
			]);?>
			</div>
			<!--конец меню футера-->
			<div class="col-lg-3 footer-item">
				<h2>СОТРУДНИЧЕСТВО</h2>
				<p>Если вы заинтересованы в сотрудничестве с нами, напишите по адресу</p>
				<p><a href="mailto:navigator@adtspb.ru?subject=Сотрудничество по ГИС Навигатор">navigator@adtspb.ru</a></p>
			</div>
			<div class="col-lg-3 footer-item">
				<h2>СОЦИАЛЬНЫЕ СЕТИ</h2>
			</div>
		</div>
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right">
        	Разработано <a href="https://adtspb.ru">ГБНОУ &laquo;Академия цифровых технологий&raquo;</a>
        	<!--<?= Yii::powered() ?>-->		
        </p>
    </div>
	<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		   ym(55157164, "init", {
		        clickmap:true,
		        trackLinks:true,
		        accurateTrackBounce:true,
		        webvisor:true
		   });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/55157164" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</footer>
<?php 
        	/*echo "<pre>";
        	var_dump($menuItems);
        	echo "</pre>";*/
        ?>
<!--ниже тоже не трогать-->
<?php $this->endBody() ?>
</body>

</html>
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
 
 <style>
 	#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: transparent;
  background-image: url("");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 50% 50%;
}
#w4-collapse {
	position: relative !important;
	z-index: 1 !important;
}

 </style>
<script>

$('.chatbot').click(function(){
     $('.chatbot iframe').toggle("slide");
});

/* ---- particles.js config ---- */

particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 180,
      "density": {
        "enable": true,
        "value_area": 1100
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.5,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 6,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "grab"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 140,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});


</script>
<?php $this->endPage() ?>



