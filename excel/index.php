<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include('./core/main.php'); 


if(isset($_GET['hash'])) {
	$hash = $_GET['hash'];
	if($hash != '$ba357a9e61c4e25d942dd5f4bd2716a7$') {
			die('Доступ запрещен!');
	}
}
else {
	die('Доступ запрещен!');
}
?>
<html>
<head>
    <title>Статистика</title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" />
</head>
<body style="background: #fefe;">
<div class="container" style="background: #fff;padding: 30px; margin-top:50px;">
	<center><h1>Статистика</h1></center>
	<div class="alert alert-info">10/10/19 - Были внесены изменения для формирования pdf документа, теперь таблица печается полностью</div>
    <div class="table-responsive">
	<table id="example" class="table table-bordered display nowrap" style="overflow-x: scroll; overflow-y: scroll; max-width: 100%; display: block; white-space: word-wrap: break-word;">
        <thead>
            <tr>
                <th>Логин</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>ОУ</th>
                <th>Сертификат</th>
                <th>Тип учётки</th>
                <th>Дата редактирования</th>
            </tr>
        </thead>
        <tbody>
        	<?php
        	 $main = new MainClass();
        	   $getStatistic = $main->getStatistic();
        	
        	foreach ($getStatistic as $getStatistic) {
        		$sert = $getStatistic['Сертификат'];
        		if($sert == 'true') {
        			$sert = 'Сертификат получен!';
        		}
        		else {
        			$sert = '';
        		}
                $ped = $getStatistic['if_ped'];
                if($ped == 'true') {
                    $ped = 'Педагог координатор';
                }
                else {
                    $ped = 'Ученик';
                }
        		print '
					<tr>
                		<td>'.$getStatistic['username'].'</td>
                		<td>'.$getStatistic['first_name'].'</td>
                		<td>'.$getStatistic['last_name'].'</td>
                		<td>'.$getStatistic['patronymic'].'</td>
                		<td>'.$getStatistic['email'].'</td>
                		<td>'.$getStatistic['phone_number'].'</td>
                		<td>'.$getStatistic['name'].'</td>
                		<td>'.$sert.'</td>
                        <td>'.$ped.'</td>
                        <td>'.date("d.m.y",$getStatistic['updated_at']).'</td>
            		</tr>
        		';
        	}
        	?>
        </tbody> 
        <tfoot>
            <tr>
                <th>Логин</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>ОУ</th>
                <th>Сертификат</th>
                <th>Тип учётки</th>
                <th>Дата редактирования</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        	 {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: true
                },
                pageSize: 'LEGAL',
                customize: function(doc, config) {
                  var tableNode;
                  for (i = 0; i < doc.content.length; ++i) {
                    if(doc.content[i].table !== undefined){
                      tableNode = doc.content[i];
                      break;
                    }
                  }
 
                  var rowIndex = 0;
                  var tableColumnCount = tableNode.table.body[rowIndex].length;
                   
                  if(tableColumnCount > 5){
                    doc.pageOrientation = 'landscape';
                  }
                }
            },
            {
                extend: 'excel',
            },
            {
                extend: 'copy',
            },
            {
                extend: 'csv',
            },
            {
                extend: 'print',
            }
        ]
    });
});
</script>
</html>
