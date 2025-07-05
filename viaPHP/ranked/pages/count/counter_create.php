<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$countCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");						//$eventNo = 'C000001';	$countCode = 'voK2xX';
	
	if($countCode != "") {
		$data["counter"] 		= fun_getCountData(array("Code" => $countCode) );	//獲取計數器資料
	}
	else {
		$data["counter"] = array( 
			"ID" 							=> "0",
			"No" 							=> "",
			"Code" 						=> "",
			"Title" 					=> "",
			"Target_API" 			=> "",
			"Grab_Frequency" 	=> 0,
			"Setting" => array(
				"Font-Family" 			=> "sans-serif",
				"Font-Size" 				=> "20",
				"Font-Color" 				=> "",
				"Font-Shadow" 			=> "",
				"Font-Content" 			=> 1,
				"Font-Position" 		=> array("X" => 0, "Y" => 0),
				"Background-Color" 	=> "",
				"Background-Img" 		=> "",
				"Board-Transparent" => 0,
				"Background-Width" 	=> "",
				"Background-Height" => "",
				"Duration-Start" 		=> "",
				"Duration-Per" 			=> "",
				"Duration-Max" 			=> "",
				"Update-Frequency" 	=> "",
				"Duration-Nsec" 		=> "",
				"Duration-Msec" 		=> "",
				"Set-Padding" 			=> array(0, 0, 0, 0),
				"Set-Margin" 				=> array(0, 0, 0, 0),
			),
		);
	}
	
	//print_r($data["players"]);	//exit();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Counter</h1>
</div>


<!-- Content Row -->
<div class="row">
	<div class="col-xl-12 col-lg-12">
		<!--標籤列-->
		<div>
			<ul id="nav_bar" class="nav nav-tabs">
				<li class="nav-item">
					<a id="tab_events" class="nav_tab nav-link active" href="javaScript:js_chgNavTab('counters');">Setting</a>
				</li>
			</ul>
		</div>
		
		<div id="page_edit" class="card shadow mb-4">			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div class="div_edit form-row" id = "div_counters">
							<!-- Card Header - Dropdown -->
							<div class="card-header d-flex justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Counter Setting</h6>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-md-3">
									<label for="inputNo">Counter No <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="計數器編號，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputNo" name="input[No]" value="" placeholder="(系統生成)" disabled />
									<input type="hidden" class="input_ID" 	name="input[ID]" 		value = "0" />
									<input type="hidden" class="input_No" 	name="input[No]" 		value = "" 	/>
									<input type="hidden" class="input_Code" name="input[Code]" 	value = "" 	/>
								</div>
								<div class="form-group col-md-3">
									<label for="inputCode">Counter Code <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="計數器獨特碼，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputCode" name="input[Code]" value="" placeholder="(系統生成)" disabled />
								</div>
								<div class="form-group col-md-6 col-sm-6">
									<label for="inputTitle">Counter Title</label>
									<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["counter"]["Title"]; ?>" placeholder="計數器標題" data-toggle="tooltip" data-placement="top" title="計數器標題"	/>
								</div>
								
								<div class="form-group col-12 p-0">
									<div class="col-12">
										<label>Font Setting</label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontFamily" 	name="input[Setting][Font-Family]" 	value="<?=(isset($data["counter"]["Setting"]["Font-Family"])) 	? ($data["counter"]["Setting"]["Font-Family"]) 	: (""); ?>" placeholder="文字格式" data-toggle="tooltip" data-placement="top" title="文字格式" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontSize" 		name="input[Setting][Font-Size]" 		value="<?=(isset($data["counter"]["Setting"]["Font-Size"])) 		? ($data["counter"]["Setting"]["Font-Size"]) 		: (""); ?>"		placeholder="文字大小" data-toggle="tooltip" data-placement="top" title="文字大小" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Font-Color]" 	value="<?=(isset($data["counter"]["Setting"]["Font-Color"])) 		? ($data["counter"]["Setting"]["Font-Color"]) 	: (""); ?>"	placeholder="文字顏色" data-toggle="tooltip" data-placement="top" title="文字顏色" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Font-Shadow]" 	value="<?=(isset($data["counter"]["Setting"]["Font-Shadow"])) 	? ($data["counter"]["Setting"]["Font-Shadow"]) 	: (""); ?>"	placeholder="文字陰影" data-toggle="tooltip" data-placement="top" title="文字陰影" />
										</div>
									</div>
									<div class="col-12">
										<label>Font Position</label>
									</div>
									<div class="d-flex">
										<div class="col-md-4">
											<input type="radio" id="inputContentLeft" name="input[Setting][Font-Content]" value="1" <?=(isset($data["counter"]["Setting"]["Font-Content"]) && ($data["counter"]["Setting"]["Font-Content"] == 1)) ? ("checked") : (""); ?> placeholder="文字位置(靠左)" data-toggle="tooltip" data-placement="top" title="文字位置(靠左)" />
											<label for="inputContentLeft">文字位置(靠左)</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="inputContentCent" name="input[Setting][Font-Content]" value="2" <?=(isset($data["counter"]["Setting"]["Font-Content"]) && ($data["counter"]["Setting"]["Font-Content"] == 2)) ? ("checked") : (""); ?> placeholder="文字位置(置中)" data-toggle="tooltip" data-placement="top" title="文字位置(置中)" />
											<label for="inputContentCent">文字位置(置中)</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="inputContentRigh" name="input[Setting][Font-Content]" value="3" <?=(isset($data["counter"]["Setting"]["Font-Content"]) && ($data["counter"]["Setting"]["Font-Content"] == 3)) ? ("checked") : (""); ?> placeholder="文字位置(靠右)" data-toggle="tooltip" data-placement="top" title="文字位置(靠右)" />
											<label for="inputContentRigh">文字位置(靠右)</label>
										</div>
									</div>
									<div class="d-flex">
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFontPosX" name="input[Setting][Font-Position][X]" value="<?=(isset($data["counter"]["Setting"]["Font-Position"]["X"])) ? ($data["counter"]["Setting"]["Font-Position"]["X"]) : (""); ?>" placeholder="文字位置(X)" data-toggle="tooltip" data-placement="top" title="文字位置(X)" />
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFontPosY" name="input[Setting][Font-Position][Y]" value="<?=(isset($data["counter"]["Setting"]["Font-Position"]["Y"])) ? ($data["counter"]["Setting"]["Font-Position"]["Y"]) : (""); ?>" placeholder="文字位置(Y)" data-toggle="tooltip" data-placement="top" title="文字位置(Y)" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-12 p-0">
									<div class="col-12">
										<label>Background </label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputBGColor" 		name="input[Setting][Background-Color]" 	value="<?=(isset($data["counter"]["Setting"]["Background-Color"])) 	? ($data["counter"]["Setting"]["Background-Color"]) 	: (""); ?>" placeholder="背景顏色" data-toggle="tooltip" data-placement="top" title="背景顏色" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputBGImg" 			name="input[Setting][Background-Img]" 		value="<?=(isset($data["counter"]["Setting"]["Background-Img"])) 		? ($data["counter"]["Setting"]["Background-Img"]) 		: (""); ?>"	placeholder="背景圖片" data-toggle="tooltip" data-placement="top" title="背景圖片" />
										</div>
										<div class="col-md-2 form-check form-check-inline">
											<input type="checkbox" 	class="btn-check form-check-input" 	 id="inputBoardTrans" 	name="input[Setting][Board-Transparent]" 	value="1" <?=(isset($data["counter"]["Setting"]["Board-Transparent"]) && ($data["counter"]["Setting"]["Board-Transparent"] == 1)) ? ("checked")	: (""); ?>	autocomplete="off"  />
											<label class="form-check-label" for="inputBoardTrans" >背景透明化</label>
										</div>
										<div class="col-md-2">
											<input type="text" class="form-control" id="inputBoardWidth" 	name="input[Setting][Board-Width]" 				value="<?=(isset($data["counter"]["Setting"]["Board-Width"])) 			? ($data["counter"]["Setting"]["Board-Width"]) 				: (""); ?>"	placeholder="背景寬度" data-toggle="tooltip" data-placement="top" title="背景寬度" />
										</div>
										<div class="col-md-2">
											<input type="text" class="form-control" id="inputBoardHeight" name="input[Setting][Board-Height]" 			value="<?=(isset($data["counter"]["Setting"]["Board-Height"])) 			? ($data["counter"]["Setting"]["Board-Height"]) 			: (""); ?>"	placeholder="背景高度" data-toggle="tooltip" data-placement="top" title="背景高度" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-md-8 col-sm-8">
									<label for="inputTitle">Target API Link <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="目標API的網址，從該處抓取資料"></i></label>
									<input type="text" class="form-control" id="inputTitle" name="input[Target_API]" value="<?=$data["counter"]["Target_API"]; ?>" placeholder="目標API" data-toggle="tooltip" data-placement="top" title="目標API"	/>
								</div>
								
								<div class="form-group col-4 p-0">
									<label for="inputTitle">Grab Frequency <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="向目標API抓取資料的頻率"></i></label>
									<input type="text" class="form-control" id="inputFontFamily" 	name="input[Grab_Frequency]" 	value="<?=$data["counter"]["Grab_Frequency"]; ?>" placeholder="抓取頻率，請輸入半形數字(0.1為1毫秒，建議2，0為不抓取)" data-toggle="tooltip" data-placement="top" title="抓取頻率，請輸入半形數字(0.1為1毫秒，建議2，0為不抓取)" />
								</div>
							</div>
							
							<div class="row col-12 border-bottom">
								
								<div class="form-group col-8 p-0">
									<div class="col-12">
										<label>Frequency Setting</label>
									</div>
									<div class="d-flex">
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFreqStart" 	name="input[Setting][Duration-Start]" 	value="<?=$data["counter"]["Setting"]["Duration-Start"]; ?>" 	placeholder="動畫起始變化速率，請輸入半形數字(0.1為1毫秒，建議0.2)" data-toggle="tooltip" data-placement="top" title="動畫起始變化速率，請輸入半形數字(0.1為1毫秒，建議0.2)" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFreqPer" 		name="input[Setting][Duration-Per]" 		value="<?=$data["counter"]["Setting"]["Duration-Per"]; ?>"		placeholder="動畫位數變化速率，請輸入半形數字(0.1為1毫秒，建議0.1)" data-toggle="tooltip" data-placement="top" title="動畫位數變化速率，請輸入半形數字(0.1為1毫秒，建議0.1)" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFreqMax" 		name="input[Setting][Duration-Max]" 		value="<?=$data["counter"]["Setting"]["Duration-Max"]; ?>"		placeholder="動畫最大變化速率，請輸入半形數字(0.1為1毫秒，建議1)" 	data-toggle="tooltip" data-placement="top" title="動畫最大變化速率，請輸入半形數字(0.1為1毫秒，建議1)" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-4 p-0">
									<div class="col-12">
										<label>Update Frequency <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="總更新頻率，每T秒重新抓取資料庫的數值，以更新到上限值，請輸入半形數字(0.1為1毫秒)"></i></label>
										<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Update-Frequency]" value="<?=$data["counter"]["Setting"]["Update-Frequency"]; ?>"	placeholder="更新頻率" data-toggle="tooltip" data-placement="top" title="更新頻率" />
									</div>
								</div>
								
								<div class="form-group col-8 p-0">
									<div class="col-12">
										<label>Jumping Frequency per times (M/N)<i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="跳動頻率，每N秒更新一次，M秒內更新到上限(建議M不要超過總更新頻率)"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFreqNsec" 	name="input[Setting][Duration-Nsec]" 	value="<?=$data["counter"]["Setting"]["Duration-Nsec"]; ?>" 	placeholder="跳動頻率，N秒" 	data-toggle="tooltip" data-placement="top" title="跳動頻率，每N秒跳動一次，請輸入半形數字(0.1為1毫秒，建議1)" />
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFreqMsec" 	name="input[Setting][Duration-Msec]" 	value="<?=$data["counter"]["Setting"]["Duration-Msec"]; ?>"		placeholder="跳動頻率，M秒" 	data-toggle="tooltip" data-placement="top" title="跳動頻率，M秒內要更新到最新數值，請輸入半形數字(0.1為1毫秒，建議不要超過總更新頻率)" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-6 p-0">
									<div class="col-12">
										<label>Padding <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="文字留白，單位為px"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingTop" 			name="input[Setting][Set-Padding][]" 	value="<?=$data["counter"]["Setting"]["Set-Padding"][0]; ?>" 	placeholder="文字留白(上方)" data-toggle="tooltip" data-placement="top" title="文字留白(上方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingLeft" 		name="input[Setting][Set-Padding][]" 	value="<?=$data["counter"]["Setting"]["Set-Padding"][1]; ?>"	placeholder="文字留白(左側)" data-toggle="tooltip" data-placement="top" title="文字留白(左側)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingButton" 	name="input[Setting][Set-Padding][]" 	value="<?=$data["counter"]["Setting"]["Set-Padding"][2]; ?>"	placeholder="文字留白(下方)" data-toggle="tooltip" data-placement="top" title="文字留白(下方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingRght" 		name="input[Setting][Set-Padding][]" 	value="<?=$data["counter"]["Setting"]["Set-Padding"][3]; ?>"	placeholder="文字留白(右側)" data-toggle="tooltip" data-placement="top" title="文字留白(右側)" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-6 p-0">
									<div class="col-12">
										<label>Margin <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="文字間距，單位為px"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginTop" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["counter"]["Setting"]["Set-Margin"][0]; ?>" 	placeholder="文字間距(上方)" data-toggle="tooltip" data-placement="top" title="文字間距(上方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginLeft" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["counter"]["Setting"]["Set-Margin"][1]; ?>"		placeholder="文字間距(左側)" data-toggle="tooltip" data-placement="top" title="文字間距(左側)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginButton" 	name="input[Setting][Set-Margin][]" 	value="<?=$data["counter"]["Setting"]["Set-Margin"][2]; ?>"		placeholder="文字間距(下方)" data-toggle="tooltip" data-placement="top" title="文字間距(下方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginRght" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["counter"]["Setting"]["Set-Margin"][3]; ?>"		placeholder="文字間距(右側)" data-toggle="tooltip" data-placement="top" title="文字間距(右側)" />
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-row justify-content-end mt-2">
							<button type="button" class="btn btn-primary ml-1" 		onclick="ajax_sendCounterData()" 						>Submit</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_resetData()" 										>Reset</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_JumpCounter('<?=$countCode;?>')" >Show Board</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>

<style type="text/css">
	.bgImg, .colImg {
		width: 50px;
		text-align: center;
	}
	.ruleImg {
		width: 20px;
		text-align: center;
	}
	.playerImg {
		width: 50px;
		text-align: center;
	}
</style>
<script><?php include_once("./tools/js/js_counter_controlTools.php"); ?></script>