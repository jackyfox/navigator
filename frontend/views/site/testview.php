<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title =$varArrayTest['title'];

$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['/tests']];

$this->params['breadcrumbs'][] = $this->title;

if(empty($varArrayTest)) {
  die('404!');
}
?>
	<style>


iframe
{
    width: 1280px !important;
    height: 786px !important;
    border: 0;

    -ms-transform: scale(0.45);
    -moz-transform: scale(0.45);
    -o-transform: scale(0.45);
    -webkit-transform: scale(0.45);
    transform: scale(0.45);

    -ms-transform-origin: 0 0;
    -moz-transform-origin: 0 0;
    -o-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
}
	</style>
<div id="certificateResultModal" class="modal fade">
	<div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Результат</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
         <div id="certificateResult"></div>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>

</div>

<div class="container text-description" style="background-color: #FCFCFC;width: 100%;">
	<div class="header_page_img row" style="background: url('<?=$varArrayTest['img']?>') 10% 100% no-repeat;	background-attachment: fixed;
	background-size: cover;">
		<div class="title_page col-lg-9"><h3><?=$varArrayTest['title']?></h3>
			<!--<div id="button_favorite">
				<a  userid="<?=Yii::$app->user->id?>" id="<?=$_GET['id']?>" class="favorite btn">Добавить в избранное</a>
			</div>-->
		</div>
	</div>	
	<div class="text_prof">
	<div class="test-info">
		<?=$varArrayTest['description']?>
		<p style="display:none;">Время на тест: <?=$varArrayTest['timeTest']?></p>
		<p>Кол-во получаемого опыта за тест: <?=$varArrayTest['exp']?> ед. опыта</p>
		<p>Дата проведения: <?=$varArrayTest['data_start']?> - <?=$varArrayTest['data_end']?></p>
		<p>Сертификат: 
        <?php 
          if(!empty($varArrayTest['certificate'])) {
            $certificate = 'Выдается';
            echo $certificate;
          } else {
            $certificate = 'Не выдается';
            echo $certificate;
          }
        ?>
		</p>
  </div>

	<?php 
	$data = date("Y-m-d");
	$data_start = $varArrayTest['data_start'];
	$data_end = $varArrayTest['data_end'];

	#echo $data;
	if($data < $data_start || $data > $data_end) {
		if(!empty($arrayUserComplite)) {
			if(!empty($varArrayTest['certificate'])) {
				print '<div class="alert alert-success">Вы прошли тест и теперь можете забрать сертификаит использую кнопку ниже</div>';
				print '<span class="getcert btn btn-info" id="getcert">Просмотреть свой сертификат</span>';
			}
			else {
				print '<div class="alert alert-success">Вы прошли тест, результаты тестирования направлены организатору теста!</div>';
			}
		}
		else {
			if($data > $data_end) {
				print '<div class="alert alert-danger"><p>Тест окончен!</p></div>';
			}
			if($data < $data_start) {
				print '<div class="alert alert-warning"><p>Тест скоро начнется! Дата начала - '.$data_start.'</p></div>';
			}
		}

	} 
	else  {

	if(empty($arrayUserComplite)) {
		if(!empty($varArrayTest['ArrayWithQuerstion'])) {
			print '
			<div class="card border-danger mb-3">
			<div class="card-header" id="headingOne">
				<h2 class="mb-0">
					<button class="btn btn-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					Пройти тест
				</button>
				</h2>
			</div><div id="collapseOne" class="collapse" aria-labelledby="headingOne">
			<div class="card-body">';
			#print '<h2>Тест: '.$varArrayTest['title'].'</h2>';

			$json_str = '{"tests":'.$varArrayTest['ArrayWithQuerstion'].'}';

			$obj = json_decode($json_str); // получим объект
		

			$tests = $obj->tests;


			echo "<div class='test-user'><form id='test-form'><div id='question-group-for-otvet'>";
			$i=1;
			
			foreach ($tests as $key => $keyJson) {
				$key_count = (int)$key;

				if ($key_count == 0) continue;
				echo '<div class="questions" id="questions'.$i.'">';
				echo '<label class="vopr" for="questions'.$i.'">'.$keyJson->qustion.'</label>';
				$type = $keyJson->type;

				$j=1;
				foreach ($keyJson->variant as $key => $variant) {

					$id = $variant->inpId;
					$variant_name = $variant->inpVal;
					
					if($type == 'radio') {	
						print '<div class="form-check">
								<input name="q'.$i.'_ch" type="radio" id="q'.$i.'_ch'.$j.'">
									<label for="q'.$i.'_ch'.$j.'">'.$variant_name.'</label>
							   </div>';
					}
					if($type == 'checkbox') {
						print '<div class="form-check">
								<input name="q'.$i.'_ch'.$j.'"  type="checkbox" id="q'.$i.'_ch'.$j.'">
								<label for="q'.$i.'_ch'.$j.'">'.$variant_name.'</label>
							   </div>';
					}
					$j++;
				}
				echo "</div>";
				$i+=1;
			}

			#print_r($tests);

			print '<span id_test="'.$_GET['id'].'" id="test_send_user" class="test_send_user btn btn-info">Отправить</span>';

			echo "</div></form></div>";
			print '</div></div></div>';

		}
	}
	else {
		if(!empty($varArrayTest['certificate'])) {
			print '<div class="alert alert-success">Вы прошли тест и теперь можете забрать сертификаит использую кнопку ниже</div>';
			print '<span class="getcert btn btn-info" id="getcert">Просмотреть свой сертификат</span>';
		}
		else {
			print '<div class="alert alert-success">Вы прошли тест, результаты тестирования направлены организатору теста!</div>';
		}
	}
	
	}
	?>

</div>

<?php if(empty($sliderArray))  { } else { ?>
<div class="slider_prof">
	<h3><b>Слайдер</b></h3>
	<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel" style="margin:0px auto; width:100%;">
    	<!-- Carousel indicators 
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        Wrapper for carousel items -->
        <div class="carousel-inner">
        	<?php
        		if(empty($sliderArray)) {

        		}
        		else {
	        		foreach ($sliderArray as $keySlider) {
	        			print '
	        				<div class="item">
				                <img src="'.$keySlider['img'].'" alt="First Slide">
				         		<!--<div class="carousel-caption">
				                  <h3>First slide label</h3>
				                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				                </div>!-->
				            </div>
	        			';
	        		}
        		}
            ?>
        </div>
                <?php 
        if(empty($sliderArray)) 
        {

        }
        else {
        	        print '
			        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
			            <span class="glyphicon glyphicon-chevron-left"></span>
			        </a>
			        <a class="carousel-control right" href="#myCarousel" data-slide="next">
			            <span class="glyphicon glyphicon-chevron-right"></span>
			        </a>';
        }
        ?>
    </div>
</div>
<?php } ?>
	
	<div class="since_prof">
		<?php if(!empty($varArrayOrg)) { ?><h3><b>Организация</b></h3> <?php } ?>
		<div class="multiple-items">
			<?php foreach ($varArrayOrg as $keyOrg) { 
				print '
					<div class="prof_review">
						<a href="/jobview?id='.$keyOrg['id'].'">
							<img src="'.$keyOrg['img'].'" alt="" width="270" height="180">
							<h4>'.$keyOrg['name'].'</h4>
						</a>
					</div>
				';
				
		  	} ?>
		</div>
	</div>

</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
