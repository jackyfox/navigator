jQuery(document).ready(function($) {
	$("#phone").mask("+7 999-999-99-99");
	

	$('img').attr("onerror","this.onerror=null;this.src='https://www.google.com/images/srpr/logo11w.png'");

	 if($('.favorite-content .favourites').length == 0) {
 		$('.favorite-content').remove();
 	}
 	//$('.prof_review img').replaceWith($('.prof_review img').outerHTML.replace("src=","data-original="));
 	/*$.fn.extend({
  		renameAttr: function( name, newName, removeData ) {
    	var val;
    	return this.each(function() {
    	  val = jQuery.attr( this, name );
    	  jQuery.attr( this, newName, val );
    	  jQuery.removeAttr( this, name );
    	  // remove original data
    	  if (removeData !== false){
    	    jQuery.removeData( this, name.replace('data-','') );
    	  }
    	});
  	}
	});
	$('img').renameAttr('src', 'data-original', false );*/
 	//$("img").lazyload();

	/**/

	window.onload = function() {
		if($('body').attr('style')) {
			$('body').removeAttr('style');
		}
	}

	setTimeout(function() {
		if($("body").attr("style")) {$("body").removeAttr("style")} ;
	}, 1000);

		$('#search_prof_input').keyup(function(){ 
			var value_input = $(this).val();
			//console.log(value_input); // выводим в консоль набранное пользователем
			var filter_from_1 = $('#filter_form_prof').serializeArray();

			if(location.pathname == '/prof') {
				url = '/searchprof';
				urlview = '/viewprof';
			}

			if(location.pathname == '/job') {
				url = '/searchjob';
				urlview = '/jobview';
			}

			if(location.pathname == '/since') {
				url = '/searchsince';
				urlview = 'sinceview';
			}

			if(location.pathname == '/event') {
				url = '/searchevent';
				urlview = 'eventview';
			}

			if(location.pathname == '/tests') {
				url = '/searchtest';
				urlview = 'testview';
			}

			$.ajax({
				url: url,
				type: 'post',
				data: filter_from_1,
			})
			.done(function(result) {
				if(result.length > 1) {
					///$('#filter_enter').append('<p class="btn btn-info" style="margin: 10px;">'+result+'</p>');
					$('#static_content').fadeOut('fast');
					$('#result_search').empty();
					$('#result_search').fadeIn('fast');
					console.log(result); 
					
					var json = $.parseJSON(result);

					$.each(json, function(index) {

						//console.log(json[index].name);
						if(location.pathname == '/job') {
							if(json[index].type_id != 3 && json[index].type_id != 1) {
								var output = "<div class=prof_review style='margin-top: 20px;'><a href="+urlview+"?id="+json[index].id+"><img src="+json[index].img+" width=270 height=180><h4>"+json[index].name+"</h4></a></div>";
								$('#result_search').append(output);
							}
						}
						if(location.pathname == '/prof') {
							var output = "<div class=prof_review style='margin-top: 20px;'><a href="+urlview+"?id="+json[index].id+"><img src="+json[index].img+" width=270 height=180><h4>"+json[index].name+"</h4></a></div>";
							$('#result_search').append(output);
						}

						if(location.pathname == '/since') {
							if(json[index].type_id != 4) {
								var output = "<div class=prof_review style='margin-top: 20px;'><a href="+urlview+"?id="+json[index].id+"><img src="+json[index].img+" width=270 height=180><h4>"+json[index].name+"</h4></a></div>";
								$('#result_search').append(output);
							}
						}

						if(location.pathname == '/event') {
							
							var output = "<div class='row event'><div class='col-lg-3 data-event'>"+json[index].eventTime+"</div><div class='col-lg-6 description-event'><h2 style='text-align:left;'>"+json[index].name+"<h2><p style='text-align:left;'>"+json[index].description.substr(0,255)+"...</p><div class='btn-event'><a href='/"+urlview+"?id="+json[index].id+"'>Узнать больше</a></div></div><div class='col-lg-3 event-img'><img src='"+json[index].img+"' alt='"+json[index].name+"'></div></div>";
							$('#result_search').append(output);

						}	

						if(location.pathname == '/tests') {
							if(json[index].certificate != '') {
								certificate = 'Сертификат';
							}
							else {
								certificate = 'Сертификат не выдается';
							}
							var output = "<div class='row event'><div class='col-lg-3 data-event'><p>"+json[index].data_start+" - "+json[index].data_end+"</p><p>"+json[index].timeTest+"</p><p>"+json[index].exp+"</p><p>"+certificate+"</p></div><div class='col-lg-6 description-event'><h2 style='text-align:left;'>"+json[index].title+"<h2><p style='text-align:left;'>"+json[index].description.substr(0,255)+"...</p><div class='btn-event'><a href='/"+urlview+"?id="+json[index].id+"'>Узнать больше</a></div></div><div class='col-lg-3 event-img'><img src='"+json[index].img+"' alt='"+json[index].title+"'></div></div>";
							$('#result_search').append(output);

						}

					});
					//var output = "<div class=prof_review style='margin-top: 20px;'><a href=/viewprof?id="+result[i].id+"><img src="+result[i].img+" width=270 height=180><h4>"+result[i].name+"</h4></a></div>";
					//	$('#result_search').append(output);
					
				} 
				else {
					$('#result_search').empty();
					$('#result_search').fadeOut('fast');
					$('#static_content').fadeIn('fast');
				}
				
			})
			.fail(function(result) {
				console.log(result);
			});
			

		});
	
	
	/**/
	// Слайдер  
	$('.multiple-items').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  centerMode: false,
  variableWidth: false
	});		

$('#action_one_range').on("input change", function(e){
 e.preventDefault();
   var slideno = $(this).val(); 
   $('.multiple-items').slick('slickGoTo', slideno-1 );
 });


	$('.multiple-items-two').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  centerMode: false,
  variableWidth: false
	});		

$('#action_one_range-two').on("input change", function(e){
 e.preventDefault();
   var slideno = $(this).val(); 
   $('.multiple-items-two').slick('slickGoTo', slideno-1 );
 });



 $('.slick-arrow').css({
 	display: 'none'
 });

     $("#myCarousel").carousel();

     $('#myCarousel .carousel-inner .item:first-child').addClass('active');


    
	tinymce.init({ selector:'textarea'});

	//Код для отображения каринок в Safari с dropbox
	
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

		if($('.header_page_img').length == 1) {

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
	}


	//конец

document.addEventListener("DOMContentLoaded", function(event) {
   document.querySelectorAll('img').forEach(function(img){
  	img.onerror = function(){this.style.display='none';};
   })
});



$("#dataEnd").datetimepicker({
   	format: 'YYYY-MM-DD'
   	});

$("#dataStart").datetimepicker({
   	format: 'YYYY-MM-DD'
   	});

$("#timeTest").datetimepicker({
   	format: 'HH:mm:Ss'
   	});



});


