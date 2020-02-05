<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;


/**
	 * Счетчик обратного отсчета
	 *
	 * @param mixed $date
	 * @return
	 */
	function downcounter($date){
	    $check_time = strtotime($date) - time();
	    if($check_time <= 0){
	        return false;
	    }

	    $days = floor($check_time/86400);
	    $hours = floor(($check_time%86400)/3600);
	    $minutes = floor(($check_time%3600)/60);
	    $seconds = $check_time%60; 

	    $str = '';
	    if($days > 0) $str .= declension($days,array('день','дня','дней')).' ';
	    if($hours > 0) $str .= declension($hours,array('час','часа','часов')).' ';
	    if($minutes > 0) $str .= declension($minutes,array('минута','минуты','минут')).' ';
	    if($seconds > 0) $str .= declension($seconds,array('секунда','секунды','секунд'));

	    return $str;
	}


	/**
	 * Функция склонения слов
	 *
	 * @param mixed $digit
	 * @param mixed $expr
	 * @param bool $onlyword
	 * @return
	 */
	function declension($digit,$expr,$onlyword=false){
	    if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
	    if(empty($expr[2])) $expr[2]=$expr[1];
	    $i=preg_replace('/[^0-9]+/s','',$digit)%100;
	    if($onlyword) $digit='';
	    if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
	    else
	    {
	        $i%=10;
	        if($i==1) $res=$digit.' '.$expr[0];
	        elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
	        else $res=$digit.' '.$expr[2];
	    }
	    return trim($res);
	}


?>

<?php  if (Yii::$app->user->isGuest) { echo "Доступ запрещен!"; } else { ?>

<?php if(!isset($_GET['id'])) { ?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Загрузка сертификата</h4>
      </div>
      <div class="modal-body">
 <form>
 	<center>
  <div class="form-group">
    <label>Название</label>
    <input type="text" class="form-control" name="titleFilePortfolio" id="titleFilePortfolio" aria-describedby="titleHelp" placeholder="Введите название сертификата" required>
    <small id="titleHelp" class="form-text text-muted">Название вашего загружаемого сертификата</small>
  </div>
  <div class="form-group">
    <label>Выберите файл</label>
    <input type="file" class="form-control" id="filePortfolio">
    <small id="titleHelp" name="filePortfolio" class="form-text text-muted" style="color: red;">вы можете загружать только pdf,jpg,png файлы</small>
  </div>
  <button type="submit" class="uploadCertificate btn btn-primary">Отправить</button>
</center>
</form></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>
<?php } ?>

<div class="site-about">
    <h1 style="display: none;"><?= Html::encode($this->title) ?></h1>
	<div class="container" style="overflow: hidden;width: 100%;">
		<?php if(isset($_GET['id'])) { if(empty($varInView)) { echo "Пользователь не найден!"; } else { ?>
			<?php if(Yii::$app->user->identity->id === isset($_GET['id'])) { echo "<script> window.location = '/profile'; </script>"; }  ?>
			<!-- ################################### !-->
			<!-- ################################### !-->
			<!-- Это нужно для вывода другого профиля если передан id  !-->
			<!-- ################################### !-->
			<!-- ################################### !-->

			<div class="row" id="profile">
				
				<div class="col-lg-3">
					<div class="progress blue">
		                <span class="progress-left">
		                    <span class="progress-bar"></span>
		                </span>
		                <span class="progress-right">
		                    <span class="progress-bar"></span>
		                </span>
		                <div id="progress-value" class="progress-value">
		                	<img src="<?= $varInView[0]['avatar']; ?>" class="img-circle img-thumbnail avatar" width="160" align="left" style="margin-bottom: 10px;height: 100%;">
		                	<!-- ################################### !-->
							<!-- ################################### !-->
							<!-- Прогресс пользователя (уровень и опыт)  !-->
							<!-- ################################### !-->
							<!-- ################################### !-->
		                	<style>
		                		@keyframes loading-1{
								    0%{
								        -webkit-transform: rotate(0deg);
								        transform: rotate(0deg);
								    }
								    100%{
								       
								   		<?php
								   			#$xp = $varInView[0]['experience'];
								   			$xp = $varInViewProfileTable['expirience'];
								   			if($xp > 180) {
												print ' -webkit-transform: rotate(180deg);';
								   				print 'transform: rotate(180deg);';
								   			} 
								   			else {
								   				print '-webkit-transform: rotate('.$xp.'deg);';
								   				print 'transform: rotate('.$xp.'deg);';
								   			}
								   		?>
								        
								    }
								}
								@keyframes loading-2{
								    0%{
								        -webkit-transform: rotate(0deg);
								        transform: rotate(0deg);
								    }
								    100%{
								        <?php
								   			#$xp = $varInView[0]['experience'];
								   			$xp = $varInViewProfileTable['expirience'];
								   			if($xp > 180) {
								   				$xp_formila = $xp - 180;
								   				if($xp === 360 ) {
													print ' -webkit-transform: rotate(180deg);';
								   					print 'transform: rotate(180deg);';
								   				}
								   				else {
								   					print '-webkit-transform: rotate('.$xp_formila.'deg);';
								   					print 'transform: rotate('.$xp_formila.'deg);';
								   				}
								   			} 
								   			else {
								   				print ' -webkit-transform: rotate(0deg);';
								   				print 'transform: rotate(0deg);';
								   			}
								   		?>
								    }
								}
		                	</style>
		                	
		                </div>
		            </div>
					<center>
						<p class="lvl">Уровень <b> 
							<?= $varInViewProfileTable['level'];?></b><br>
							<!--<i><?php #echo Yii::$app->user->identity->experience; ?>%</i>!-->
						</p>
					</center>
					
				</div>
				<div class="col-lg-3" style="color: white;">
					<h3 class="user_name"><b>
						<?php 
							if(empty($varInView[0]['first_name']) || empty($varInView[0]['last_name'])) {
								echo $varInView[0]['username'];
							}
							else {
						?>
						<?= $varInView[0]['first_name']; ?> <?= $varInView[0]['last_name']; ?>
						<?php } ?>
						</b></h3>
					<p class="type_user"><i><?= $varInView[1]['name']; ?></i></p>
				</div>
				<div id="achiv">
					Последнее достижение
					<div class="row">
						<div class="col-lg-4 last_achiv">
							<img src="<?=$getAchiv['img']?>" alt="" style="width: 30px;">
							<h4><?=$getAchiv['name']?></h4>
							<p style="font-size: 8pt;"><?=$getAchiv['description']?></p>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ################################### !-->
			<!-- ################################### !-->
			<!-- Нижняя часть профиля !-->
			<!-- ################################### !-->
			<!-- ################################### !-->
			<div class="row">
				<div class="col-lg-3">
					<ul class="menu_profile">
						<!-- ################################### !-->
						<!-- пункты меню табов  !-->
						<!-- ################################### !-->
						<li class="active"><a data-toggle="tab" href="#panel1"><i class="fas fa-user"></i>Профиль</a></li>
						<li><a data-toggle="tab" href="#panel2"><i class="fas fa-briefcase"></i> Портфолио</a></li>
						<li><a data-toggle="tab" href="#panel4"><i class="far fa-calendar-check"></i> Мероприятия</a></li>
						<li><a data-toggle="tab" href="#panel5"><i class="far fa-lightbulb"></i> Достижения</a></li>
					</ul>
				</div>
				<!-- ################################### !-->
				<!-- табы   !-->
				<!-- ################################### !-->
				<div class="col-lg-9" class="right_tabs_profile">
						<div class="tab-content">
						  <div id="panel1" class="tab-pane fade in active">
						    <h3>Основная информация</h3>

						    <?php 
								if(!empty($getSchoolUserMainPage['school'])) {
									#echo count($getSchoolUserMainPage);
									#print_r($getSchoolUserMainPage);
									print '<h3>Место обучения: <h3><ul style="padding:0px;"><li style="list-style:none;"><a class="my-company-list" href="/sinceview?id='.$getSchoolUserMainPage['id'].'">'.$getSchoolUserMainPage['name'].'</a></li></ul>';
								} 
							?>

						    <?php
						    if(empty($arrayUserCompany)) {

						    }
						    else {
						    	echo "<h3>Мои компании</h3><ul>";
						    	$user_id = Yii::$app->user->identity->id;

						    	foreach ($arrayUserCompany as $keyMyCompany) {
						    		if($keyMyCompany['type_id'] != 4) {
						    			if($user_id == $_GET['id']) {
						    				print '<li style="list-style: none;"><a href="/sinceview?id='.$keyMyCompany['id'].'">'.$keyMyCompany['name'].'</a>
											<a class="my-company-list" href="/mycompany?id='.$keyMyCompany['id'].'" class="btn btn-info">Редактировать</a>
						    				</li><br>';
						    			}
						    			else {
						    				print '<li style="list-style: none;"><a class="my-company-list" href="/sinceview?id='.$keyMyCompany['id'].'">'.$keyMyCompany['name'].'</a>
											</li><br>';
						    			}
						    			

						    		}
						    		else {
						    			if($user_id == $_GET['id']) {
						    				print '<li style="list-style: none;"><a class="my-company-list" href=/jobview?id='.$keyMyCompany['id'].'>'.$keyMyCompany['name'].'</a>
											<a href=/mycompany?id='.$keyMyCompany['id'].' class="btn btn-info">Редактировать</a>
							    			</li><br>';
							    		}
							    		else {
							    			print '<li style="list-style: none;"><a class="my-company-list" href=/jobview?id='.$keyMyCompany['id'].'>'.$keyMyCompany['name'].'</a>
											
							    			</li><br>';
							    		}
						    		}
						    		
						    	}
						    	echo "</ul>";
						    }
						    ?>
						    <?php if(!empty($getCompetenct)) { ?>
							<h3 style="display:inline-block;">Мои компетенции</h3>
							<p style="display:inline-block;">В этом я хорош!</p>
							<div class="horizontal-scroll">
								<ul>
									<?php
									foreach ($getCompetenct as $keyComp) {
										print '<li><span>'.$keyComp['name'].'</span></li>';
									}
									?>
								</ul>
							</div>
							<?php } ?>

							<?php if(!empty($varInView[0]['about'])) { ?>
							<h3>Обо мне</h3>
							<div class="horizontal-scroll">
								<?=$varInView[0]['about']?>
							</div>
							<?php } ?>

							<?php if(!empty($varInViewProfessionUser)) { ?>

							<h3>Избранные профессии</h3>
							<div class="horizontal-scroll">

							<?php 
							print '<div class="multiple-items">';
							 $len_obr = count($varInViewProfessionUser);
								foreach ($varInViewProfessionUser as $profesions_vyzs) { 
								
									print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
									<a href="/viewprof?id='.$profesions_vyzs['id_profession'].'">
									<img src="'.$profesions_vyzs['img'].'" alt="" width="270" height="180">
									<h4>'.$profesions_vyzs['name'].'</h4></a>
									</div>';
								}
							print '</div>';
							?>
							<div class="action">
							<?php print '  <input id="action_one_range" type="range" min="1" max="'.$len_obr.'"  value="0" step="1">'; ?>
							</div>

							</div>
							<?php } ?>

							<?php if(!empty($varInViewOrgUser)) { ?>
						    <h3>Избранные организации</h3>
							<div class="horizontal-scroll">
							
							<?php 

							print '<div class="multiple-items-two">';
								$len_obr_two = count($varInViewOrgUser);

								foreach ($varInViewOrgUser as $keyFavoriteOrg) { 
								
									if(keyFavoriteOrg['id_type'] != 4) {
										print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
										<a href="/sinceview?id='.$keyFavoriteOrg['organisation_id'].'">
										<img src="'.$keyFavoriteOrg['img'].'" alt="" width="270" height="180">
										<h4>'.$keyFavoriteOrg['name'].'</h4></a>
										</div>';
									}
									else {

										print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
										<a href="/jobview?id='.$keyFavoriteOrg['organisation_id'].'">
										<img src="'.$keyFavoriteOrg['img'].'" alt="" width="270" height="180">
										<h4>'.$keyFavoriteOrg['name'].'</h4></a>
										</div>';							
									}
								}
							print '</div>';

							?>
							<div class="action">
							<?php print '  <input id="action_one_range-two" type="range" min="1" max="'.$len_obr_two.'"  value="0" step="1">'; ?>
							</div>
							</div>
							<?php } ?>
						  </div>
						  <div id="panel2" class="tab-pane fade">
						    <h3>Портфолио</h3>
						  
						    <?php if(!empty($getUserSertCustom)) { print '<h3>Сертификаты Пользователя:</h3>'; } ?>
							<div class="portfolio_flex">
							<?php
								foreach ($getUserSertCustom as $getUserSertCustom) {
						    		print '
									<div class="portfolio">
									
									
										<object data="'.$getUserSertCustom['link'].'" width="100%" height="auto"></object>
							    		<h4>'.$getUserSertCustom['title'].'</h4>
							    	
									</div>
						    		';
						    	} 
						    ?>
							</div>
						    <?php if(!empty($getSert)) { print '<h3>Сертификаты НАВИГАТОР:</h3>'; } ?>
							<div class="portfolio_flex">
						    <?php
						    	foreach ($getSert as $sert) {
						    		print '
									<div class="portfolio">
									
									<a href="/testview?id='.$sert['id_test'].'" style="margin-top: 15px;display:block;">
										<object data="'.$sert['link_certificate'].'" width="100%" height="150"></object>
							    		<h4>'.$sert['title'].'</h4>
							    	</a>
									</div>
						    		';
						    	}
						    ?>
							</div>
						  </div>
						  <div id="panel4" class="tab-pane fade">
						    <h3>Мероприятия</h3>
						   <?php
						   	
						    foreach ($varArrayUserEvent as $keyUserEvent) {
						    	print '
								<div class="row my-event">
									<div class="col-lg-3">
								    	<a href="/eventview?id='.$keyUserEvent['id_event'].'">
											<img src="'.$keyUserEvent['picture'].'" alt="" class="img-thumbnail" width="320">
										</a>
									</div>
									<div class="col-lg-9">
										<a href="/eventview?id='.$keyUserEvent['id_event'].'">
								    		<h4>'.$keyUserEvent['title'].'</h4>
								    	</a>
								    	<span class="alert-info">'.$keyUserEvent['event_time'].'</span>
								    	<p>'.substr($keyUserEvent['description'],0, 255).'...</p>	
								    </div>								
								</div>
						    	';
						    }
						   ?>
						  </div>
						  <div id="panel5" class="tab-pane fade">
						    <h3>Достижения</h3>
							<div class="list-achiv-flex">
							<?php 
							foreach($getAllAchivUser as $keyAchiv) {
							 	print '
							    	<div class="list-achiv">
							    		<img src="'.$keyAchiv['img'].'" width="40" height="40" alt="">
							    		<h4>'.$keyAchiv['name'].'</h4>
							    		<p>'.$keyAchiv['description'].'</p>
							    	</div>
							    ';
							}
						    ?>
							</div>
						  </div>
						</div>
				</div>
			</div>

	
		<?php } } else { ?>
			<!-- ################################### !-->
			<!-- ################################### !-->
			<!-- Это нужно для вывода профиля если  не передан id  !-->
			<!-- ################################### !-->
			<!-- ################################### !-->
			
			<div class="row" id="profile">
				
				<div class="col-lg-3">
					<div class="progress blue">
		                <span class="progress-left">
		                    <span class="progress-bar"></span>
		                </span>
		                <span class="progress-right">
		                    <span class="progress-bar"></span>
		                </span>
		                <div id="progress-value" class="progress-value">
		                	<img src="<?=Yii::$app->user->identity->avatar ?>" class="img-circle img-thumbnail avatar" width="160" align="left" style="margin-bottom: 10px;height: 100%;">
		                	<!-- ################################### !-->
							<!-- ################################### !-->
							<!-- Прогресс пользователя (уровень и опыт)  !-->
							<!-- ################################### !-->
							<!-- ################################### !-->
		                	<style>
		                		@keyframes loading-1{
								    0%{
								        -webkit-transform: rotate(0deg);
								        transform: rotate(0deg);
								    }
								    100%{
								       
								   		<?php
								   			#$xp = Yii::$app->user->identity->experience;;
								   			$xp = $varInViewProfileTable['expirience'];
								   			if($xp > 180) {
												print ' -webkit-transform: rotate(180deg);';
								   				print 'transform: rotate(180deg);';
								   			} 
								   			else {
								   				print '-webkit-transform: rotate('.$xp.'deg);';
								   				print 'transform: rotate('.$xp.'deg);';
								   			}
								   		?>
								        
								    }
								}
								@keyframes loading-2{
								    0%{
								        -webkit-transform: rotate(0deg);
								        transform: rotate(0deg);
								    }
								    100%{
								        <?php
								   			#$xp = Yii::$app->user->identity->experience;
											$xp = $varInViewProfileTable['expirience'];
								   			if($xp > 180) {
								   				$xp_formila = $xp - 180;
								   				if($xp === 360 ) {
													print ' -webkit-transform: rotate(180deg);';
								   					print 'transform: rotate(180deg);';
								   				}
								   				else {
								   					print '-webkit-transform: rotate('.$xp_formila.'deg);';
								   					print 'transform: rotate('.$xp_formila.'deg);';
								   				}
								   			} 
								   			else {
								   				print ' -webkit-transform: rotate(0deg);';
								   				print 'transform: rotate(0deg);';
								   			}
								   		?>
								    }
								}
		                	</style>
		                	
		                </div>
		            </div>
					<center>
						<p class="lvl">Уровень <b> 
							<?php echo $varInViewProfileTable['level']; ?></b><br>
							<!--<i><?php #echo Yii::$app->user->identity->experience; ?>%</i>!-->
						</p>
					</center>
					
				</div>
				<div class="col-lg-3" style="color: white;">
					<h3 class="user_name"><b>
						<?php 
						if(empty(Yii::$app->user->identity->first_name) || empty(Yii::$app->user->identity->last_name)) {
							echo Yii::$app->user->identity->username;
						}
						else {
							echo Yii::$app->user->identity->first_name.' '; 
							echo Yii::$app->user->identity->last_name;
						}
						?>
						</b></h3>
					<p class="type_user"><i><?php echo $varInView['name']; ?></i></p>

				</div>
				<div id="achiv">
					Последнее достижение
					<div class="row">
						<div class="col-lg-4 last_achiv">
							<img src="<?=$getAchiv['img']?>" alt="" style="width: 30px;">
							<h4><?=$getAchiv['name']?></h4>
							<p style="font-size: 8pt;"><?=$getAchiv['description']?></p>
						</div>
					</div>
				</div>
			</div>
			<!-- ################################### !-->
			<!-- ################################### !-->
			<!-- Нижняя часть профиля !-->
			<!-- ################################### !-->
			<!-- ################################### !-->
			<div class="row">
				<div class="col-lg-3">
					<ul class="menu_profile">
						<!-- ################################### !-->
						<!-- пункты меню табов  !-->
						<!-- ################################### !-->
						<li class="active"><a data-toggle="tab" href="#panel1"><i class="fas fa-user"></i> Мой профиль</a></li>
						<li><a data-toggle="tab" href="#panel2"><i class="fas fa-briefcase"></i> Портфолио</a></li>
						<li class="lipanel3"><a data-toggle="tab" href="#panel3"><i class="fas fa-comment-alt"></i> Оповещения</a></li>
						<li><a data-toggle="tab" href="#panel4"><i class="far fa-calendar-check"></i> Мероприятия</a></li>
						<li><a data-toggle="tab" href="#panel5"><i class="far fa-lightbulb"></i> Достижения</a></li>
					</ul>
				</div>
				<!-- ################################### !-->
				<!-- табы   !-->
				<!-- ################################### !-->
				<div class="col-lg-9" class="right_tabs_profile">
						<div class="tab-content">
						  <div id="panel1" class="tab-pane fade in active">
						    <h3>Основная информация</h3>

							<a href="/profileedit" class="btn btn-success" style="margin-bottom: 20px;">Изменить данные аккаунта</a><br>
							<?php 
							if(empty(Yii::$app->user->identity->first_name) || empty(Yii::$app->user->identity->last_name)) {
								print '<div class="alert alert-danger"><p><b>Укажите ваши Фамилию и Имя</b></p>
									<p>Сделать это можно по <a href="/profileedit">ссылке</a>, либо через меню редактирования профиля </p></div>';
							}
							?>
							
							<?php if($varInView['name'] == 'Администратор')  { ?>
								<a href="https://excel.profinavigator.ru/?hash=$ba357a9e61c4e25d942dd5f4bd2716a7$" class="btn btn-warning">Статистика</a>
							<?php } ?>
							<?php if($varInView['name'] == 'Педагог' || $varInView['name'] == 'Педагог координатор')  { ?>
							
							<?php 
								$school = Yii::$app->user->identity->school;
								if(!empty($school) || $school != 0) {
									?>
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
			  								$newArrayStudent = array_filter($getStudentsInProfile);
			  								
			  								foreach ($newArrayStudent as $student) {
			  									if(!empty($student['id'])){
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
											}
											?>
			  							</tbody>
										</table>
								<?php	
								} 
								else {
									print '<div class="alert alert-danger"><p><b>Укажите школу, в которой вы работаете</b></p>
									<p>Сделать это можно по <a href="/profileedit">ссылке</a>, либо через меню редактирования профиля </p></div>';
								}
							?>

							<?php } else { ?>

							
							<?php 
								$school = Yii::$app->user->identity->school;
								if(!empty($school) || $school != 0) {
									print '<h3>Место обучения: <h3><ul style="padding:0px;"><li style="list-style:none;"><a class="my-company-list" href="/sinceview?id='.$getSchoolUserMainPage['id'].'">'.$getSchoolUserMainPage['name'].'</a></li></ul>';
								} 
								else {
									print '<div class="alert alert-danger"><p><b>Укажите организацию, в которой вы учитесь</b></p>
									<p>Сделать это можно по <a href="/profileedit">ссылке</a>, либо через меню редактирования профиля </p></div>';
								}
							?>
						    <?php
						    if(empty($arrayUserCompany)) {

						    }
						    else {
						    	print '<h3>Мои компании</h3>
								<div class="col-lg-12"><a href="#" class="spoiler-trigger"><span>Развернуть</span></a>
								<div class="spoiler-block" style="margin-top:31px;">
						    	<ul style="padding:0px;">';
						    	$user_id = Yii::$app->user->identity->id;

						    	foreach ($arrayUserCompany as $keyMyCompany) {
						    		if($keyMyCompany['type_id'] != 4) {

						    			print '<li style="list-style: none;">
						    				<a class="my-company-list" href="/sinceview?id='.$keyMyCompany['id'].'">'.$keyMyCompany['name'].'</a>
											<a href=/mycompany?id='.$keyMyCompany['id'].' class="btn btn-info">Редактировать</a>
											<a href=/liststudens?id='.$keyMyCompany['id'].' class="btn btn-primary">Ученики</a>
						    			</li><br>';

						    		}
						    		else {
						    			print '<li style="list-style: none;">
						    			<a class="my-company-list"  href="/jobview?id='.$keyMyCompany['id'].'">'.$keyMyCompany['name'].'</a>
										<a href=/mycompany?id='.$keyMyCompany['id'].' class="btn btn-info">Редактировать</a>
						    			</li><br>';
						    		}
						    		
						    	}
						    	echo "</ul></div></div>";
						    }
						    ?>
						    
							
							<?php if(!empty($getCompetenct)) { ?>
							<h3 style="display:inline-block;">Мои компетенции</h3>
							<p style="display:inline-block;">В этом я хорош!</p>
							<div class="horizontal-scroll">
								<ul>
									<?php
									foreach ($getCompetenct as $keyComp) {
										print '<li><span>'.$keyComp['name'].'</span></li>';
									}
									?>
								</ul>
							</div>
							 <?php } ?>

							 <?php if(!empty(Yii::$app->user->identity->about)) { ?>
							<h3>Обо мне</h3>
							<div class="horizontal-scroll">
								<?=Yii::$app->user->identity->about?>
							</div>
						     <?php } ?>

						    <?php if(!empty($varInViewProfessionUser)) { ?>
							<h3>Избранные профессии</h3>
							<div class="horizontal-scroll">

							<?php 
							print '<div class="multiple-items">';
							$len_obr = count($varInViewProfessionUser);
								foreach ($varInViewProfessionUser as $profesions_vyzs) { 
									 
									print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
									<a href="/viewprof?id='.$profesions_vyzs['id_profession'].'">
									<img src="'.$profesions_vyzs['img'].'" alt="" width="270" height="180">
									<h4>'.$profesions_vyzs['name'].'</h4></a>
									</div>';
								}
							print '</div>';

							?>
							<div class="action">
							 	<?php

									print '  <input id="action_one_range" type="range" min="1" max="'.$len_obr.'"  value="0" step="1">';
								
							 	?>
							
							  </div>
							</div>

							 <?php } ?>
						   
						   <?php if(!empty($varInViewOrgUser)) { ?>
						    <h3>Избранные организации</h3>
							<div class="horizontal-scroll">
							
							<?php 

							print '<div class="multiple-items-two">';
							$len_obr_two = count($varInViewOrgUser);
								foreach ($varInViewOrgUser as $keyFavoriteOrg) { 

									if(keyFavoriteOrg['id_type'] != 4) {


										print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
										<a href="/sinceview?id='.$keyFavoriteOrg['organisation_id'].'">
										<img src="'.$keyFavoriteOrg['img'].'" alt="" width="270" height="180">
										<h4>'.$keyFavoriteOrg['name'].'</h4></a>
										</div>';
									}
									else {
										print '<div class="favourites" id="bg" style="width: 300px;height: 250px;">
										<a href="/jobview?id='.$keyFavoriteOrg['organisation_id'].'">
										<img src="'.$keyFavoriteOrg['img'].'" alt="" width="270" height="180">
										<h4>'.$keyFavoriteOrg['name'].'</h4></a>
										</div>';							
									}
								}
							print '</div>';

							?>
							<div class="action">
							 	<?php

									print '  <input id="action_one_range-two" type="range" min="1" max="'.$len_obr_two.'"  value="0" step="1">';
								
							 	?>
							
							  </div>
							</div>
							 <?php } }?>
						  </div>

						  <div id="panel2" class="tab-pane fade">
						    <h3>Портфолио</h3>
						    <span class="btn btn-primary" data-toggle="modal" data-target="#myModal">Добавить свой сертификат</span><br>
						    <?php if(!empty($getUserSertCustom)) { print '<h3>Сертификаты Пользователя:</h3>'; } ?>
							<div class="portfolio_flex">
							<?php
								foreach ($getUserSertCustom as $getUserSertCustom) {
						    		print '
									<div class="portfolio">
									
									
										<object data="'.$getUserSertCustom['link'].'" width="100%" height="auto"></object>
							    		<h4>'.$getUserSertCustom['title'].'</h4>
							    		<a style = "width: 46px;" href="/'.$getUserSertCustom['link'].'" target="_blank" class="btn btn-info">&#128270;</a>
							    		<a style = "width: 46px;" href="/'.$getUserSertCustom['link'].'" class="btn btn-info" download>&#128190;</a>
							    		<span style = "width: 46px;" id="'.$getUserSertCustom['id'].'" class="delSert btn btn-danger">&#9249;</span>
									</div>
						    		';
						    	} 
						    ?>
							</div>
						    <?php if(!empty($getSert)) { print '<h3>Сертификаты НАВИГАТОР:</h3>'; } ?>
							<div class="portfolio_flex">
						    <?php
						    	foreach ($getSert as $sert) {
						    		print '
									<div class="portfolio">
									
									<a href="/testview?id='.$sert['id_test'].'" style="margin-top: 15px;display:block;">
										<object data="'.$sert['link_certificate'].'" width="100%" height="150"></object>
							    		<h4>'.$sert['title'].'</h4>
							    	</a>
									</div>
						    		';
						    	}
						    ?>
							</div>
						  </div>
						  <div id="panel3" class="tab-pane fade">
						    <h3>Оповещения</h3>
							<style>
								#badge_time {
									color: white;
									display: block;
									font-size: 9pt;
									padding: 5px !important;
									margin-top: 10px;
								}
							</style>
							<div class="event_notification_flex">
						    <?php
						    	#print_r($getNoti);
						    	foreach ($getNoti as $noti) {
						    		$data1 = strtotime($noti['event_time']);
						    		$data2 = strtotime(date('Y/m/d h:i:s a', time()));
						    		$result = $data1 > $data2;
						    		$status = '';

						    		if($result === false) {
						    			$time = "Событие уже закончилось";
						    		}
						    		else {
						    			$time = "Событие скоро начнется".
						    			"<p class='label label-info' id='badge_time'>".downcounter($noti['event_time'])."</p>";
						    			
						    		}

						    		if($result == true) {
							    		if ((int)$noti['is_reed'] != 0 ) {
							    			$status = '<span class="yes_reed label label-success">Прочитано</span>';	
							    		}
							    		else {
							    			$status = '<span class="no_reed label label-danger">Не прочитано</span>';	
							    		}
							    	}

						    		print '
									<div class="event_notification">
										<div id="status_noti">'.$status.'</div>
									<a href="/eventview?id='.$noti['id_event'].'" style="margin-top: 15px;display:block;">
										<img src="'.$noti['picture'].'" width="40" height="40" alt="">
										
							    		<h4>'.$noti['title'].'</h4>
							    		<p>'.$time.'</p>
							    		
							    	</a>
									</div>
						    		';
						    	}
						    ?>
							</div>
						  </div>
						  <div id="panel4" class="tab-pane fade">
						    <h3>Мероприятия</h3>
						   <?php
						   	
						    foreach ($varArrayUserEvent as $keyUserEvent) {
						    	print '
								<div class="row my-event">
									<div class="col-lg-3">
								    	<a href="/eventview?id='.$keyUserEvent['id_event'].'">
											<img src="'.$keyUserEvent['picture'].'" alt="" class="img-thumbnail" width="320">
										</a>
									</div>
									<div class="col-lg-9">
										<a href="/eventview?id='.$keyUserEvent['id_event'].'">
								    		<h4>'.$keyUserEvent['title'].'</h4>
								    	</a>
								    	<span class="alert-info">'.$keyUserEvent['event_time'].'</span>
								    	<p>'.substr($keyUserEvent['description'],0, 255).'...</p>	
								    </div>								
								</div>
						    	';
						    }
						   ?>
						  </div>
						  <div id="panel5" class="tab-pane fade">
						    <h3>Достижения</h3>
							<div class="list-achiv-flex">
							<?php 
							foreach($getAllAchivUser as $keyAchiv) {
							 	print '
							    	<div class="list-achiv">
							    		<img src="'.$keyAchiv['img'].'" width="40" height="40" alt="">
							    		<h4>'.$keyAchiv['name'].'</h4>
							    		<p>'.$keyAchiv['description'].'</p>
									</div>
							    ';
							}
						    ?>
							</div>
						  </div>
						</div>
				</div>
			</div>

		<?php } ?>

	</div>
</div>
<?php } ?>

<?php
$script = <<< JS
$(window).resize(function() {
	if($(window).width() <= 975) {
		 $('.prof_review').removeAttr("style");
	}
	else {
		//alert('123');
	}
});

var no_reed = $(".no_reed").length;

if(no_reed === 0) {

}
else {
	$('.lipanel3').append('<span class="label label-info notification" id="count_noreed">'+no_reed+'</span>');
}



$('.event_notification').hover(function(e){
	
	var href =  $('a', $(this)).attr('href');
	
	var id_event = href.split('=')[1];
	var is_reed = 1;

	var reed = $('.no_reed', $(this)).length;

	if(reed == 0) {

	}

	else {
		$.ajax({
	       url: '/isreednoti',
	       type: 'POST',
	       context:this,
	       data: {'idEventNoti': id_event, 'is_reed': is_reed},
	       success: function(res){
	       		
	       		$('.no_reed', $(this)).remove();
	       		$('#status_noti', $(this)).append($('<span class="yes_reed label label-success">Прочитано</span>'));

	       		var count_reed = $('#count_noreed').text();

	       		if(count_reed > 1) {
					var sum = count_reed - 1;
					$('#count_noreed').text(sum);
	       		} 
	       		else {
					$('#count_noreed').remove();
	       		}

	       },
	       error: function(){
	            alert('Error!');
	       }
	    });
	}

}, function(){
    //This function is for unhover.
}); 


$('.uploadCertificate').on('click', function(e) {
	var file_data = $('#filePortfolio').prop('files')[0];
	var title = $('#titleFilePortfolio').val();

    	if(file_data != undefined) {
			var form_data = new FormData();  

			form_data.append('titleFilePortfolio', title);
            form_data.append('filePortfolio', file_data);

		    $.ajax({
		       url: '/uploadnewsertportfolio',
		       type: 'POST',
			   contentType: false,
		       processData: false,
		       data: form_data,
		       success: function(res){
		       		if(confirm(res)){
			    		window.location.reload();  
					}
		       		
		       },
		       error: function(){
		            alert('Error!');
		       }
		    });
		 }
    return false;
});

$('.delSert').on('click', function(e) {

	var idDelCertificate = $('.delSert').attr('id');

	var form_data = new FormData();  
	form_data.append('idCertDelUser', idDelCertificate);
	
		$.ajax({
		       url: '/delcertuser',
		       type: 'POST',
			   contentType: false,
		       processData: false,
		       data: form_data,
		       success: function(res){
		       		if(confirm(res)){
			    		window.location.reload();  
					}
		       		
		       },
		       error: function(){
		            alert('Error!');
		       }
		});
});

JS;
$this->registerJs($script);
?>

<style>
	.spoiler-trigger{
	color: #0b70db;
	text-decoration: none;
	padding-left: 15px;
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAANUlEQVQoU2PkLrj9n4EAYAQp+jpBlRGXOpA8hiJ0TaQrwuY2kDNINwnmcKLchO5LuHWEwgkAlO5FBwhFaI8AAAAASUVORK5CYII=) no-repeat 0 50%;
}
.spoiler-trigger.active{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAKklEQVQoU2PkLrj9n4EAYAQp+jpBlRGXOpA8DRRhcxvIGTSyjqDvCIUTAEcINQcERZkIAAAAAElFTkSuQmCC);
}
.spoiler-trigger>span{
	border-bottom: 1px dashed #0b70db;
	padding:0 3px;
}
.spoiler-trigger:hover>span{
	border-bottom-style: solid;
}
.spoiler-block{
	display: none;
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" type="text/javascript" ></script>

<script>
	$(document).on('click','.spoiler-trigger',function(e){e.preventDefault();$(this).toggleClass('active');$(this).parent().find('.spoiler-block').first().slideToggle(300);})

    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
