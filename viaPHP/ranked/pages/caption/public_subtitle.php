<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$captionCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");						//$captionNo = 'S000001';	$captionCode = 'voK2xX';
	
	$data["caption"] 	= fun_getCaptionData( array("Code" => $captionCode) );																											//獲取字幕組資料
	$data["subtitle"] = fun_getSubtitlesData( array("Caption_ID" => $data["caption"]["ID"], "Subtitle_LsitOrder" => 1) );					//獲取字幕資訊
	$captionID 				= $data["caption"]["ID"];
	$set_Frequency = array(
		"FreUpd" 	 	=> (isset($data["setting"]["Update-Frequency"]) && ($data["setting"]["Update-Frequency"] 	!= 0)) ? ($data["setting"]["Update-Frequency"]) : (0.5)
	);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Caption - Publish Subtitle</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Caption's Subtitle Board</h6>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div id="box_captionInfo" class="form-row">
							<div class="form-group col-md-6">
								<label for="inputNo">Caption No</label>
								<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?=$data["caption"]["No"]; ?>" placeholder="No" disabled>
								<input type="hidden" class="input_ID" 	name="input[ID]" 		value = "<?=$data["caption"]["ID"]; ?>" 	/>
								<input type="hidden" class="input_No" 	name="input[No]" 		value = "<?=$data["caption"]["No"]; ?>" 	/>
								<input type="hidden" class="input_Code" name="input[Code]" 	value = "<?=$data["caption"]["Code"]; ?>" />
							</div>
							<div class="form-group col-md-6">
								<label for="inputTitle">Caption Title</label>
								<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["caption"]["Title"]; ?>" placeholder="Title" disabled>
							</div>
						</div>
						
						<div class="form-row">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">To Pubilsh Subtitle List</h6>
						
								<div class="form-row justify-content-end">
									<button type="button" class="btn btn-primary ml-1" 		onclick="ajax_chgSubtitleOrder()"  							>Change Order</button>
									<button type="button" class="btn btn-secondary ml-1" 	onclick="js_resetData()" 												>Reset</button>
									<button type="button" class="btn btn-secondary ml-1" 	onclick="js_showCaption('<?=$captionCode;?>')" 	>Show Board</button>
								</div>
							</div>
							
							<!--
							<div class="form-group col-md-12">
								<div>
									<label for="inputTitle">請輸入要新增的字幕：</label>
								</div>
								<div class="form-row col-md-12">
									<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_New" name = "input[Subtitle][Info][New]" col = "150" row = "6"></textarea>
									<input type="hidden" 	class="form-control col-md-2" 	name="input[Subtitle][Order][New]" 	value="" placeholder="順序(請輸入半形數字)" >
									<input type="hidden" 	class="form-control col-md-2" 	name="input[Subtitle][Time][New]" 	value="" placeholder="時間標籤(HH:MM:SS，如11:12:13)" >
									<button type="button" onclick="ajax_addNewSubtitles()" class="d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Values
									</button>
								</div>
							</div>
							-->
							
							<div id = "div_subtitleList" class="sortable card-header py-3 col-md-12">
								<?php 
									$data["subtitle"] = fun_getSubtitlesData( array("Caption_ID" => $data["caption"]["ID"], "Subtitle_Status" => 1, "Subtitle_StatusR" => 2, "Subtitle_LsitOrder" => 1) );
									foreach($data["subtitle"] AS $subtitleInfo_Key => $subtitleInfo_Value) :
										if($subtitleInfo_Value["Status"] == 2) {
											continue;
										}
								?>
								<div id="subInfo_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" class="form-group col-md-12 form-row">
									<?php if ($subtitleInfo_Value["Status"] == 1): ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-danger shadow-sm" >
										<i class="fas fa-caret-square-up fa-sm"></i> To Publish
									</button>
									<?php else : ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm" disabled >
										<i class="fas fa-check-double fa-sm"></i> Published
									</button>
									<?php endif; ?>
									<label class="col-sm-1 col-form-label" style = "cursor: grab;">
										<i class="fas fa-arrows-alt-v"></i><?=$subtitleInfo_Key +1; ?>: 
									</label>
									<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" name = "input[Subtitle][Info][]" col = "150" row = "6" readonly><?=($subtitleInfo_Value["Subtitle_Info"]); ?></textarea>
									<input type="hidden" name="input[Subtitle][ID][]" 		value="<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" 		class = "sub_ID" 			>
									<input type="hidden" name="input[Subtitle][Time][]" 	value="<?=$subtitleInfo_Value["Time_Tag"]; ?>" 				class = "sub_timeTag" >
									<input type="hidden" name="input[Subtitle][Order][]" 	value="<?=$subtitleInfo_Value["Subtitle_Order"]; ?>" 	class = "sub_order" 	>
									<input type="hidden" name="input[Subtitle][Status][]" value="<?=$subtitleInfo_Value["Status"]; ?>" 					class = "sub_status" 	>
									<input type="hidden" name="input[Subtitle][POrder][]" value="<?=$subtitleInfo_Value["Publish_Order"]; ?>" 	class = "sub_pOrder" 	>
									<input type="hidden" name="input[Subtitle][MDate][]" 	value="<?=$subtitleInfo_Value["Modify_Date"]; ?>" 		class = "sub_mDate" 	>
									<!--
									<button type="button" onclick="ajax_chgthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="d-sm-inline-block btn btn-sm btn btn-outline-secondary shadow-sm">
										<i class="fas fa-pen fa-sm"></i> Modify
									</button>
									-->
								</div>
								<?php 
									endforeach;
									
								?>
							</div>
							
							</hr>
							<button type="button" onclick="js_divToggle('#div_publicList')" class="d-sm-inline-block btn btn-sm btn btn-outline-secondary shadow-sm">
								<i class="fas fa-eye"></i> Pubilshed List
							</button>
							<div id = "div_publicList" class="sortable card-header py-3 col-md-12 d-none">
								<?php 
									$data["subtitle"] = fun_getSubtitlesData( array("Caption_ID" => $data["caption"]["ID"], "Subtitle_Status" => 2, "Subtitle_StatusR" => 4, "Subtitle_LsitOrder" => 1) );
									foreach($data["subtitle"] AS $subtitleInfo_Key => $subtitleInfo_Value) :
										if (in_array($subtitleInfo_Value["Status"], array(1))) {
											continue;
										}
								?>
								<div id="subInfo_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" class="form-group col-md-12 form-row">
									<?php if ($subtitleInfo_Value["Status"] == 1): ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-danger shadow-sm" >
										<i class="fas fa-caret-square-up fa-sm"></i> To Publish
									</button>
									<?php else : ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm" disabled >
										<i class="fas fa-check-double fa-sm"></i> Published
									</button>
									<?php endif; ?>
									<label class="col-sm-1 col-form-label" style = "cursor: grab;">
										<i class="fas fa-arrows-alt-v"></i><?=$subtitleInfo_Key +1; ?>: 
									</label>
									
									<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" name = "input[Subtitle][Info][]" col = "150" row = "6" readonly><?=($subtitleInfo_Value["Subtitle_Info"]); ?></textarea>
									<input type="hidden" name="input[Subtitle][ID][]" 		value="<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" 		class = "sub_ID" 			>
									<input type="hidden" name="input[Subtitle][Time][]" 	value="<?=$subtitleInfo_Value["Time_Tag"]; ?>" 				class = "sub_timeTag" >
									<input type="hidden" name="input[Subtitle][Order][]" 	value="<?=$subtitleInfo_Value["Subtitle_Order"]; ?>" 	class = "sub_order" 	>
									<input type="hidden" name="input[Subtitle][Status][]" value="<?=$subtitleInfo_Value["Status"]; ?>" 					class = "sub_status" 	>
									<input type="hidden" name="input[Subtitle][POrder][]" value="<?=$subtitleInfo_Value["Publish_Order"]; ?>" 	class = "sub_pOrder" 	>
									<input type="hidden" name="input[Subtitle][MDate][]" 	value="<?=$subtitleInfo_Value["Modify_Date"]; ?>" 		class = "sub_mDate" 	>
									<!--
									<button type="button" onclick="ajax_chgthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="d-sm-inline-block btn btn-sm btn btn-outline-secondary shadow-sm">
										<i class="fas fa-pen fa-sm"></i> Modify
									</button>
									-->
								</div>
								<?php 
									endforeach;
								?>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>

<style type="text/css">
	#div_subtitleList, #div_publicList {
		max-height: 600px;
		overflow-y: scroll;
	}
</style>
<script>
	// 設定執行的間隔時間（毫秒）
	const set_intervalTime = <?=$set_Frequency["FreUpd"]; ?> * 1000; // 1000 毫秒 = 1 秒
	
	$(document).ready(function() {
		fun_hideTheTopLeftBar();
		$( ".sortable" ).sortable();
		//js_showhtmlspecialchars(".sub_Info");
		js_creCkeditorBox(".ipt_cke");
		fun_listenEvent("PublicSubtitle");
		
		//利用函式，自動將新的字幕推送到 #div_subtitleList裡面
		let timerId = setInterval("js_pushupSubtitleData(6);", set_intervalTime);
	});
	function js_divToggle(ipt_targetDiv = "")  {
		$(ipt_targetDiv).toggleClass("d-none");
	}
</script>
<script><?php include_once("./tools/js/js_caption_controlTools.php"); ?></script>
<script>
	
	function js_pushupSubtitleData (ipt_grabType = 1) {
		// console.log("js_pushupSubtitleData")
		let get_subtitleList = ajax_getSubtitleData(<?=$captionID; ?>, ipt_grabType);
		console.log("js_pushupSubtitleData ", get_subtitleList)
		//根據抓取到的資料，將字幕寫入到網頁上
		get_subtitleList.forEach(mod => {
			if( mod.Subtitle_ID != "" ) {
				js_addSubtitle(mod); 
			}
    });
		
	}

	function js_addSubtitle(ipt_subInfo = []) {
		console.log("js_pushSubtitle: ", ipt_subInfo);
		let tmp_subtitleKey = $("#div_subtitleList > div").length;
		let tmp_insertHtml  = '';
		
		const tmp_divCaption = document.getElementById("div_subtitleList");
		// 檢查 div 是否存在
    if (!tmp_divCaption) {
			console.error(`Element with ID ${whichDiv} not found.`);
			return; 			// 如果找不到，則返回
    }
		
		//建立會被插入的 div
		{
			tmp_insertHtml += '<button type="button" onclick="ajax_publishthisSubtitles('+ipt_subInfo.Subtitle_ID+')" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-danger shadow-sm" >';
			tmp_insertHtml += 	'<i class="fas fa-caret-square-up fa-sm"></i> To Publish';
			tmp_insertHtml += '</button>';
			tmp_insertHtml += '<label class="col-sm-1 col-form-label" style = "cursor: grab;">';
			tmp_insertHtml += 	'<i class="fas fa-arrows-alt-v"></i>'+(tmp_subtitleKey++)+': ';
			tmp_insertHtml += '</label>';
			tmp_insertHtml += '<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_'+ipt_subInfo.Subtitle_ID+'" name = "input[Subtitle][Info][]" col = "150" row = "6" readonly>'+ipt_subInfo.Subtitle_Info+'</textarea>';
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
					width: '1500px',  // 設置寬度
					height: '100px'  // 設置高度
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
			let newDiv = tempContainer.firstElementChild; 
			
			// 插入新的 div 元素
			tmp_divCaption.appendChild(newDiv);
			
			CKEDITOR.replace("ipt_editor_"+ipt_subInfo.Subtitle_ID, {
				width: '1500px',  // 設置寬度
				height: '100px'  // 設置高度
			});
		}
	}
</script>