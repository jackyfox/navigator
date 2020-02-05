var userJson;

function TempSendUserFunction(){
	let elements = $('div.questions');
	let questionCount = elements.length;	
	let mas1 = {};

	for (let i = 0; i < questionCount; i++) {
		//console.log(elements[i].children[0].firstChild.data);
		let mas2 = [];
		let chtype ="";
		mas1[i+1] ={};
		mas1[i+1]["question"] = elements[i].children[0].firstChild.data;
		mas1[i+1]["variant"] = {};
		for (var j = 1; j <= elements[i].children.length-1; j++) {
			mas1[i+1]["variant"][j] = {};
			mas1[i+1]["variant"][j]["inpVal"] = $("label[for='q"+(i+1)+"_ch"+j+"']").text();
			mas1[i+1]["variant"][j]["inpId"] = "q"+(i+1)+"_variant"+j;
			if($("#q"+(i+1)+"_ch"+j).prop("checked")){
				let ch = $("#q"+(i+1)+"_ch"+j).attr("id").substring($("#q"+(i+1)+"_ch"+j).attr("id").indexOf('h')+1);
				chtype = $("#q"+(i+1)+"_ch"+j).attr("type");
				mas2[mas2.length] = ch;
				//console.log($("#q"+(i+1)+"_ch"+j).attr("id"));
			}

		}
		mas1[i+1]["givevariant"] = mas2;
		mas1[i+1]["type"] = chtype;
		mas1[i+1]["givecount"] = mas2.length;		
	}
	mas1["questioncount"] = ""+questionCount+"";
	userJson = JSON.stringify(mas1);
}

$('.test-user').on('click', 'span#test_send_user', function() {
	TempSendUserFunction();
	console.log(userJson);

	var form_data = new FormData(); 

	var id = getUrlVars()["id"];
	var arrayWithAnswer = userJson;

	form_data.append('idTest', id);
	form_data.append('arrayWithAnswer', arrayWithAnswer);

	 $.ajax({
       url: '/usertestsend',
       type: 'POST',
       cache: false,
       contentType: false,
       processData: false,
       data: form_data,
       success: function(res){
       		$("#certificateResult").empty();
       		$("#certificateResultModal").modal('show');
       		$("#certificateResult").append(res);
       },
       error: function(res){
       	console.log(res);
            alert('Error!');
       }
    });
});


$('.getcert').click(function(){

	var form_data = new FormData(); 

	var id = getUrlVars()["id"];

	form_data.append('idTest', id);

		 $.ajax({
	       url: '/getcertificate',
	       type: 'POST',
	       cache: false,
	       contentType: false,
	       processData: false,
	       data: form_data,
	       success: function(res){
	       		$("#certificateResult").empty();
	       		$("#certificateResultModal").modal('show');
	       		$("#certificateResult").append(res);
	       },
	       error: function(res){
	       	console.log(res);
	            alert('Error!');
	       }
	    });

});

