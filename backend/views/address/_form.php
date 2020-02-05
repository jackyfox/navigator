<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-form">
	<script src="https://api-maps.yandex.ru/2.1/?apikey=7dfcdbae-248b-45f0-a9b0-be9ea41528e6&lang=ru_RU" type="text/javascript"></script>

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'st_addr')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'coords')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
	ymaps.ready(init);

		function init() {
		    // Создаем выпадающую панель с поисковыми подсказками и прикрепляем ее к HTML-элементу по его id.
		    var suggestView1 = new ymaps.SuggestView('address-st_addr');


		    $('#address-st_addr').keyup(function() {
				var street = $('#address-st_addr').val();
				//console.log(street);
				
		 	var geocoder = ymaps.geocode(street);
		 
		    // После того, как поиск вернул результат, вызывается callback-функция
		    geocoder.then(
		        function (res) {
		 			
		            // координаты объекта
		            var coordinates = res.geoObjects.get(0).geometry.getCoordinates();
		            //console.log(coordinates);  
		            $('#address-coords').val('['+coordinates+']');      
		        }
		    );

			});

			
		}

	</script>

</div>
