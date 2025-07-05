// caption_create.php
function ajax_sendCaptionData () {
	
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updCaptionData.php",
    dataType: "JSON",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			alert("新增/修改成功");
			location.replace("./index.php?loc=editCaption&code="+rspData.Caption_Code);
			//location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
	//return rspData;
}

// caption_create.php
function js_showCaption(target = "") {
	let basic_url = '<?=$GLOBALS["html_root"];?>';
	window.open(basic_url+"/index.php?loc=showCaption&code="+target);
}
// caption_create.php
function js_resetData() {
	location.reload();
}

function js_setStatus(target, value) {
	$(target).parents("div.form-group").find("input.ipt_Status").val(value);
	$(target).parents("div.form-group").find("button").removeClass("btn-primary").addClass("btn-secondary");
	$(target).parents("div.form-group").find("button.btnStatus_"+value).removeClass("btn-secondary").addClass("btn-primary");
}

function js_chgNavTab(target) {
	console.log("js_chgNavTab", target);
	$("ul#nav_bar a.nav_tab").removeClass("active");
	$("ul#nav_bar a#tab_"+target).addClass("active");
	$("div#page_edit div.div_edit").removeClass("d-none").addClass("d-none");
	$("div#page_edit div#div_"+target).removeClass("d-none");
}

function js_creCkeditorBox (target = "") {
	$(target).each(function() {
		var tmp_textareaName = $(this).attr("id");
		CKEDITOR.replace(tmp_textareaName, {
			width: '1500px',  // 設置寬度
			height: '100px'  // 設置高度
		});
	});
	
	return true;
}

function js_showhtmlspecialchars(target = ".sub_Info") {
	$(target).each( function () {
		// 創建一個臨時的 DOM 元素來解碼 HTML 實體
		var tempElement = document.createElement('div');
		tempElement.innerHTML = $(this).val();
		//console.log(tempElement);
		// 將解碼後的值設置回 input 元素
		$(this).val( tempElement.textContent || tempElement.innerText );
	});
}

function js_uptTextareaFromCKEditor() {
	for (var instance in CKEDITOR.instances) {
		var editor = CKEDITOR.instances[instance];
		editor.updateElement();
		var textarea = document.getElementById(editor.element.$.id);
		//console.log("Updated textarea value: ", textarea.value); // 確認更新後的值
	}
}

// caption_subtitle.php 		// 主要用來新增字幕		@ 大致上完成，但是還要等 CKEditor再一起修改才算完成
function ajax_addNewSubtitles() {
	let rspData = [];					//console.log("ajax_addNewSubtitles");
	
	js_uptTextareaFromCKEditor();
	
	var datas = $("form").serializeArray();
	datas.push({ name: "modify_type", value: "NewSub" });
	let tmp_subInfo = datas.find(item => item.name === "input[Subtitle][Info][New]");		//console.log("datas: ", datas);
	
	if( tmp_subInfo == "" ) {
		return false;
	}
	
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updSubtitlesInfo.php",
    dataType: "HTML",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			//alert("新增成功");
			fun_throughToast2Local({toastMsg: "Added: " + tmp_subInfo});
			location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}

// caption_subtitle.php 		// 主要用來修改字幕		@ 大致上完成，但是還要等 CKEditor再一起修改才算完成
function ajax_chgthisSubtitles(target_ID) {
	let rspData = [];			//console.log("ajax_chgthisSubtitles: ", target_ID);
	
	js_uptTextareaFromCKEditor();
	
	let tmp_subInfo 	= $("#subInfo_"+target_ID).find("textarea.sub_Info").val();
	let tmp_subID 		= $("#subInfo_"+target_ID).find("input.sub_ID").val();
	let tmp_subTime		= $("#subInfo_"+target_ID).find("input.sub_timeTag").val();
	let tmp_subOrder	= $("#subInfo_"+target_ID).find("input.sub_order").val();
	
	if( tmp_subInfo == "" ) {
		return false;
	}
	
	var datas = [
		{ name: "modify_type", 		value: "ChgSub" },
		{ name: "target_ID", 			value: tmp_subID },
		{ name: "subtitle_Info", 	value: tmp_subInfo },
		{ name: "subtitle_Time", 	value: tmp_subTime },
		{ name: "subtitle_Order", value: tmp_subOrder }
	];		// console.log("ajax_chgthisSubtitles: ", datas);
	
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updSubtitlesInfo.php",
    dataType: "HTML",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			//alert("修改成功");
			fun_throughToast2Local({toastMsg: "Modified: " + tmp_subInfo});
			location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}


// caption_subtitle.php			// 主要用來修改順序 	@ 還沒修改到這邊，要搭配 drag & drop
function ajax_chgSubtitleOrder() {
	//console.log("ajax_chgSubtitleOrder");
	let rspData = [];
	
	js_uptTextareaFromCKEditor();
	
	var datas = $("form").serializeArray();
	datas.push({ name: "modify_type", value: "ChgOrder" });
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updSubtitlesInfo.php",
    dataType: "HTML",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			//alert("修改成功");
			fun_throughToast2Local({toastMsg: "The Subtitle's order is success changed."});
			//location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}


// caption_subtitle.php			// 發佈目標文字
function ajax_publishthisSubtitles(target_ID) {
	// console.log("ajax_publishthisSubtitles ");
	let rspData = [];
	
	js_uptTextareaFromCKEditor();
	
	let tmp_capID 		= $("#box_captionInfo").find("input.input_ID").val();
	let tmp_subInfo 	= $("#subInfo_"+target_ID).find("textarea.sub_Info").val();
	let tmp_subID 		= $("#subInfo_"+target_ID).find("input.sub_ID").val();
	let tmp_subTime		= $("#subInfo_"+target_ID).find("input.sub_timeTag").val();
	let tmp_subOrder	= $("#subInfo_"+target_ID).find("input.sub_order").val();
	
	if( tmp_subInfo == "" ) {
		return false;
	}
	
	var datas = [
		{ name: "modify_type", 		value: "PubSub" },
		{ name: "caption_ID", 		value: tmp_capID },
		{ name: "target_ID", 			value: tmp_subID },
		{ name: "subtitle_Info", 	value: tmp_subInfo },
		{ name: "subtitle_Time", 	value: tmp_subTime },
		{ name: "subtitle_Order", value: tmp_subOrder }
	];
	// console.log("ajax_publishthisSubtitles: ", datas);
	
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updSubtitlesInfo.php",
    dataType: "HTML",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			//alert("發佈成功");
			fun_throughToast2Local({toastMsg: "Published: " + tmp_subInfo});
			location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}