function ajax_sendEventData () {
	//console.log("ajax_sendScoreData");
	
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updEventData.php",
    dataType: "JSON",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			alert("新增/修改成功");
			location.replace("./index.php?loc=editEvent&code="+rspData.Event_Code);
			//location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
	//return rspData;
}
function ajax_sendScoreData () {
	//console.log("ajax_sendScoreData");
	
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updRankData.php",
    dataType: "json",
    data: datas,
		async: false,
    success: function (response) {
			//console.log("success", typeof response);	//console.log(response);
			rspData = response;
			location.reload();
    },
    error: function (thrownError) {
      console.log(thrownError);
    }
  });
	//return rspData;
}
function js_resetData() {
	location.reload();
}
function js_ScoreBoard(target = "") {
	let basic_url = '<?=$GLOBALS["html_root"];?>';
	//console.log("url ", basic_url+"/index.php?loc=scoreBoard&code="+target);
	window.open(basic_url+"/index.php?loc=scoreBoard&code="+target);
}

function js_setStatus(target, value) {
	$(target).parents("div.form-group").find("input.ipt_Status").val(value);
	$(target).parents("div.form-group").find("button").removeClass("btn-primary").addClass("btn-secondary");
	$(target).parents("div.form-group").find("button.btnStatus_"+value).removeClass("btn-secondary").addClass("btn-primary");
}


function js_addRuleColumn() {
	let stn_InsertHtml  = "";
			stn_InsertHtml += "<div class=\"row align-items-center col-md-12 border-bottom mt-2 ml-1\">";
			stn_InsertHtml += 	"<div class=\"row col-md-12\">";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 col-sm-3\">";
			stn_InsertHtml += 			"<label>Rule</label>";
			stn_InsertHtml += 			"<input type=\"hidden\" class=\"form-control\" name=\"input[RankRule][ID][]\" value=\"0\" placeholder=\"RuleTag ID\">";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control\" name=\"input[RankRule][Tag][]\" value=\"\" placeholder=\"排序標籤\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-2 col-sm-2\">";
			stn_InsertHtml += 			"<label>Order</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control\" name=\"input[RankRule][Order][]\" value=\"\" placeholder=\"檢查順序\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"檢查順序(請填入半形阿拉伯數字)\" >";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-2 col-sm-2\">";
			stn_InsertHtml += 			"<label>Default</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control\" name=\"input[RankRule][Default][]\" value=\"0\" placeholder=\"預設起始數值\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"預設起始數值\" >";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-2 col-sm-2\">";
			stn_InsertHtml += 			"<label>Asc</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control\" name=\"input[RankRule][Asc][]\" value=\"\" placeholder=\"0.昇冪/1.降冪\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"0.昇冪/1.降冪\" >";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 col-sm-3\">";
			stn_InsertHtml += 			"<label>Status</label>";
			stn_InsertHtml += 			"<input type=\"hidden\" class=\"form-control ipt_Status\" name=\"input[RankRule][Status][]\" value=\"1\" placeholder=\"狀態設置\">";
			stn_InsertHtml += 			"<div class=\"btn-group\" role=\"group\" aria-label=\"Status Buttons\">";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, 1)\" 	class=\"btn btn-primary btnStatus_1\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Enabled\" ><i class=\"fas fa-tint\"></i></button>";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, 0)\" 	class=\"btn btn-secondary btnStatus_0\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Disabled\" ><i class=\"fas fa-tint-slash\"></i></button>";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, -1)\" 	class=\"btn btn-secondary btnStatus_-1 ml-1\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\" ><i class=\"fas fa-trash-alt\"></i></button>";
			stn_InsertHtml += 			"</div>";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 	"</div>";
			
			stn_InsertHtml += 	"<div class=\"row col-md-12\">";
			stn_InsertHtml += 		"<div class=\"form-group col-md-6\">";
			stn_InsertHtml += 			"<label>Rule Image Loc</label>";
			stn_InsertHtml += 			"<img class=\"ruleImg\" src=\"\" alt=\"\">";
			stn_InsertHtml += 			"<div class=\"input-group\">";
			stn_InsertHtml += 				"<input type=\"text\" class=\"form-control ipt_Img\" name=\"input[RankRule][Img][Loc][]\" value=\"\" placeholder=\"圖片位址\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片位址\" />";
			stn_InsertHtml += 				"<div class=\"input-group-append\">";
			stn_InsertHtml += 					"<button class=\"btn btn-outline-secondary\" onclick=\"js_uploadPic(this, 'Rule')\" type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"上傳圖片\"><i class=\"fas fa-image\"></i></button>";
			stn_InsertHtml += 				"</div>";
			stn_InsertHtml += 			"</div>";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 row\">";
			stn_InsertHtml += 			"<label>Width x Heigh</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[RankRule][Img][Width][]\" 	value=\"\" 	placeholder=\"圖片寬度\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片寬度\">";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[RankRule][Img][Height][]\" 	value=\"\" 	placeholder=\"圖片高度\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片高度\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 row ml-2\">";
			stn_InsertHtml += 			"<label>Left x Top</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[RankRule][Img][Left][]\" value=\"\" placeholder=\"圖片左側間隔\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片左側間隔\">";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[RankRule][Img][Top][]\" value=\"\" 	placeholder=\"圖片頂側間隔\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片頂側間隔\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 	"</div>";
			stn_InsertHtml += "</div>";
			
	$("div#div_rules").append(stn_InsertHtml);
}

function js_addPlayerColumn() {
	let stn_InsertHtml  = "";
			stn_InsertHtml += "<div class=\"row align-items-center col-md-12 border-bottom mt-2 ml-1\">";
			stn_InsertHtml += 	"<div class=\"row col-md-12\">";
			stn_InsertHtml += 		"<div class=\"form-group col-md-9 col-sm-9\">";
			stn_InsertHtml += 			"<label>Player</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control\" name=\"input[Player][Name][]\" value = \"\" placeholder=\"玩家稱謂\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"玩家稱謂\" />";
			stn_InsertHtml += 			"<input type=\"hidden\" name=\"input[Player][Ranked_ID][]\" value=\"0\">";
			stn_InsertHtml += 			"<input type=\"hidden\" name=\"input[Player][ID][]\" value=\"0\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 col-sm-3\">";
			stn_InsertHtml += 			"<label>Status</label>";
			stn_InsertHtml += 			"<input type=\"hidden\" class=\"form-control ipt_Status\" name=\"input[Player][Status][]\" value=\"\" placeholder=\"狀態設置\"></br>";
			stn_InsertHtml += 			"<div class=\"btn-group\" role=\"group\" aria-label=\"Status Buttons\">";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, 1)\" 	class=\"btn btn-primary btnStatus_1\" 					data-toggle=\"tooltip\" data-placement=\"top\" title=\"Enabled\"	><i class=\"fas fa-tint\"></i></button>";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, 0)\" 	class=\"btn btn-primary btnStatus_0\" 					data-toggle=\"tooltip\" data-placement=\"top\" title=\"Disabled\"	><i class=\"fas fa-tint-slash\"></i></button>";
			stn_InsertHtml += 				"<button type=\"button\" onclick=\"js_setStatus(this, -1)\" class=\"btn btn-primary btnStatus_-1 ml-1\" 		data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"		><i class=\"fas fa-trash-alt\"></i></button>";
			stn_InsertHtml += 			"</div>";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 	"</div>";
			stn_InsertHtml += 	"<div class=\"row col-md-12\">";
			stn_InsertHtml += 		"<div class=\"form-group col-md-6\">";
			stn_InsertHtml += 			"<label>Image Loc</label>";
			stn_InsertHtml += 			"<img class=\"playerImg\" src=\"\" alt=\"\">";
			stn_InsertHtml += 			"<div class=\"input-group\">";
			stn_InsertHtml += 				"<input type=\"text\" class=\"form-control ipt_Img\" name=\"input[Player][Img][Loc][]\" value=\"\" placeholder=\"圖片位址\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片位址\" />";
			stn_InsertHtml += 				"<div class=\"input-group-append\">";
			stn_InsertHtml += 					"<button class=\"btn btn-outline-secondary\" onclick=\"js_uploadPic(this, 'Player')\" type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"上傳圖片\"><i class=\"fas fa-image\"></i></button>";
			stn_InsertHtml += 				"</div>";
			stn_InsertHtml += 			"</div>";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 row\">";
			stn_InsertHtml += 			"<label>Width x Heigh</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[Player][Img][Width][]\" 	value=\"\" 	placeholder=\"圖片寬度\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片寬度\">";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[Player][Img][Height][]\" 	value=\"\" 	placeholder=\"圖片高度\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片高度\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 		"<div class=\"form-group col-md-3 row ml-2\">";
			stn_InsertHtml += 			"<label>Left x Top</label>";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[Player][Img][Left][]\" 		value=\"\" 	placeholder=\"圖片左側留白\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片左側留白\">";
			stn_InsertHtml += 			"<input type=\"text\" class=\"form-control col-6 col-sm-3\" name=\"input[Player][Img][Top][]\" 		value=\"\" 	placeholder=\"圖片上方留白\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"圖片上方留白\">";
			stn_InsertHtml += 		"</div>";
			stn_InsertHtml += 	"</div>";
			stn_InsertHtml += "</div>";
			
	$("div#div_players").append(stn_InsertHtml);
}

function js_uploadPic(target, purpose = "") {
	//console.log("js_uploadPic", purpose, " ", target);	//console.log( $(target).parents("div.form-group") );
	//console.log("result?: ", $(target).parents("div.form-group").find(".ipt_ulFile").click() );
	
	let div_parent = $(target).parents("div.form-group");
	let cre_input = document.createElement('input');
	cre_input.type = 'file';

	cre_input.onchange = e => { 

		// getting a hold of the file reference
		let tmpfile = e.target.files[0]; 
		let	tmpData = {"Event_No" : $("input[name=\"input[No]\"]").val(), 
									 "Event_ID" : $("input[name=\"input[ID]\"]").val(), 
									 "Purpose"	: purpose};
		let getFileLoc = ajax_updFileData(tmpfile, tmpData);		//console.log("getFileLoc: ", getFileLoc, getFileLoc["Loc"]);
		div_parent.find("input.ipt_Img").val(getFileLoc["Loc"]);
		div_parent.find("img").attr("src", getFileLoc["Loc"]);
		//後半段暫時用不到，但似乎可以用來預先顯示圖片
		/*
		// setting up the reader
		var reader = new FileReader();
		reader.readAsText(tmpfile,'UTF-8');

		// here we tell the reader what to do when it's done reading...
		reader.onload = readerEvent => {
			var content = readerEvent.target.result; // this is the content!
			//console.log("content ", content );
		}
		*/
	}
	cre_input.click();
}

//將要上傳相關的檔案、資料送到後端處理
function ajax_updFileData (file, data) {
	let send_formData = new FormData();
	let rtnData = "";
	send_formData.append('file', file);
	send_formData.append('input', JSON.stringify(data));
	$.ajax({
		url: "./tools/ajax/ajax_updFileData.php",
    dataType: "JSON",
		type : 'POST',
		data : send_formData,
		async: false,
		processData: false,  // tell jQuery not to process the data
		contentType: false,  // tell jQuery not to set contentType
		success : function(data) {
			rtnData = data;		//console.log(data);
		}
	});
	
	return rtnData;
}

function js_chgNavTab(target) {
	console.log("js_chgNavTab", target);
	$("ul#nav_bar a.nav_tab").removeClass("active");
	$("ul#nav_bar a#tab_"+target).addClass("active");
	$("div#page_edit div.div_edit").removeClass("d-none").addClass("d-none");
	$("div#page_edit div#div_"+target).removeClass("d-none");
}

function js_chgBGShow(target, purpose = "") {
	console.log("js_chgBGShow", target); 	//console.log($(target).parents("div.form-group").find("div.div_setbg"));
	$(target).parents("div.form-group").find("div.div_setbg").removeClass("d-none").addClass("d-none");
	$("div#div_set"+purpose).removeClass("d-none");
	
	let set_Choose = ( (purpose == "ColCol") || (purpose == "BGCol") ) ? ("0") : ("1");
	$(target).parents("div.form-group").find("input.ipt_bgChoose").val(set_Choose);
	console.log( $("input.ipt_bgChoose") );
}