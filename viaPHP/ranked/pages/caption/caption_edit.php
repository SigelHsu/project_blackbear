<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$captionCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");					//$captionNo = 'S000001';	$captionCode = 'voK2xX';
	
	$data["caption"] 	= fun_getCaptionData(array("Code" => $captionCode) );	//獲取活動資料		//print_r($data);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Caption</h1>
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
								<h6 class="m-0 font-weight-bold text-primary">Caption Setting</h6>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-md-3">
									<label for="inputNo">Caption No <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="字幕組編號，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?=$data["caption"]["No"]; ?>" placeholder="(系統生成)" disabled />
									<input type="hidden" class="input_ID" 	name="input[ID]" 		value = "<?=$data["caption"]["ID"]; ?>" 	/>
									<input type="hidden" class="input_No" 	name="input[No]" 		value = "<?=$data["caption"]["No"]; ?>" 	/>
									<input type="hidden" class="input_Code" name="input[Code]" 	value = "<?=$data["caption"]["Code"]; ?>" />
								</div>
								
								<div class="form-group col-md-3">
									<label for="inputCode">Caption Code <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="字幕組獨特碼，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputCode" name="input[Code]" value="<?=$data["caption"]["Code"]; ?>" placeholder="(系統生成)" disabled />
								</div>
								
								<div class="form-group col-md-6 col-sm-6">
									<label for="inputTitle">Caption Title</label>
									<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["caption"]["Title"]; ?>" placeholder="字幕組標題" data-toggle="tooltip" data-placement="top" title="計數器標題"	/>
								</div>
								
								<div class="form-group row col-6 pl-3">
									<div class="col-6">
										<label>Update Frequency <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="總更新頻率，每T秒重新抓取資料庫的數值，請輸入半形數字(0.1為1毫秒)"></i></label>
										<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Update-Frequency]" value="<?=$data["caption"]["Setting"]["Update-Frequency"]; ?>"	placeholder="更新頻率" data-toggle="tooltip" data-placement="top" title="更新頻率" />
									</div>
									
									<div class="col-6 d-none">
										<label>MAX Line <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="每次顯示的句數上限，請輸入半形數字，不輸入時無限制"></i></label>
										<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Max-Line]" value="<?=$data["caption"]["Setting"]["Max-Line"]; ?>"	placeholder="句數上限" data-toggle="tooltip" data-placement="top" title="句數上限" />
									</div>
								</div>
								
								<div class="form-group row col-6 pl-3 ml-2">
									<div class="col-6">
										<label>Keep Data <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="是否保留過往已發佈句子？"></i></label>
										<div class="row pl-2 pt-2">
											<div class="form-check ml-2">
												<input class="form-check-input" type="radio" name="input[Setting][Keep-Histroy]" value = "0" id="set_KeepHistroy_n" <?=( $data["caption"]["Setting"]["Keep-Histroy"] == 0 ) ? ("checked") : (""); ?> />
												<label class="form-check-label" for="set_KeepHistroy_n">
													否, 不保留
												</label>
											</div>
											<div class="form-check ml-2">
												<input class="form-check-input" type="radio" name="input[Setting][Keep-Histroy]" value = "1" id="set_KeepHistroy_y" <?=( $data["caption"]["Setting"]["Keep-Histroy"] == 1 ) ? ("checked") : (""); ?> />
												<label class="form-check-label" for="set_KeepHistroy_y">
													Yes, 保留
												</label>
											</div>
										</div>
									</div>
									
									<div class="col-6">
										<label>When Refresh <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="當網頁重新整理時，如何顯示？"></i></label>
										<div class="row pl-2 pt-2">
											<div class="form-check ml-2">
												<input class="form-check-input" type="radio" name="input[Setting][When-Refresh]" value = "0" id="set_WhenRefresh_0" <?=( $data["caption"]["Setting"]["When-Refresh"] == 0 ) ? ("checked") : (""); ?> />
												<label class="form-check-label" for="set_WhenRefresh_0">
													空白頁面
												</label>
											</div>
											<div class="form-check ml-2">
												<input class="form-check-input" type="radio" name="input[Setting][When-Refresh]" value = "4" id="set_WhenRefresh_4" <?=( $data["caption"]["Setting"]["When-Refresh"] == 4 ) ? ("checked") : (""); ?> />
												<label class="form-check-label" for="set_WhenRefresh_4">
													最新一句
												</label>
											</div>
											<div class="form-check ml-2">
												<input class="form-check-input" type="radio" name="input[Setting][When-Refresh]" value = "2" id="set_WhenRefresh_2" <?=( $data["caption"]["Setting"]["When-Refresh"] == 2 ) ? ("checked") : (""); ?> />
												<label class="form-check-label" for="set_WhenRefresh_2">
													全部句子
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!--# Text-Box Background -->
							<div class="row col-12 border-bottom">
								<div class="form-group col-12 p-0">
									<div class="col-12">
										<input type="hidden" class="form-control ipt_bgChoose" name="input[Setting][Background-Sel]" value="<?=(isset($data["caption"]["Setting"]["Background-Sel"])) ? ($data["caption"]["Setting"]["Background-Sel"]) : (0); ?>" />
										<label>文字框背景</label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" 			class="form-control" id="inputBGColor" 			name="input[Setting][Background-Color]" 	value="<?=(isset($data["caption"]["Setting"]["Background-Color"])) 	? ($data["caption"]["Setting"]["Background-Color"]) 	: (""); ?>" placeholder="文字框背景顏色" data-toggle="tooltip" data-placement="top" title="文字框背景顏色" />
										</div>
										<div class="col-md-3">
											<input type="text" 			class="form-control" id="inputBGImg" 				name="input[Setting][Background-Img]" 		value="<?=(isset($data["caption"]["Setting"]["Background-Img"])) 		? ($data["caption"]["Setting"]["Background-Img"]) 		: (""); ?>"	placeholder="文字框背景圖片" data-toggle="tooltip" data-placement="top" title="文字框背景圖片" />
										</div>
										<div class="col-md-2 form-check form-check-inline">
											<input type="checkbox" 	class="btn-check form-check-input" 	 id="inputBoardTrans" 	name="input[Setting][Board-Transparent]" 	value="1" <?=(isset($data["caption"]["Setting"]["Board-Transparent"]) && ($data["caption"]["Setting"]["Board-Transparent"] == 1)) ? ("checked")	: (""); ?>	autocomplete="off"  />
											<label class="form-check-label" for="inputBoardTrans" >文字框背景透明化</label>
										</div>
										<div class="col-md-2">
											<input type="text" 			class="form-control" id="inputBoardWidth" 	name="input[Setting][Board-Width]" 				value="<?=(isset($data["caption"]["Setting"]["Board-Width"])) 			? ($data["caption"]["Setting"]["Board-Width"]) 				: (""); ?>"	placeholder="文字框背景寬度" data-toggle="tooltip" data-placement="top" title="文字框背景寬度" />
										</div>
										<div class="col-md-2">
											<input type="text" 			class="form-control" id="inputBoardHeight" 	name="input[Setting][Board-Height]" 			value="<?=(isset($data["caption"]["Setting"]["Board-Height"])) 			? ($data["caption"]["Setting"]["Board-Height"]) 			: (""); ?>"	placeholder="文字框背景高度" data-toggle="tooltip" data-placement="top" title="文字框背景高度" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-6 p-0">
									<div class="col-12">
										<label>Padding <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="字串留白，單位為px"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingTop" 			name="input[Setting][Set-Padding][]" 	value="<?=$data["caption"]["Setting"]["Set-Padding"][0]; ?>" 	placeholder="字串留白(上方)" data-toggle="tooltip" data-placement="top" title="字串留白(上方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingLeft" 		name="input[Setting][Set-Padding][]" 	value="<?=$data["caption"]["Setting"]["Set-Padding"][1]; ?>"	placeholder="字串留白(左側)" data-toggle="tooltip" data-placement="top" title="字串留白(左側)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingButton" 	name="input[Setting][Set-Padding][]" 	value="<?=$data["caption"]["Setting"]["Set-Padding"][2]; ?>"	placeholder="字串留白(下方)" data-toggle="tooltip" data-placement="top" title="字串留白(下方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputPaddingRght" 		name="input[Setting][Set-Padding][]" 	value="<?=$data["caption"]["Setting"]["Set-Padding"][3]; ?>"	placeholder="字串留白(右側)" data-toggle="tooltip" data-placement="top" title="字串留白(右側)" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-6 p-0">
									<div class="col-12">
										<label>Margin <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="文字間距，單位為px"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginTop" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["caption"]["Setting"]["Set-Margin"][0]; ?>" 	placeholder="字串間距(上方)" data-toggle="tooltip" data-placement="top" title="字串間距(上方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginLeft" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["caption"]["Setting"]["Set-Margin"][1]; ?>"		placeholder="字串間距(左側)" data-toggle="tooltip" data-placement="top" title="字串間距(左側)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginButton" 	name="input[Setting][Set-Margin][]" 	value="<?=$data["caption"]["Setting"]["Set-Margin"][2]; ?>"		placeholder="字串間距(下方)" data-toggle="tooltip" data-placement="top" title="字串間距(下方)" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputMarginRght" 		name="input[Setting][Set-Margin][]" 	value="<?=$data["caption"]["Setting"]["Set-Margin"][3]; ?>"		placeholder="字串間距(右側)" data-toggle="tooltip" data-placement="top" title="字串間距(右側)" />
										</div>
									</div>
								</div>
							</div>
							
							<!--# Font-Setting -->
							<div class="row col-12 border-bottom">
								<div class="form-group col-12 p-0">
									<div class="col-12">
										<label>Font Setting</label>
									</div>
									<div class="d-flex">
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontFamily" 	name="input[Setting][Font-Family]" 	value="<?=(isset($data["caption"]["Setting"]["Font-Family"])) 	? ($data["caption"]["Setting"]["Font-Family"]) 	: (""); ?>" placeholder="文字格式" data-toggle="tooltip" data-placement="top" title="文字格式" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontSize" 		name="input[Setting][Font-Size]" 		value="<?=(isset($data["caption"]["Setting"]["Font-Size"])) 		? ($data["caption"]["Setting"]["Font-Size"]) 		: (""); ?>"		placeholder="文字大小" data-toggle="tooltip" data-placement="top" title="文字大小" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Font-Color]" 	value="<?=(isset($data["caption"]["Setting"]["Font-Color"])) 		? ($data["caption"]["Setting"]["Font-Color"]) 	: (""); ?>"	placeholder="文字顏色" data-toggle="tooltip" data-placement="top" title="文字顏色" />
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Font-Shadow]" 	value="<?=(isset($data["caption"]["Setting"]["Font-Shadow"])) 	? ($data["caption"]["Setting"]["Font-Shadow"]) 	: (""); ?>"	placeholder="文字陰影" data-toggle="tooltip" data-placement="top" title="文字陰影" />
										</div>
									</div>
									<div class="col-12">
										<label>Font Position</label>
									</div>
									<div class="d-flex">
										<div class="col-md-4">
											<input type="radio" id="inputContentLeft" name="input[Setting][Font-Content]" value="1" <?=(isset($data["caption"]["Setting"]["Font-Content"]) && ($data["caption"]["Setting"]["Font-Content"] == 1)) ? ("checked") : (""); ?> placeholder="文字位置(靠左)" data-toggle="tooltip" data-placement="top" title="文字位置(靠左)" />
											<label for="inputContentLeft">文字位置(靠左)</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="inputContentCent" name="input[Setting][Font-Content]" value="2" <?=(isset($data["caption"]["Setting"]["Font-Content"]) && ($data["caption"]["Setting"]["Font-Content"] == 2)) ? ("checked") : (""); ?> placeholder="文字位置(置中)" data-toggle="tooltip" data-placement="top" title="文字位置(置中)" />
											<label for="inputContentCent">文字位置(置中)</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="inputContentRigh" name="input[Setting][Font-Content]" value="3" <?=(isset($data["caption"]["Setting"]["Font-Content"]) && ($data["caption"]["Setting"]["Font-Content"] == 3)) ? ("checked") : (""); ?> placeholder="文字位置(靠右)" data-toggle="tooltip" data-placement="top" title="文字位置(靠右)" />
											<label for="inputContentRigh">文字位置(靠右)</label>
										</div>
									</div>
									<div class="d-flex">
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFontPosX" name="input[Setting][Font-Position][X]" value="<?=(isset($data["caption"]["Setting"]["Font-Position"]["X"])) ? ($data["caption"]["Setting"]["Font-Position"]["X"]) : (""); ?>" placeholder="文字位置(X)" data-toggle="tooltip" data-placement="top" title="文字位置(X)" />
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputFontPosY" name="input[Setting][Font-Position][Y]" value="<?=(isset($data["caption"]["Setting"]["Font-Position"]["Y"])) ? ($data["caption"]["Setting"]["Font-Position"]["Y"]) : (""); ?>" placeholder="文字位置(Y)" data-toggle="tooltip" data-placement="top" title="文字位置(Y)" />
										</div>
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="form-row justify-content-end mt-2">
							<button type="button" class="btn btn-primary ml-1" 		onclick="ajax_sendCaptionData()" 								>Submit</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_resetData()" 												>Reset</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_showCaption('<?=$captionCode;?>')" 	>Show Board</button>
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
<script><?php include_once("./tools/js/js_caption_controlTools.php"); ?></script>