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

function js_creCkeditorBox (target = "", setting = {"width": "100%", "font-size": "13px", "padding": "1px 1px 1px 1px"} ) {
	$(target).each(function() {
		var tmp_textareaName = $(this).attr("id");
		CKEDITOR.replace(tmp_textareaName, {
			resize_dir: 'both', 									// 允許水平和垂直調整
			width: 			setting["width"],  				// 設置寬度
			height: 		'100px',  								// 設置高度
			contentsCss: 'body { font-size: '+setting["font-size"]+'; padding: '+setting["padding"]+'; } .cke_editable p { margin: 0 !important; padding: 0 !important; }',  // 設置字體大小和 padding
			bodyClass: 	'style_customEditor',  		// 添加自定義類
			resize_minWidth: 	150, 								// 設置最小寬度
			resize_maxWidth: 	1500, 							// 設置最大寬度
			resize_minHeight: 100, 								// 設置最小高度
			resize_maxHeight: 1000 								// 設置最大高度
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

// caption_subtitle.php 		// 主要用來新增字幕	
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
			
			//這是原本的情況，會重新整理頁面，但說太麻煩
			//fun_throughToast2Local({toastMsg: "Added: " + tmp_subInfo});
			//location.reload();
			
			fun_showToastMessage({toastMsg: "Added: " + tmp_subInfo});
			js_pushupSubtitleData(2);								//抓取最後的資料
			//這邊還要把 CKeditor裡面的文字清空
			if (CKEDITOR.instances.ipt_editor_New) {
				CKEDITOR.instances.ipt_editor_New.setData('');
			}
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}

// caption_subtitle.php 		// 主要用來修改字幕
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


// caption_subtitle.php			// 主要用來修改順序
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
			location.reload();
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

	
//利用 ajax抓取資料	ipt_grabType == 1的時候，抓最新的資料；2的時候，抓全部的資料
function ajax_getSubtitleData (captionID = 0, ipt_grabType = 1) {
	//console.log("ajax_getCounterData");
	let rspData = [];
	let tmp_modifyType = "NewSubtitles";
	switch(ipt_grabType) {
		default:
		case 1:	//僅抓最新一筆待發佈的
			tmp_modifyType = "NewSubtitles";
			break;
		case 2:	//抓取所有已經發佈過的
			tmp_modifyType = "AllSubtitles";
			break;
		case 3:	//無論狀態抓取所有內容
			tmp_modifyType = "ZenSubtitles";
			break;
		case 4:
			tmp_modifyType = "LastSubtitles";
			break;
		case 5:
			tmp_modifyType = "LastAddSub";
			break;
		case 6:
			tmp_modifyType = "LastModifySub";
			break;
	}
	var datas = [
		{ name: "modify_type", 		value: tmp_modifyType },
		{ name: "caption_ID", 		value: captionID }
	];
	rspData = {}
	$.ajax({
		type: "POST",
		url: "./tools/ajax/ajax_getSubtitlesInfo.php",
		dataType: "JSON",
		data: datas,
		async: false,
		success: function (response) {
			console.log("success: ", typeof response, "; response:", response);
			rspData = response;
		},
		error: function (thrownError) {
			//console.log(thrownError);
		}
	});
	return rspData;
}





