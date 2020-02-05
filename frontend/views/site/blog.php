<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Блоги';
$this->params['breadcrumbs'][] = $this->title;
?>

	<div class="container" style="background: #FCFCFC;">
		<div class="row top_page">
			<h2><?= Html::encode($this->title) ?></h2>
			<p>Самые свежие новости</p>
		</div>
		

		<!--<div class="row filter_horizon">
			<div class="col-lg-12">
				<form class="filter_form_prof" id="filter_form_prof">
					<input type="text" id="search_prof_input" name="search_text" class="form-control" placeholder="Поиск по фильтрам">
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>

		</div>!-->
		<div class="row">
			<div id="result_search" style="display: block;text-align: center;overflow: hidden;margin: 0 auto;">

			</div>
		</div>
		<div class="blogMain row" id="static_content">
			<?php
			foreach ($varArrayBlog as $varArrayBlog) {
				print '
				<div class="blogStatya col-lg-5">
					<div class="imgMain">
					<img src="'.$varArrayBlog['imgBlog'].'" class="mainImgBlog img" alt="">
					</div>
					<div class="label label-info" style="padding:7px;position: absolute;margin-top: -26.5px;border-radius: 0px;background: #ffff;color: black;"><img src="'.$varArrayBlog['logoOrg'].'" width="30"/> '.$varArrayBlog['orgName'].'</div>
					<h3>'.$varArrayBlog['titleBlog'].'</h3>
					<p>Дата публикации: '.$varArrayBlog['blogData'].'</p>
					<p>'.mb_substr($varArrayBlog['description'],0, 255,'UTF-8').'...</p>
					<a href="/blogview?id='.$varArrayBlog['blogID'].'" class="btn btn-info">Узнать больше</a>
				</div>
			

				';
			}
			?>

			
		</div>
	</div>


