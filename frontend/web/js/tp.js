var count = 1;
var variant = 1;
var newJson = {};
var queNum = 0;
var lastVariantNumbr = 0;
$('#checkbox-group').on( "click", function() {
	if (document.getElementById('sendbutton')) { 
		$('#sendbutton').remove();
	}
	if(document.getElementById('questions1') && count == 1){
		//console.log($('div.questions:last').attr("id"));
		let queId = $('div.questions:last').attr("id");
		count = Number(queId.substring(queId.indexOf('questions')+9))+1;
		$('#test_send').hide();
	}
	$('#button-group').hide();
    $('#question-group').append( 
    	'<div class="questions" id="questions'+ (count) +'">'+
	    	'<div class="form-group">'+
				'<label for="test-question" class="col-form-label">Введите вопрос №'+ (count) +'</label>'+
				'<input type="text" class="form-control" id="test-question'+ (count) +'" name ="test-question'+ (count) +'" required>'+
			'</div>'+
			'<p>Варианты ответа вопроса №'+ (count) +':</p>'+
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="checkbox" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch'+ (variant) +'" for="q'+ (count) +'_variant'+ (variant) +'">'+						    
			'</div>'+
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (++variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="checkbox" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch'+ (variant) +'" for="q'+ (count) +'_variant'+ (variant) +'">'+
			'</div>'+
			'<div id="qustion-but-group">'+
	    		'<button type="button" class="btn btn-info" id="newchvariant">&#10010;</button>'+
	    		'<button type="button" class="btn btn-info" id="killvariant">&#8634;</button>'+
	        	'<button type="button" class="btn btn-info" id="newquestion">&#10004;</button>'+
			'</div>'+
		'</div>'
	);
});
$('#radio-group').on( "click", function() {
	if (document.getElementById('sendbutton')) { 
		$('#sendbutton').remove();
	}
	if(document.getElementById('questions1') && count == 1){
		//console.log($('div.questions:last').attr("id"));
		let queId = $('div.questions:last').attr("id");
		count = Number(queId.substring(queId.indexOf('questions')+9))+1;
		$('#test_send').hide();
	}
	//console.log(count);
	$('#button-group').hide();
    $('#question-group').append( 
    	'<div class="questions" id="questions'+ (count) +'">'+
	    	'<div class="form-group">'+
				'<label for="test-question" class="col-form-label">Введите вопрос №'+ (count) +'</label>'+
				'<input type="text" class="form-control" id="test-question'+ (count) +'" name ="test-question'+ (count) +'" required>'+
			'</div>'+
			'<p>Варианты ответа вопроса №'+ (count) +':</p>'+
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="radio" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch" for="q'+ (count) +'_variant'+ (variant) +'">'+						    
			'</div>'+
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (++variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="radio" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch" for="q'+ (count) +'_variant'+ (variant) +'">'+
			'</div>'+
			'<div id="qustion-but-group">'+
	    		'<button type="button" class="btn btn-info" id="newvariant">&#10010;</button>'+
	    		'<button type="button" class="btn btn-info" id="killvariant">&#8634;</button>'+
	        	'<button type="button" class="btn btn-info" id="newquestion">&#10004;</button>'+
			'</div>'+
		'</div>'
	);
});

$("#question-group").on("click", "button#newchvariant", function(){
	if(document.getElementById('qustion-but-group')){
		//console.log('it`s real add');
		$('#qustion-but-group').before(
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (++variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="checkbox" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch'+ (variant) +'" for="q'+ (count) +'_variant'+ (variant) +'">'+
			'</div>'
		);
	}
});
$("#question-group").on("click", "button#newquestion", function(){
	//console.log('clear');
	$('#qustion-but-group').remove();
	if ($('#test_send')) {$('#test_send').show();};
	if ($('#button-group')) {$('#button-group').show();};
	if (count>=1) { 
		$('.modal-footer').append('<button id="sendbutton" type="button" class="btn btn-primary">Отправить</button>');
	}
	/*callin create json function*/
	//TempSendFunction();
	
	if (queNum == 0 && lastVariantNumbr == 0) {
		variant = 1;
		++count;
	} else {
		queNum = 0;
		lastVariantNumbr = 0;
	}
});

$("#question-group").on("click", "button#newvariant", function(){
	if(document.getElementById('qustion-but-group')){
		$('#qustion-but-group').before(
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (count) +'_variant'+ (++variant) +'">Вариант '+ (variant) +'</label>'+
				'<input type="text" class="f" id="q'+ (count) +'_variant'+ (variant) +'" name="q'+ (count) +'_variant'+ (variant) +'"required >'+
			    '<input class="form-check-input" type="radio" value="" id="q'+ (count) +'_ch'+ (variant) +'" name="q'+ (count) +'_ch" for="q'+ (count) +'_variant'+ (variant) +'">'+
			'</div>'
		);
	}
});

$("#question-group").on("click", "button#killvariant", function(){
	if (queNum == 0 && lastVariantNumbr == 0) {
		if (variant>=3) {
			$('div.form-check').remove(":last");
			--variant;
		} else {
			alert("нельзя");
		}
	} else {
		if (lastVariantNumbr>=3) {
			$('#questions'+queNum+' div.form-check').remove(":last");
			--lastVariantNumbr;
		} else {
			alert("нельзя");
		}
	}
});

//по двойному клику на div class="questions"
$('#question-group').on("dblclick", "div.questions", function(){
	if (!document.getElementById('qustion-but-group')) { 
		if ($('#sendbutton')) {$('#sendbutton').remove();};
		if ($('#test_send')) {$('#test_send').hide();};
		//console.log("двойной");
		let queId = this.id;
		queNum = queId.substring(queId.indexOf('questions')+9);
		let lastVariant = $('#'+queId+' .form-check:last-child input:last-child');
		if (~lastVariant.attr("id").indexOf('q'+ queNum +'_ch')) {
			lastVariantNumbr = lastVariant.attr("id").substring(lastVariant.attr("id").indexOf('h')+1);
			$('#button-group').hide();
			if (lastVariant.attr("type") == "radio") {
				$('#questions'+queNum).append(
					'<div id="qustion-but-group">'+
						'<button type="button" class="btn btn-info" id="newReadVariant">&#10010;</button>'+
			    		'<button type="button" class="btn btn-info" id="killvariant">&#8634;</button>'+
			    		'<button type="button" class="btn btn-info" id="retype">&#9850;</button>'+
			        	'<button type="button" class="btn btn-info" id="newquestion">&#10004;</button>'+
			        	'<button type="button" class="btn btn-info" id="killQuestion"><!--&#128128;-->&#10060;</button>'+
					'</div>'
				);
			} else if(lastVariant.attr("type") == "checkbox"){
				$('#questions'+queNum).append(
					'<div id="qustion-but-group">'+
						'<button type="button" class="btn btn-info" id="newChReadVariant">&#10010;</button>'+
			    		'<button type="button" class="btn btn-info" id="killvariant">&#8634;</button>'+
			    		'<button type="button" class="btn btn-info" id="retype">&#9850;</button>'+
			        	'<button type="button" class="btn btn-info" id="newquestion">&#10004;</button>'+
			        	'<button type="button" class="btn btn-info" id="killQuestion"><!--&#128128;-->&#10060;</button>'+
					'</div>'
				);
			}
			//console.log(queNum+' good '+lastVariantNumbr);
		}
	}

	//довести
	//console.log(lastVariant);
});
//конец по двойному клику на div class="questions"

//functions для радактировния
$("#question-group").on("click", "button#killQuestion", function(){	
	let lastQuestionDivNum = $("div.questions:last").attr("id");
	lastQuestionDivNum = Number(lastQuestionDivNum.substring(lastQuestionDivNum.indexOf('questions')+9));
	$('#questions'+queNum).remove();
	if(lastQuestionDivNum>queNum){
		for (let i = queNum; i < lastQuestionDivNum; i++) {
			let temp = i;
			temp++;
			//console.log($("#questions"+(temp)).attr("id"));
			$("div#questions"+temp).attr("id","questions"+i);
			$("div#questions"+i+" div.form-group label").html("Вопрос №"+i);
			$("div#questions"+i+" p").html("Варианты ответа вопроса №"+i+":");
			$("div#questions"+i+" input#test-question"+temp).attr({
				"id":"test-question"+i,
				"name":"test-question"+i
			});			
			let lastVariant = $('#questions'+i+' .form-check:last-child input:last-child');
			lastVariant = lastVariant.attr("id").substring(lastVariant.attr("id").indexOf('h')+1);
			for (let j = 1; j <= lastVariant; j++) {
				$("div#questions"+i+" input#q"+temp+"_variant"+j).attr({
					"id":"q"+i+"_variant"+j,
					"name":"q"+i+"_variant"+j
				});
				$("div#questions"+i+" label[for='q"+temp+"_variant"+j+"']").attr("for","q"+i+"_variant"+j)
				if($("div#questions"+i+" input#q"+temp+"_ch"+j).attr("type") == "radio"){
					$("div#questions"+i+" input#q"+temp+"_ch"+j).attr({
						"id":"q"+i+"_ch"+j,
						"name":"q"+i+"_ch",
						"for":"q"+i+"_variant"+j
					});
				} else if ($("div#questions"+i+" input#q"+temp+"_ch"+j).attr("type") == "checkbox"){
					$("div#questions"+i+" input#q"+temp+"_ch"+j).attr({
						"id":"q"+i+"_ch"+j,
						"name":"q"+i+"_ch"+j,
						"for":"q"+i+"_variant"+j
					});
				}
			}
		}
	}

	queNum = 0;
	lastVariantNumbr = 0;
	count = 1;
	if ($('#test_send')) {$('#test_send').show();};
	if ($('#button-group')) {$('#button-group').show();};
});
$("#question-group").on("click", "button#newReadVariant", function(){
	if(document.getElementById('qustion-but-group')){
		$('#qustion-but-group').before(
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (queNum) +'_variant'+ (++lastVariantNumbr) +'">Вариант '+ (lastVariantNumbr) +'</label>'+
				'<input type="text" class="f" id="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'" name="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'" required>'+
			    '<input class="form-check-input" type="radio" value="" id="q'+ (queNum) +'_ch'+ (lastVariantNumbr) +'" name="q'+ (queNum) +'_ch" for="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'">'+
			'</div>'
		);
	}
});
$("#question-group").on("click", "button#newChReadVariant", function(){
	if(document.getElementById('qustion-but-group')){
		$('#qustion-but-group').before(
			'<div class="form-check">'+
				'<label class="form-check-label" for="q'+ (queNum) +'_variant'+ (++lastVariantNumbr) +'">Вариант '+ (lastVariantNumbr) +'</label>'+
				'<input type="text" class="f" id="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'" name="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'" required>'+
			    '<input class="form-check-input" type="checkbox" value="" id="q'+ (queNum) +'_ch'+ (lastVariantNumbr) +'" name="q'+ (queNum) +'_ch'+ (lastVariantNumbr) +'" for="q'+ (queNum) +'_variant'+ (lastVariantNumbr) +'">'+
			'</div>'
		);
	}
});
$("#question-group").on("click", "button#retype", function(){
	let lastInpType = $('#q'+ queNum +'_ch'+ lastVariantNumbr).attr("type");
	if(lastInpType == "checkbox"){
		let inpInDiv = $('#questions'+queNum+' input:checkbox');
		for (let i = 1; i <= inpInDiv.length; i++) {
			//console.log(inpInDiv.attr("type"));
			inpInDiv.attr("type","radio");
			inpInDiv.attr("name","q"+queNum+"_ch");
		}
		$('#newChReadVariant').attr("id","newReadVariant");
	} else if (lastInpType == "radio"){
		let inpInDiv = $('#questions'+queNum+' input:radio');
		for (let i = 1; i <= inpInDiv.length; i++) {
			inpInDiv.attr("type","checkbox");
			inpInDiv.attr("name","q"+queNum+"_ch"+i);
		}
		$('#newReadVariant').attr("id","newChReadVariant")
	}	
	//console.log('произошла смена типа');
});
//конец functions для радактировния

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


/* Start function create json*/
function TempSendFunction(){

	let elements; //= document.getElementById('test-form').getElementsByTagName('input');
	let tests = {};
	let temp = {};
	let mas1 = {};
	let mas2 = [];
	//let title = elements[0].value;

	elements = document.getElementById('question-group').getElementsByTagName('input');
	//console.log(elements);
	let q = 1;

	for (let i = 0; i < elements.length; i++) {
		
		//console.log(elements[i] + ' id= '+ elements[i].id);
		if (~elements[i].id.indexOf('test-question')){
			if (elements[i].id.substring(13) != q) {
				temp = {};
				mas1 = {};
				mas2 = [];
				q = elements[i].id.substring(13);
				tests[q] = temp;
			}
			temp.qustion = elements[i].value;
		} else
		if(~elements[i].id.indexOf('q'+ q +'_variant')){
			//let idv = elements[i].id;
			let v = elements[i].id.substring(elements[i].id.indexOf('t')+1);
			//ИЗМЕНЕНИЕ МАССИВА 1
			//mas1[v] = elements[i].value;
			//mas1[v] = '["inpVal",'+ elements[i].value +'],["inpId",'+ elements[i].id +']';
			mas1[v] = {"inpVal" : elements[i].value, "inpId" : elements[i].id};
			temp.variant = mas1;
			temp.variantcount = mas1.length;
		} else
		if (~elements[i].id.indexOf('q'+ q +'_ch')) {
			let ch = elements[i].id.substring(elements[i].id.indexOf('h')+1);
			if(elements[i].checked) mas2[mas2.length] = ch;
			temp.truevariant = mas2;
			temp.type = elements[i].type
			temp.truecount = mas2.length;
		}
		if (elements.length-1) {
			//console.log(temp);
			tests[q] = temp;
			tests.questioncount = q;
		}			
	}
	
	newJson = JSON.stringify(tests);

	//tests = JSON.stringify(tests);
	//newJson = '{"title":"'+title+'","timeTest":"'+timeTest+'","idCompany":"'+idCompany+'","description":"'+description+'","rating":"'+rating+'","startDate":"'+startDate+'","endDate":"'+endDate+'","tests":'+tests+'}';
	//console.log(newJson);
	//newJson = JSON.parse(newJson);
	

	//console.log(newJson);
}
/* End function create json*/

/* Send button function*/


$('.edit-test').on("click", "span#test_send", function(){
	TempSendFunction();
	//console.log(newJson);
	tinyMCE.triggerSave();
	var form_data = new FormData(); 
	var id = getUrlVars()["idTest"];

	form_data.append('testArray', newJson);
	form_data.append('idTest', id);

	 $.ajax({
       url: '/editquestiontest',
       type: 'POST',
       cache: false,
       contentType: false,
       processData: false,
       data: form_data,
       success: function(res){
       		console.log(res);
       		console.log(form_data);
			//location.reload();
			if(confirm(res)){
			    window.location.reload();  
			}

       },
       error: function(res){
       	console.log(res);
            alert('Error!');
       }
    });
	
});
$(".modal-footer").on("click", "button#sendbutton", function(){
	
	TempSendFunction();

	var form_data = new FormData(); 
	var id = getUrlVars()["id"];

	let title = document.getElementById("test-name").value;
	let idCompany = id;
	let timeTest = document.getElementById("test-time").value;
	let file = document.getElementById("test-bgtest").files[0];
	let description = document.getElementById("test-description").value;
	let rating =  document.getElementById("test-rating").value;
	let startDate =  document.getElementById("test-starting").value;
	let endDate =  document.getElementById("test-end").value;

	form_data.append('idcompany', idCompany);
	form_data.append('testArray', newJson);
	form_data.append('title', title);
	form_data.append('timeTest', timeTest);
	form_data.append('description', description);
	form_data.append('rating', rating);
	form_data.append('startDate', startDate);
	form_data.append('endDate', endDate);
	form_data.append('bgtest', file);

	 $.ajax({
       url: '/newtests',
       type: 'POST',
       cache: false,
       contentType: false,
       processData: false,
       data: form_data,
       success: function(res){
       		console.log(res);
       		console.log(form_data);
			//location.reload();
			if(confirm(res)){
			    window.location.reload();  
			}

       },
       error: function(res){
       	console.log(res);
            alert('Error!');
       }
    });
});
/* End Send button function*/

$("#test-starting").datetimepicker({
   	format: 'YYYY-MM-DD'
   	});

$("#test-end").datetimepicker({
   	format: 'YYYY-MM-DD'
   	});

$("#test-time").datetimepicker({
   	format: 'HH:mm:Ss'
   	});
