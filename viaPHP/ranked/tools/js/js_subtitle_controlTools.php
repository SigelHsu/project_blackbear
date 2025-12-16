
//將文字串推播到畫面上
function js_pushupSubtitleData (ipt_grabType = 1) {
	// console.log("js_pushupSubtitleData")
	let get_subtitleList = ajax_getSubtitleData(<?=$captionID; ?>, ipt_grabType);
	//console.log("js_pushupSubtitleData ", get_subtitleList)
	//根據抓取到的資料，將字幕寫入到網頁上
	get_subtitleList.forEach(mod => {
		if( mod.Subtitle_ID != "" ) {
			js_addSubtitle(mod); 
		}
	});
	
}

//用 ckEditor的方式，來添加文字串
function js_addSubtitle(ipt_subInfo = []) {
	console.log("js_pushSubtitle: ", ipt_subInfo);
	let tmp_subtitleKey = $("#div_subtitleList > div").length;
	let tmp_insertHtml  = '';
		
	var cke_setting = {
		"width": 			"<?=($data["caption"]["Setting"]["Board-Width"] != "") 	? ($data["caption"]["Setting"]["Board-Width"]."px") : "100%"; ?>",
		"font-size": 	"<?=($data["caption"]["Setting"]["Font-Size"] != "") 		? ($data["caption"]["Setting"]["Font-Size"]."px")	 : "13px"; ?>",
		"padding": 		"<?=($data["caption"]["Setting"]["Set-Padding"] != "") 	? (implode('px ', $data["caption"]["Setting"]["Set-Padding"]) . 'px')	 : "5px 5px 5px 5px"; ?>",
	}
	
	const tmp_divCaption = document.getElementById("div_subtitleList");
	// 檢查 div 是否存在
	if (!tmp_divCaption) {
		console.error(`Element with ID ${whichDiv} not found.`);
		return; 			// 如果找不到，則返回
	}
	
	//建立會被插入的 div
	{
		tmp_insertHtml += '<button type="button" onclick="ajax_publishthisSubtitles('+ipt_subInfo.Subtitle_ID+')" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-danger shadow-sm" disabled>';
		tmp_insertHtml += 	'<i class="fas fa-check-double fa-sm"></i> Published';
		tmp_insertHtml += '</button>';
		tmp_insertHtml += '<label class="col-sm-1 col-form-label" style = "cursor: grab;">';
		tmp_insertHtml += 	'<i class="fas fa-arrows-alt-v"></i>'+(tmp_subtitleKey++)+': ';
		tmp_insertHtml += '</label>';
		tmp_insertHtml += '<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_'+ipt_subInfo.Subtitle_ID+'" name = "input[Subtitle][Info][]" col = "150" row = "6">'+ipt_subInfo.Subtitle_Info+'</textarea>';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][ID][]" 			value="'+ipt_subInfo.Subtitle_ID+'" 		class = "sub_ID" 			>';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][Time][]" 		value="'+ipt_subInfo.Time_Tag+'" 				class = "sub_timeTag" >';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][Order][]" 	value="'+ipt_subInfo.Subtitle_Order+'" 	class = "sub_order" 	>';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][Status][]" 	value="'+ipt_subInfo.Status+'" 					class = "sub_status" 	>';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][POrder][]" 	value="'+ipt_subInfo.Publish_Order+'" 	class = "sub_pOrder" 	>';
		tmp_insertHtml += '<input type="hidden" name="input[Subtitle][MDate][]" 	value="'+ipt_subInfo.Modify_Date+'" 		class = "sub_mDate" 	>';
		tmp_insertHtml += '<!--';
		tmp_insertHtml += '<button type="button" onclick="ajax_chgthisSubtitles('+ipt_subInfo.Subtitle_ID+')" class="d-sm-inline-block btn btn-sm btn btn-outline-secondary shadow-sm">';
		tmp_insertHtml += 	'<i class="fas fa-pen fa-sm"></i> Modify';
		tmp_insertHtml += '</button>';
		tmp_insertHtml += '-->';
	}
	
	const tmp_divSubtitle = document.getElementById('subInfo_'+ipt_subInfo.Subtitle_ID);
	//檢查要會插入的 div是否已經存在
	if ( tmp_divSubtitle ) {
		console.log("div 已經存在");
		// 獲取 textarea 的值
		const tmp_mDate = $("#subInfo_8 > input.sub_mDate").val();
		// 比較 textarea 的值和 ipt_subInfo.Subtitle_Info 的值 
		//console.log(tmp_mDate, "===", ipt_subInfo.Modify_Date);
		if (tmp_mDate == ipt_subInfo.Modify_Date) {
			console.log(`Element with ID ${'subInfo_'+ipt_subInfo.Subtitle_ID} is exist.`);
			return; 		// 如果已經存在則返回 ERROR
		}
		else {
			// 移除現有的 CKEditor 實例 
			if (CKEDITOR.instances['ipt_editor_' + ipt_subInfo.Subtitle_ID]) { 
				CKEDITOR.instances['ipt_editor_' + ipt_subInfo.Subtitle_ID].destroy(true); 
			}
			tmp_divSubtitle.innerHTML = "";
			tmp_divSubtitle.innerHTML = tmp_insertHtml;
		
			CKEDITOR.replace("ipt_editor_"+ipt_subInfo.Subtitle_ID, {
				resize_dir: 'both', 									// 允許水平和垂直調整
				width: 			cke_setting["width"],  		// 設置寬度
				height: 		'100px',  								// 設置高度
				contentsCss: 'body { font-size: '+cke_setting["font-size"]+'; padding: '+cke_setting["padding"]+'; } .cke_editable p { margin: 0 !important; padding: 0 !important; }',  // 設置字體大小和 padding
				bodyClass: 	'style_customEditor',  		// 添加自定義類
				resize_minWidth: 	150, 								// 設置最小寬度
				resize_maxWidth: 	1500, 							// 設置最大寬度
				resize_minHeight: 100, 								// 設置最小高度
				resize_maxHeight: 1000 								// 設置最大高度
			});
			return;
		}
	}
	else {
		
		console.log(tmp_insertHtml);
		// 插入新的 div 元素
		// 創建一個臨時的 div 容器來插入 HTML 
		let tempContainer = document.createElement('div'); 
		tempContainer.id = 'subInfo_' + ipt_subInfo.Subtitle_ID;
		tempContainer.classList.add('form-group');
		tempContainer.classList.add('col-md-12');
		tempContainer.classList.add('form-row');
			
		tempContainer.innerHTML = tmp_insertHtml; 
		
		// 獲取生成的節點 
		let newDiv = tempContainer; 
		// 插入新的 div 元素
		tmp_divCaption.replaceChildren();
		tmp_divCaption.appendChild(newDiv);
		
		// 移除現有的 CKEditor 實例 
		if (CKEDITOR.instances['ipt_editor_' + ipt_subInfo.Subtitle_ID]) { 
			CKEDITOR.instances['ipt_editor_' + ipt_subInfo.Subtitle_ID].destroy(true); 
		}
			
		CKEDITOR.replace("ipt_editor_"+ipt_subInfo.Subtitle_ID, {
			resize_dir: 'both', 									// 允許水平和垂直調整
			width: 			cke_setting["width"],  		// 設置寬度
			height: 		'100px',  								// 設置高度
			contentsCss: 'body { font-size: '+cke_setting["font-size"]+'; padding: '+cke_setting["padding"]+'; } .cke_editable p { margin: 0 !important; padding: 0 !important; }',  // 設置字體大小和 padding
			bodyClass: 	'style_customEditor',  		// 添加自定義類
			resize_minWidth: 	150, 								// 設置最小寬度
			resize_maxWidth: 	1500, 							// 設置最大寬度
			resize_minHeight: 100, 								// 設置最小高度
			resize_maxHeight: 1000 								// 設置最大高度
		});
	}
}