<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$captionCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");																																//$captionNo = 'S000001';	$captionCode = 'voK2xX';
	
	$data["caption"] 	= fun_getCaptionData( array("Code" => $captionCode) );																											//獲取字幕組資料
	$data["subtitle"] = fun_getSubtitlesData( array("Caption_ID" => $data["caption"]["ID"], "Subtitle_LsitOrder" => 2) );					//獲取字幕資訊
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Caption - Modify Subtitle</h1>
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
						<div class="form-row">
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
								<h6 class="m-0 font-weight-bold text-primary">Subtitle List</h6>
						
								<div class="form-row justify-content-end">
									<button type="button" class="btn btn-primary ml-1" 		onclick="ajax_chgSubtitleOrder()" disabled 			>Change Order</button>
									<button type="button" class="btn btn-secondary ml-1" 	onclick="js_resetData()" 												>Reset</button>
									<button type="button" class="btn btn-secondary ml-1" 	onclick="js_showCaption('<?=$captionCode;?>')" 	>Show Board</button>
								</div>
							</div>
								
							<div class="form-group col-md-12">
								<div>
									<label for="inputTitle">請輸入要新增的字幕：</label>
								</div>
								<div class="form-row col-md-12">
									<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_New" name = "input[Subtitle][Info][New]" col = "150" row = "6"></textarea>
									<input type="hidden" 	class="form-control col-md-2" name="input[Subtitle][Order][New]" 	value="" placeholder="順序(請輸入半形數字)" >
									<input type="hidden" 	class="form-control col-md-2" name="input[Subtitle][Time][New]" 	value="" placeholder="時間標籤(HH:MM:SS，如11:12:13)" >
									<button type="button" onclick="ajax_addNewSubtitles()" class="d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Subtitle
									</button>
								</div>
							</div>
							
							<div id = "div_subtitleList" class="sortable card-header py-3 col-md-12">
								<?php 
									foreach($data["subtitle"] AS $subtitleInfo_Key => $subtitleInfo_Value) :
								?>
								<div id="subInfo_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" class="form-group col-md-12 form-row">
									<?php if ($subtitleInfo_Value["Status"] == 1): ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-danger shadow-sm" disabled>
										<i class="fas fa-caret-square-up fa-sm"></i> Wait Publish
									</button>
									<?php else : ?>
									<button type="button" onclick="ajax_publishthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="col-sm-1 d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm" disabled >
										<i class="fas fa-check-double fa-sm"></i> Published
									</button>
									<?php endif; ?>
									<label class="col-sm-1 col-form-label" style = "cursor: grab;">
										<i class="fas fa-arrows-alt-v"></i><?=$subtitleInfo_Key +1; ?>: 
									</label>
									<textarea class="ipt_cke sub_Info form-control col-md-4" id="ipt_editor_<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" name = "input[Subtitle][Info][]" col = "150" row = "6"><?=trim($subtitleInfo_Value["Subtitle_Info"]); ?></textarea>
									<input type="hidden" name="input[Subtitle][ID][]" 		value="<?=$subtitleInfo_Value["Subtitle_ID"]; ?>" 		class = "sub_ID" 			>
									<input type="hidden" name="input[Subtitle][Time][]" 	value="<?=$subtitleInfo_Value["Time_Tag"]; ?>" 				class = "sub_timeTag" >
									<input type="hidden" name="input[Subtitle][Order][]" 	value="<?=$subtitleInfo_Value["Subtitle_Order"]; ?>" 	class = "sub_order" 	>
									<input type="hidden" name="input[Subtitle][Status][]" value='<?=$subtitleInfo_Value["Status"]; ?>' 					class = "sub_other" 	>
									<input type="hidden" name="input[Subtitle][POrder][]" value='<?=$subtitleInfo_Value["Publish_Order"]; ?>' 	class = "sub_other" 	>
									<button type="button" onclick="ajax_chgthisSubtitles(<?=$subtitleInfo_Value["Subtitle_ID"]; ?>)" class="d-sm-inline-block btn btn-sm btn btn-outline-secondary shadow-sm">
										<i class="fas fa-pen fa-sm"></i> Modify
									</button>
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
	#div_subtitleList {
		max-height: 600px;
		overflow-y: scroll;
	}
	
	.ipt_cke {
		width: 700px;  /* 設置寬度 */
		height: 400px; /* 設置高度 */
	}
</style>
<script>
	$(document).ready(function() {
		fun_hideTheTopLeftBar();
		//$( ".sortable" ).sortable();
		//js_showhtmlspecialchars(".sub_Info");
		js_creCkeditorBox(".ipt_cke");
		fun_listenEventviaCKEditor("CaptionSubtitle");
	});
</script>

<script><?php include_once("./tools/js/js_caption_controlTools.php"); ?></script>
