<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker ;
use yii\grid\GridView;

$this->title = 'Моя компания';
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->request->bodyParams = [];
?>
<?php Pjax::begin(); ?>
<?php  if (Yii::$app->user->isGuest) { echo "Доступ запрещен!"; } else { ?>

						<!--START TEST MODAL-->
						<div class="modal fade" id="testungModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
						    <div class="modal-dialog" role="document">
							    <div class="modal-content">
							        <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								        <h4 class="modal-title" id="ModalLabel">Создание теста</h4>
							        </div>
								    <div class="modal-body">
								        <form id="test-form" enctype="multipart/form-data">
								            <div class="form-group">
								                <label for="test-name" class="col-form-label">Название теста</label>
								                <input type="text" class="form-control" id="test-name" name ="test-name">
								            </div>

								            <div class="form-group">
								                <label for="test-description" class="col-form-label">Описание теста</label>
								                <textarea type="text" class="form-control" id="test-description" name ="test-description"></textarea>
								            </div>

								            <div class="form-group">
								                <label for="test-description" class="col-form-label">Время на тест</label>
												<input type="text" class="form-control" id="test-time" name ="test-time">
								            </div>


								            <div class="form-group">
								                <label for="test-description" class="col-form-label">Главная картинка теста</label>
								                 <input type="file" class="form-control" id="test-bgtest" name ="test-bgtest">
								            </div>

								            <div class="form-group">
								                <label for="test-rating" class="col-form-label">Максимальное количество ед. опыта</label>
								                <input type="number" step="1" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" id="test-rating" name ="test-rating">
								            </div>
								            <div class="form-group">
								                <label for="test-starting" class="col-form-label">Дата начала</label>
								                <input type="data" class="form-control" id="test-starting" name ="test-starting">
								            </div>
								            <div class="form-group">
								                <label for="test-end" class="col-form-label">Дата окончания</label>
								                <input type="data" class="form-control" id="test-end" name ="test-end">
								            </div>
								            <!--PASTING BLOCK-->
									        <div id="question-group">
									        	
									        </div>
									        <!--END PASTING BLOCK-->
									        <div id="button-group">
									        	<p>Добавление вопроса теста</p>
									        	<p>Выберите тип вопроса:</p>
									          	<button type="button" class="btn btn-info" id="checkbox-group">Checkbox groop</button>
									            <button type="button" class="btn btn-info" id="radio-group">Radio groop</button>
									        </div>
											<p style="font-size: 12px;color:#4FACFE;margin-left: 0px;margin-top: 5px;">*Checkbox - с выбором нескольких ответов</p>
											<p style="font-size: 12px;color:#4FACFE;margin-left: 0px;margin-top: -12px;">*Radio - с выбором единственного ответа</p>
								        </form>
								    </div>
								    <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
								    </div>
							    </div>
						    </div>
						    <style>
						    	.form-check input[type="checkbox"] {
									display: inline-block !important;
								}
						    </style>
						</div>
						<!--END TEST MODAL-->


<!-- Modal event-->
<div class="modal fade" id="myModalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Добавление мероприятия</h4>
      </div>
      <div class="modal-body">
       <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<?= $form->field($model, 'idCompanyForEvent')->hiddenInput(['value' => (int)$_GET['id']])->label(''); ?>
			
			<?= $form->field($model, 'nameEvent')->textInput()->label('Название события',['class'=>'label label-primary']); ?>
			<?= $form->field($model, 'imageFileEvent')->fileInput()->label('Превью',['class'=>'label label-primary']); ?>
			<div id="preview-event-main" style="overflow: hidden;">
										
			</div>
			<?= $form->field($model, 'event_time')->label('Дата мероприятия',['class'=>'label label-primary'])->widget(DateTimePicker::classname(), [
			    'options' => ['placeholder' => 'Введите дату и время в формате Y-m-d H:m:s'],
			    'pluginOptions' => [
			        'autoclose' => true
			    ]
			]); ?>	
			<?= $form->field($model, 'aboutEvent')->textarea(['rows' => '6','value' => ''])->label('О мероприятии',['class'=>'label label-primary']); ?>  
			<?= $form->field($model, 'addrEvent')->dropDownList(\yii\helpers\ArrayHelper::map($arrayAddr, 'id', 'st_addr'))->label('Адрес',['class'=>'label label-primary']); ?>

			<?= $form->field($model, 'sliderEvent[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Слайдер',['class'=>'label label-primary']); ?>
			<div class="row">
				<p style="font-size: 9pt;color:#4FACFE;margin-left: 0px;margin-top: -12px;">*Выберете от 2 до 10  картинок для загрузки</p>
			</div> 	
			<h4>Добавленные изображения</h4>
			<div id="preview-event" style="overflow: hidden;"></div>	
			<div style="text-align:right;">
				<button class="btn btn-info" id="go">Сохранить</button>
			</div>
	   <?php ActiveForm::end() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal blog-->
<div class="modal fade" id="myModalBlog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Добавление блога</h4>
      </div>
      <div class="modal-body">
       <form id="blog-form" enctype="multipart/form-data" style="text-align: left !important;">
			<div class="form-group">
			    <label for="blog-name" class="col-form-label">Название новости</label>
			    <input type="text" class="form-control" id="blog-name" name ="titleBlog" style="width:100%;">
			</div>
			<div class="form-group">
			    <label for="blog-description" class="col-form-label">Описание новости</label>
			    <textarea type="text" class="form-control" id="blog-description" name ="textBlog"></textarea>
			</div>								        
			<div class="form-group">
			    <label for="blog-img" class="col-form-label">Картинка новости</label>
			     <input type="file" class="form-control" id="blog-img" name ="bgblog" style="width:100%;">
			</div>
			
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button class="btn btn-info" id="goNewBlog">Сохранить</button>
      </div>
    </div>
  </div>
</div>



<div class="site-about">
    <h1 style="display: none;"><?= Html::encode($this->title) ?></h1>
	<div class="container" style="overflow: hidden;width: 100%;">
		<?php if(isset($_GET['id'])) { if(empty($arrayCompanyInfo)) { echo "Компания не найденна!"; } else { ?>

			<div class="row header_page_img" id="profile" style="background: url('<?=$arrayCompanyInfo['img']?>'); background-attachment: fixed;background-size: cover;box-shadow: inset 0px 0px 400px black;">
				
				<div class="col-lg-8" style="color: white;">
					<h3 class="user_name" ><b><?= $arrayCompanyInfo['org_name'] ?> <?= $varInView[0]['last_name']; ?></b></h3>
					<p class="type_user"><i><?= $arrayCompanyInfo['type_name']; ?></i></p>
				</div>
				<div class="col-lg-3">
					<div class="progress blue" style="background-image: none;">
		               <img src="<?= $arrayCompanyInfo['logo']; ?>"  width="160" align="left">	
		            </div>
				</div>

			</div>

			<div class="row">
				<div class="col-lg-3">
					<ul class="menu_profile">
						<!-- ################################### !-->
						<!-- пункты меню табов  !-->
						<!-- ################################### !-->
						<li class="active"><a data-toggle="tab" href="#panel1"><i class="fas fa-user"></i>О компании</a></li>
						<!--<li><a data-toggle="tab" href="#panel2"><i class="fas fa-briefcase"></i> Портфолио</a></li> !-->
						<li><a data-toggle="tab" href="#panel3"><i class="fa fa-tasks"></i> Тесты</a></li>
						<li><a data-toggle="tab" href="#panel4"><i class="far fa-calendar-check"></i> Мероприятия</a></li>
						<li><a data-toggle="tab" href="#panel5"><i class="far fa-lightbulb"></i> Блоги</a></li>
						<!--<li><a data-toggle="tab" href="#panel5"><i class="far fa-lightbulb"></i> Достижения</a></li>!-->
					</ul>
				</div>
				<!-- ################################### !-->
				<!-- табы   !-->
				<!-- ################################### !-->
				<div class="col-lg-9" class="right_tabs_profile">
						<div class="tab-content">
						  <div id="panel1" class="tab-pane fade in active">
						  
							<h3 style="display:inline-block;">Основная информация</h3>
							<p style="display:inline-block;">о нас!</p>
							<div class="horizontal-scroll">
								
								<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

								<?= $form->field($model, 'idCompany')->hiddenInput(['value' => (int)$_GET['id']])->label(''); ?>
								<?= $form->field($model, 'imageFiles')->fileInput()->label('Логотип компании:',['class'=>'label label-primary']); ?>
								<?= $form->field($model, 'bgCompany')->fileInput()->label('Баннер компании:',['class'=>'label label-primary']); ?>

								<?= $form->field($model, 'nameCompany')->textInput(['value' => $arrayCompanyInfo['org_name']])->label('Название компании:',['class'=>'label label-primary']); ?>
								<?= $form->field($model, 'videoCompany')->textInput(['value' => $arrayCompanyInfo['video']])->label('Ссылка на видео:',['class'=>'label label-primary']); ?>
								<?= $form->field($model, 'aboutCompany')->textarea(['rows' => '6','value' => $arrayCompanyInfo['description']])->label('О компании:',['class'=>'label label-primary']); ?>
								

								<?= $form->field($model, 'slider[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Слайдер:',['class'=>'label label-primary','id'=>'sliderImage']); ?>
								<div class="row add-slider">
									
									<p style="font-size: 9pt;color:#4FACFE;margin-left: -20px;margin-top: -12px;">*Выберете от 2 - 10 картинок для загрузки</p>
									<h4 style="font-size: 18px; margin: 0;">Новые изображения для загрузки:</h4>
									<div id="preview">
										
									</div>

								</div>
								<br>
								<hr class="add-slider">
								<div class="row add-slider">
									<h4 style="font-size: 18px; margin: 5px 0;">Текущие изображения в слайдере:</h4>
									<?php
										foreach ($arraySliderImg as $sliderImg) {
											print '
												<div class="col-lg-4" id="img_slide_'.$sliderImg['id'].'">
													<a data-fancybox="gallery" href="'.$sliderImg['img_org'].'"><img src="'.$sliderImg['img_org'].'"  width="150" class="img-responsive img-thumbnail" alt=""></a>
													<p id_company="'.$_GET['id'].'" class="trash_img" src="'.$sliderImg['img_org'].'" id="'.$sliderImg['id'].'"><i id="trash" class="glyphicon glyphicon-trash"></i></p>
												</div>
											';
										}
									?>

								</div>

								<ul id="slide">
									
								</ul>

								<div style="text-align:right;"><button class="btn btn-info" id="go">Сохранить</button></div>

								<?php ActiveForm::end() ?>
							</div>

						  </div>
						  <div id="panel2" class="tab-pane fade">
						    <h3>Портфолио</h3>
						    <p>Раздел в разработке</p>
						  </div>
						<div id="panel5" class="tab-pane fade">
							<h3>Блоги</h3>
						  	<span class="btn btn-primary" data-toggle="modal" data-target="#myModalBlog">Добавить новый блог</span>

<?php if(empty($blogCompany)) { echo "ни чего не найдено"; } else { ?>
							    <?= GridView::widget([
        'dataProvider' => $blogCompany,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'blogID',
            'titleBlog',
            //'description:ntext',
            'description',
         
            ['class' => 'yii\grid\ActionColumn',
             'buttons' => [
	            'view' => function ($url,$data) {
	                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
	                            'title' => Yii::t('app', 'lead-view'),
	                ]);
	            },

	            'update' => function ($data) {
	                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $data, [
	                            'title' => Yii::t('app', 'lead-update'),
	                ]);
	            },
	            'delete' => function ($data) {
	               # return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
	                #            'title' => Yii::t('app', 'lead-delete'),
	                 #           'id_event' => $data,
	                  #          'id' => 'id_event',
	                   #         'id_company' => $_GET['id']
	                #]);
	                return '<a style="cursor: pointer;" class="id_blog_del" id_blog='.$data.' id_company="'.$_GET['id'].'"> <span class="glyphicon glyphicon-trash"></span> </a>';

	            }

	          ],
	        'urlCreator' => function ($action, $data, $key, $index) {
	            if ($action === 'view') {
	                $url ='blogview?id='.$data['blogID'];
	                return $url;
	            }

	            if ($action === 'update') {
	                $url ='editmyblog?OrgID='.$_GET['id'].'&idBlog='.$data['blogID'];
	                return $url;
	            }
	            if ($action === 'delete') {
	                #$url ='myeventdelit?id='.$data['id'];
	                $url = $data['blogID'];
	                return $url;
	            }
          	}
          

          ],
        	
        ],
    ]); } 

    ?>




						</div>
						<div id="panel3" class="tab-pane fade">
						    <h3>Тесты</h3>
						   	 
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testungModal">Создать тестирование</button>
						

<?php if(empty($testsCompany)) {} else { ?>
							    <?= GridView::widget([
        'dataProvider' => $testsCompany,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'description:ntext',
            'data_start',
            'data_end',
         
            ['class' => 'yii\grid\ActionColumn',
             'buttons' => [
	            'view' => function ($url,$data) {
	                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
	                            'title' => Yii::t('app', 'lead-view'),
	                ]);
	            },

	            'update' => function ($data) {
	                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $data, [
	                            'title' => Yii::t('app', 'lead-update'),
	                ]);
	            },
	            'delete' => function ($data) {
	               # return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
	                #            'title' => Yii::t('app', 'lead-delete'),
	                 #           'id_event' => $data,
	                  #          'id' => 'id_event',
	                   #         'id_company' => $_GET['id']
	                #]);
	                return '<a style="cursor: pointer;" class="id_test_del" id_test='.$data.' id_company='.$_GET['id'].'> <span class="glyphicon glyphicon-trash"></span> </a>';

	            }

	          ],
	        'urlCreator' => function ($action, $data, $key, $index) {
	            if ($action === 'view') {
	                $url ='testview?id='.$data['id'];
	                return $url;
	            }

	            if ($action === 'update') {
	                $url ='testedit?OrgID='.$_GET['id'].'&idTest='.$data['id'];
	                return $url;
	            }
	            if ($action === 'delete') {
	                #$url ='myeventdelit?id='.$data['id'];
	                $url = $data['id'];
	                return $url;
	            }
          	}
          

          ],
        	
        ],
    ]); } 

    ?>

						


						  </div>

						  <div id="panel4" class="tab-pane fade">
						    <h3>Мероприятия</h3>
						    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalEvent">Добавить мероприятие</a>
<?php if(empty($arrayEventCompany)) {} else { ?>
							    <?= GridView::widget([
        'dataProvider' => $arrayEventCompany,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'description:ntext',
            'event_time',
         
            ['class' => 'yii\grid\ActionColumn',
             'buttons' => [
	            'view' => function ($url,$data) {
	                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
	                            'title' => Yii::t('app', 'lead-view'),
	                ]);
	            },

	            'update' => function ($data) {
	                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $data, [
	                            'title' => Yii::t('app', 'lead-update'),
	                ]);
	            },
	            'delete' => function ($data) {
	               # return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
	                #            'title' => Yii::t('app', 'lead-delete'),
	                 #           'id_event' => $data,
	                  #          'id' => 'id_event',
	                   #         'id_company' => $_GET['id']
	                #]);
	                return '<a style="cursor: pointer;" class="id_event" id_event='.$data.' id_company='.$_GET['id'].'> <span class="glyphicon glyphicon-trash"></span> </a>';

	            }

	          ],
	        'urlCreator' => function ($action, $data, $key, $index) {
	            if ($action === 'view') {
	                $url ='eventview?id='.$data['id'];
	                return $url;
	            }

	            if ($action === 'update') {
	                $url ='editmyevent?OrgID='.$_GET['id'].'&idEvent='.$data['id'];
	                return $url;
	            }
	            if ($action === 'delete') {
	                #$url ='myeventdelit?id='.$data['id'];
	                $url = $data['id'];
	                return $url;
	            }
          	}
          

          ],
        	
        ],
    ]); } 

    ?>
						  </div>
						  <div id="panel5" class="tab-pane fade">
						    <h3>Достижения</h3>
						    <p>Раздел в разработке</p>
		
						  </div>

						</div>
				</div>
			</div>

	</div>
</div>
<?php } } }?>

<style>
	.form-control {
		width: 100%;
	}
	.label {
		display: block;
		width: auto;
		overflow: hidden;
		position: relative;
		font-size: 12pt;
		padding: 5px;
	}
	#trash {
		float: right;
		cursor: pointer;
		margin-top: -50px;
		color: #339bd1;
	}
	#trash:hover {
		color: blue;
	}
</style>

<?php Pjax::end(); ?>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview').empty();
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<div class="col-lg-3"><a data-fancybox="gallery-new" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('mycompany-slider').addEventListener('change', handleFileSelect, false);
});

</script>


<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-event').empty();
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<div class="col-lg-3"><a data-fancybox="gallery-new-event" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-event').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('mycompany-sliderevent').addEventListener('change', handleFileSelect, false);
});

</script>


<script type="text/javascript">
jQuery(document).ready(function($) {
 function handleFileSelect(evt) {
 	$('#preview-event-main').empty();
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<div class="col-lg-3"><a data-fancybox="gallery-new-event-main" href="',e.target.result,'"><img class="img-responsive img-thumbnail" width="150" src="', e.target.result,
                            '" title="', theFile.name, '"/></a></div>'].join('');
          document.getElementById('preview-event-main').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('mycompany-imagefileevent').addEventListener('change', handleFileSelect, false);
});


</script>






<script>

$('.trash_img').on('click', function(e) {
	var id_img = $(this).attr('id');
	var src_img = $(this).attr('src');
	var id_company = $(this).attr('id_company');
	console.log(id_company);
    $.ajax({
       url: '/delitslideimgcomp',
       type: 'POST',
       data: {id_img: id_img, src_img: src_img, id_company:id_company},
       success: function(res){
       		console.log(res);
			$('#img_slide_'+id_img).remove();
       },
       error: function(res){
       	console.log(res);
            alert('Error!');
       }
    });
});

$('.id_event').on('click', function(e) {

	var id_event = $(this).attr('id_event');
	var id_company = $(this).attr('id_company');

	console.log(id_event);

    $.ajax({
       url: '/deliteventcompany',
       type: 'POST',
       data: {id_event: id_event, id_company: id_company},
       success: function(res){
       		console.log(res);
			alert('Событие успешно удаленно');
			//location.reload();

       },
       error: function(res){
       	console.log(res);
            alert('Error!');
       }
    });
});


$('.id_test_del').on('click', function(e) {
	var id_test = $(this).attr('id_test');
	var id_company = $(this).attr('id_company');

     $.ajax({
       url: '/delittest',
       type: 'POST',
       data: {'idTest': id_test, 'id_company': id_company},
       success: function(res){
       		console.log(res);
			//location.reload();
			if(confirm(res)) {
				window.location.reload();  
			}

       },
       error: function(res){
       		console.log(res);
            alert(res);
       }
    });
});


$('.id_blog_del').on('click', function(e) {
	var id_blog = $(this).attr('id_blog');
	var id_company = $(this).attr('id_company');

     $.ajax({
       url: '/delblog',
       type: 'POST',
       data: {'idBlog': id_blog, 'id_company': id_company},
       success: function(res){
       		console.log(res);
			//location.reload();
			if(confirm(res)) {
				window.location.reload();  
			}

       },
       error: function(res){
       		console.log(res);
            //alert(res);
       }
    });
});

$(".modal-footer").on("click", "button#goNewBlog", function(){

	tinyMCE.triggerSave();

	var form_dataBlog = new FormData(); 
	var id = getUrlVars()["id"];
	var id = id.split( '#panel5' )[0];
	var id = id.split( '#panel1' )[0];
	var id = id.split( '#panel2' )[0];
	var id = id.split( '#panel3' )[0];
	var id = id.split( '#panel4' )[0];

	let title = document.getElementById('blog-name').value;
	let idCompany = id;
	let file = document.getElementById("blog-img");
	if (file.files.length > 0) {
    	form_dataBlog.append("bgblog", file.files[0]);
	}
	let description =  document.getElementById('blog-description').value;
	
	console.log(title);
	console.log(idCompany);
	console.log(file);
	console.log(description);

	form_dataBlog.append('idcompany', id);
	form_dataBlog.append('titleBlog', title);
	form_dataBlog.append('textBlog', description);
	form_dataBlog.append('bgblog', file);
	
	 $.ajax({
       url: '/newblog',
       type: 'POST',
       cache: false,
       contentType: false,
       processData: false,
       data: form_dataBlog,
       success: function(res){
       		console.log(res);
       		console.log(form_dataBlog);
			//location.reload();
			if(confirm(res)){
			    window.location.reload();  
			}

       },
       error: function(res){
       	console.log(res);
            alert('Error!: '+res);
       }
    });
});


</script>


