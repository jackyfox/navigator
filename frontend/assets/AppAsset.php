<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // 'css/site.css',
        'css/main.css', // ГЛАВНЫЙ css
        'css/slider.css', // CSS для слайдера профессий и работадателей
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.css', //Шрифт FONTAWESOME
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css', // SLICK SLIDER CSS
        'https://code.getmdl.io/1.3.0/material.indigo-pink.min.css', //Material Design
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css',
        'https://translate.googleapis.com/translate_static/css/translateelement.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css'
        
    ];
    public $js = [

    	'https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js', //Скрипт для Маски input 
    	'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js', // SLICK SLIDER JS
    	'https://api-maps.yandex.ru/2.1/?apikey=7dfcdbae-248b-45f0-a9b0-be9ea41528e6&lang=ru_RU', // карта 
    	'https://code.getmdl.io/1.3.0/material.min.js',//Material Design
    	'//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js',
    	'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js',
    	'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', //POPER JS
    	'https://cloud.tinymce.com/5/tinymce.min.js?apiKey=9o25zsmnfe3heiuub4lebwck803zgpb2pwdeys40e3hlfbhv', // textarea tinymce
    	'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', // for google language 
    	'js/loadmore.js', // Скрипт для кнопки показать еще
    	'js/main.js', //Общий файл js  frontend/web/js/
        'js/tp.js', //скрипты тестов
        'js/testUser.js', //скрипты user тестов
        'js/google-translate.js', //google translate js
        '//translate.google.com/translate_a/element.js?cb=TranslateInit',
        'https://translate.googleapis.com/translate_static/js/element/main_ru.js',
        'https://translate.googleapis.com/element/TE_20190724_00/e/js/element/element_main.js', // for google translate
        'https://pagination.js.org/dist/2.1.4/pagination.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js',
		//https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js'
        

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
