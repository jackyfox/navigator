<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Ученики';

$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['/profile']];

$this->params['breadcrumbs'][] = $this->title;


if(empty($getStudents)) {
	die('404!');
}
?>



<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="row top_page" style="padding:35px;">
			<h2><?= Html::encode($this->title) ?></h2>
	</div>
	<div class="text_prof">
		<div class="test-info">
			<table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
			  <thead>
			    <tr>
			      <th scope="col">ID Пользователя</th>
			      <th scope="col">Логин</th>
			      <th>Фамилия Имя</th>
			      <th scope="col">Статус тестирования</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  	foreach ($getStudents as $student) {
			  		$sertName ="certForBiletGame.pdf";
			  		$userId = $student['id'];
			  		$link = "upload/profile/".$userId."/certificate/".$sertName;

			  		if(file_exists($link)) {
			  			$test = '<font color="green">Тест пройден!</font> / <a target="_blank" href="'.$link.'">Просмотреть сертификат</a>';
			  		}
			  		else {
			  			$test = '<font color="red">Тест не пройден!</font>';
			  		}

			  		print '
			    	<tr>
			      		<th scope="row"><a href="/profile?id='.$student['id'].'">'.$student['id'].'</a></th>
			      		<td>'.$student['username'].'</td>
			      		<td>'.$student['first_name'].' '.$student['last_name'].'</td>
      					<td>'.$test.'</td>
			   		</tr>
			    	';
				}
				?>
			  </tbody>
			</table>
  		</div>
	</div>

</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('.table').DataTable();
</script>

