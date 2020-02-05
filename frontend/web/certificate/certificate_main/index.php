<?php
	error_reporting(-1);
	include('./config/main.php');
	header('Content-Type: text/html; charset=utf-8');
	#include('./screen.php');
	
	unset($_COOKIE);

  	
  	if(isset($_GET['idCompany']) && isset($_GET['idTest']) && isset($_GET['userName']) && isset($_GET['userID'])) {

		$idCompany = (int)$_GET['idCompany'];
		$idTest = (int)$_GET['idTest'];
		#$userName = $_GET['userName'];
		$userID = $_GET['userID'];

		$test = $main->getTestInfo($idTest);
		$company = $main->getCompanyInfo($idCompany);
		$userInfo = $main->userInfo($userID);

		#$_SESSION['name_test'] = $test[0]['title'];

		#$_SESSION['name_company'] = $company[0]['name'];
		#$_SESSION['logo_company'] = $company[0]['logo'];

		#setcookie('name_test',$test[0]['title']); #header('Set-cookie: name_test='.$test[0]['title'].'');
		#setcookie('name_company',$company[0]['name']); #header('Set-cookie: name_company='.$company[0]['name'].'');
		#setcookie('logo_company',$company[0]['logo']); 
		#header('Set-cookie: name_test='.$test[0]['title'].'; name_company='.$company[0]['name'].'; logo_company='.$company[0]['logo'].'');
		

		print '<script>
			localStorage.setItem("firstName", "'.$userInfo[0]['first_name'].'");
			localStorage.setItem("lastName", "'.$userInfo[0]['last_name'].'");
			localStorage.setItem("name_test", "'.$test[0]['title'].'");
			localStorage.setItem("name_company", "'.$company[0]['name'].'");
			localStorage.setItem("logo_company", "'.$company[0]['logo'].'");
		</script>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style>
		.bg {
			background: url('./bg.png') no-repeat;
		    -moz-background-size: 100%; /* Firefox 3.6+ */
		    -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
		    -o-background-size: 100%; /* Opera 9.6+ */
		    background-size: 100%; /* Современные браузеры */
			padding-bottom: 157px;
		}
		.container {
			margin-top: 40px;
			width: 950px !important;
		}
		.about_test {
			height: auto;
			overflow: hidden;
			margin-top: 120px;
			margin-right: 70px;
			text-align: right;
		}
		.about_test h3 {
			font-size: 42pt;
			font-weight: 500;
		}
		.text_1 {
			font-size: 15pt;
			font-weight: 200;
			margin-top: -15px;
		}
		.text_2{
			font-size: 15pt;
			font-weight: 600;
			margin-top: -20px;
		}
		.footer {
			margin-top: 230px;
		}

		.footer .left {
			float: left;
			margin-top: 44px;
			margin-left: 30px;
		}
		.footer .left img {
			display: block;
			float: left;
		}
		.footer .left p {
			margin-top: 3px;
			float: right;
			font-size: 12pt;
			padding-bottom: 5px;
			padding-top: 5px;
			padding-left: 14px;
			display: block;
			color: white;
			border-left: 1px solid #7a7a7a;
		}
		.footer .left p b {
			display: inline-block;
			margin-top: 0px;
			margin-left: 14px;
		}
		
		.footer .right {
			float: right;
			text-align: right;
			color: white;
			margin-right: 30px;
		}
		.footer .right h5 {
			font-size: 37pt;
		}
		.footer .right p {
			font-size: 12pt;
			font-weight: 100;
			margin-top: -30px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="bg col-lg-12">
				<div class="about_test">
					<h3><script>document.write(localStorage.getItem('name_test'));</script></h3>
					<p class="text_1">за прхождение тестирования компании</p>
					<p class="text_2"><b>«<script>document.write(localStorage.getItem('name_company'));</script>»</b></p>
				</div>
				<div class="footer">
					<div class="left">
						<img id="logo" src="" alt="" width="130">					
						<p>
							<img src="./AV_Autograph.png" alt="" align="left" width="70">
							<b>В. В. Золотой<br>Директор</b>
						</p>
					</div>
					<div class="right">
					
						<h5><script>document.write(localStorage.getItem('firstName'));</script><br>
							<script>document.write(localStorage.getItem('lastName'));</script></h5>
						<!--<h5 style="margin-top: -15px">Фамилия</h5> !-->
						<!--<p>набранно <b>45</b> из <b>50</b> баллов</p>!-->
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="https://profinavigator.ru/assets/60cca70d/jquery.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
	document.getElementById("logo").src = localStorage.getItem("logo_company");
	
	var is_safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

	if(is_safari) {

		var img_page = document.getElementsByTagName('img'); 
		images_page = [];

		for (var i = 0; i < img_page.length; i++) {

			images_page.push(img_page[i].src);

			if(~images_page[i].indexOf('www.dropbox.com')) {
				var src_img = img_page[i].src;
				src_img = src_img.slice(0, -4);
				src_img = src_img+"raw=1";
				
				img_page[i].src = src_img;
			}
			else {
				
			}
		}

		var img_logo = $('#logo_company').attr('src');
		var img_bg = $('.header_page_img').css('background');

		if (~img_bg.indexOf('www.dropbox.com')) { 

			img_bg = img_bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
			img_bg = img_bg.slice(0, -4);
			img_bg = img_bg+"raw=1";

			$('.header_page_img').css({
				background: 'url('+img_bg+')',
				backgroundAttachment: 'fixed',
				backgroundSize: 'cover'
			});

		} else {
			
		}

		if (~img_bg.indexOf('www.dropbox.com')) {
			
			img_logo = img_logo.slice(0, -4);
			img_logo = img_logo+"raw=1"; 
			$('#logo_company').attr('src',img_logo);

		} else {
			
		}

	}


	//конец
</script>
</html>