<?
header('Content-type: text/html; charset=UTF-8');
if ($_GET['user']) {
    $user = (int)$_GET['user'];
    include_once'core/config/MainClass.php';
    $us = $main->getUser($user);
}

//в этой переменной пишем html css внешние подключать нельзя, шрифт для пдфок указан
// `id`, `fio`, `value`, `direction`, `link`
if ($us['language'] == 'en') {
	$html = '
	    <!DOCTYPE html>
	    <html>
	        <head>
	            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	            <style type="text/css">
	                * { 
	                  font-family: "DejaVu Sans" !important;
	                }
	                /* следующие свойство убирает рамку*/
					/* о, прикольно, буду знать :D */
	                @page {
					  size: 21cm 29.7cm;
					  margin: 0;
					}
					/* конец следующие свойство убирает рамку*/
					
					body {
						background: url(core/img/bilet-cert-bg.jpg) 100% 100% no-repeat;
						/*background: url(core/img/bg.jpg) 100% 100% no-repeat;*/
					}
					h1,h2,h3,p {
						color: #000080;
						text-align: center;
					}
					h1 {
						text-align: center; 
						margin-top: 200px;
						font-size: 40px;
					}
					
					.info {
						margin-top: 50px;
					}
					
					.footer {
						position: absolute;
						bottom: 45px;
					}
	            </style>
	        </head>
	        <body>
			<img src="core/img/logo.png" width="150" align="right">
			<div class="title">
				<h1>Certificate</h1>
				<p>That states about passing a professional test of “Career Navigator”</p>
	            <h2>'.$us['fio'].'</h2>
			</div>
	        <div class="info">
	            <p>Our algorithms recommend paying your professional interests on<br>&nbsp;'.$us['direction'].'</p><br><br><br>
				<p>You can always find all actual information about popular and perspective professions<br> that exists in the modern labor market, <br>find suitable educational institution for yourself and learn more about needs ofemployers<br> on the website “Career Navigator of Saint Petersburg”</p>
				<h3>profinavigator.ru</h3>
			</div>
			<div class="footer">
	            <p>Saint-Peterburg<br>2019</p>
			</div>
	        </body>
	    </html>
	';
} else {
	$html = '
	    <!DOCTYPE html>
	    <html>
	        <head>
	            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	            <style type="text/css">
	                * { 
	                  font-family: "DejaVu Sans" !important;
	                }
	                /* следующие свойство убирает рамку*/
					/* о, прикольно, буду знать :D */
	                @page {
					  size: 21cm 29.7cm;
					  margin: 0;
					}
					/* конец следующие свойство убирает рамку*/
					
					body {
						background: url(core/img/bg.jpg) 100% 100% no-repeat;
					}
					h1,h2,h3,p {
						color: #000080;
						text-align: center;
					}
					h1 {
						text-align: center; 
						margin-top: 200px;
						font-size: 40px;
					}
					
					.info {
						margin-top: 50px;
					}
					
					.footer {
						position: absolute;
						bottom: 45px;
					}
	            </style>
	        </head>
	        <body>
			<img src="core/img/logo.png" width="150" align="right">
			<div class="title">
				<h1>Сертификат</h1>
				<p>о прохождении профессионального тестирования<br>«Навигатора профессий» получает </p>
	            <h2>'.$us['fio'].'</h2>
			</div>
	        <div class="info">
	            <p>Наши алгоритмы рекомендуют вам обратить<br>свои профессиональные интересы<br>на&nbsp;<strong>'.$us['direction'].'</strong></p><br><br><br>
				<p>Узнать о востребованных и перспективных профессиях на современном<br> рынке труда, найти подходящее учебное заведение и узнать о запросах<br> работодателей вы всегда можете на сайте<br> ГИС «Навигатор профессий Санкт-Петербурга»</p>
				<h3>profinavigator.ru</h3>
			</div>
			<div class="footer">
	            <p>Санкт-Петербург<br>2019</p>
			</div>
	        </body>
	    </html>
	';
}



use Dompdf\Dompdf;
include_once 'core/dompdf2/autoload.inc.php';
$dompdf = new Dompdf();
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Вывод файла в браузер:
$dompdf->stream('sertificat_'.$us['fio'].''); 

// Или сохранение на сервере:
//$pdf = $dompdf->output(); 
//file_put_contents('/schet-10.pdf', $pdf); 


?>