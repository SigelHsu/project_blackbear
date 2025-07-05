<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$countCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");				//$eventNo = 'E000001';	$eventCode = 'voK2xX';
	
	$data["counter"] 	= fun_getCounterData(array("Code" => $countCode) );	//獲取活動資料
	$data["grabInfo"] = fun_getGrabInfoData($data["counter"]["ID"]);			//獲取活動玩家資訊
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Counter</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Counter Value Board</h6>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputNo">Counter No</label>
								<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?=$data["counter"]["No"]; ?>" placeholder="No" disabled>
								<input type="hidden" class="input_ID" 	name="input[ID]" 		value = "<?=$data["counter"]["ID"]; ?>" 	/>
								<input type="hidden" class="input_No" 	name="input[No]" 		value = "<?=$data["counter"]["No"]; ?>" 	/>
								<input type="hidden" class="input_Code" name="input[Code]" 	value = "<?=$data["counter"]["Code"]; ?>" />
							</div>
							<div class="form-group col-md-6">
								<label for="inputTitle">Counter Title</label>
								<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["counter"]["Title"]; ?>" placeholder="Title" disabled>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="inputTargetAPI">Target API</label>
								<input type="text" class="form-control" id="inputTargetAPI" name="input[Target_API]" value="<?=$data["counter"]["Target_API"]; ?>" placeholder="No" disabled>
								<input type="hidden" class="input_No" 	name="input[Target_API]" 			value = "<?=$data["counter"]["Target_API"]; ?>" 	/>
								<input type="hidden" class="input_Code" name="input[Grab_Frequency]" 	value = "<?=$data["counter"]["Grab_Frequency"]; ?>" />
							</div>
							<div class="form-group col-md-4">
								<label for="inputTitle">Grab Frequency</label>
								<input type="text" class="form-control" id="inputFrequency" name="input[Grab_Frequency]" value="<?=$data["counter"]["Grab_Frequency"]; ?>" placeholder="Title" disabled>
							</div>
							<div class="form-group form-row col-md-12 justify-content-end">
								<button type="button" id = "btn_startGrab" 	class="btn btn-primary ml-1" 	onclick="js_startGrabInfoData(<?=$data["counter"]["Grab_Frequency"]; ?>)" >開始抓取</button>
								<button type="button" id = "btn_stopGrab"		class="btn btn-danger ml-1" 	onclick="js_stoprabInfoData()"																					  >停止抓取</button>
							</div>
						</div>
						
						<div class="form-row">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Grab Values</h6>
							</div>
							
							<div class="form-row col-md-12">
								<input type="text" class="form-control col-md-8" name="input[GrabInfo][Value][New]" value="">
								<button type="button" onclick="ajax_addNewValues()" class="d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
									<i class="fas fa-plus fa-sm"></i> Add new Values
								</button>
							</div>
							
							<?php 
								foreach($data["grabInfo"] AS $grabInfo_Key => $grabInfo_Value) :
							?>
							<div class="card-header py-3 d-flex flex-row align-items-center col-md-12">
								<div class="form-group col-md-12 form-row">
									<label>GrabInfo <?=$grabInfo_Key; ?>: </label>
									<input type="text" class="form-control col-md-4" name="input[GrabInfo][Value][]" value="<?=$grabInfo_Value["Grab_Values"]; ?>">
									<input type="hidden" 	name="input[GrabInfo][ID][]" value="<?=$grabInfo_Value["GrabInfo_ID"]; ?>">
								</div>
							</div>
							<?php 
								endforeach;
							?>
						</div>
						
						<div class="form-row justify-content-end">
							<button type="button" onclick="ajax_sendGrabInfoData()" 				class="btn btn-primary ml-1">Submit</button>
							<button type="button" onclick="js_resetData()" 									class="btn btn-secondary ml-1">Reset</button>
							<button type="button" onclick="js_ScoreBoard(<?=$countCode;?>)" class="btn btn-secondary ml-1">Show Board</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>

<style type="text/css">
	
	.playerImg {
		width: 50px;
		text-align: center;
	}
</style>
<script><?php include_once("./tools/js/js_counter_controlTools.php"); ?></script>