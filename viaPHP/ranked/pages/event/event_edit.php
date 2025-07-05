<?php
	//echo json_encode( array("Loc" => "./img/rat.png", "Width" => "50px", "Height" => "50px",) ); exit();
	$data = array();
	$eventCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");				//$eventNo = 'E000001';	$eventCode = 'voK2xX';
	
	$data["event"] 		= fun_getEventData(array("Code" => $eventCode) );	//獲取活動資料
	$data["rules"] 		= fun_getEventRuleData($data["event"]["ID"]);			//獲取活動排序規則
	$data["players"] 	= fun_getEventPlayerData($data["event"]["ID"]);		//獲取活動玩家資訊
	
	//print_r($data["players"]);	//exit();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Event</h1>
</div>


<!-- Content Row -->
<div class="row">
	<div class="col-xl-12 col-lg-12">
		<!--標籤列-->
		<div>
			<ul id="nav_bar" class="nav nav-tabs">
				<li class="nav-item">
					<a id="tab_events" class="nav_tab nav-link active" href="javaScript:js_chgNavTab('events');">Setting</a>
				</li>
				<li class="nav-item">
					<a id="tab_rules" class="nav_tab nav-link" href="javaScript:js_chgNavTab('rules');">Rules</a>
				</li>
				<li class="nav-item">
					<a id="tab_players" class="nav_tab nav-link" href="javaScript:js_chgNavTab('players');">Players</a>
				</li>
			</ul>
		</div>
		
		<div id="page_edit" class="card shadow mb-4">			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div class="div_edit form-row" id = "div_events">
							<!-- Card Header - Dropdown -->
							<div class="card-header d-flex justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Event Setting</h6>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-md-3">
									<label for="inputNo">Event No <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="活動編號，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?=$data["event"]["No"]; ?>" placeholder="(系統生成)" disabled />
									<input type="hidden" class="input_ID" 	name="input[ID]" 		value = "<?=$data["event"]["ID"]; ?>" 	/>
									<input type="hidden" class="input_No" 	name="input[No]" 		value = "<?=$data["event"]["No"]; ?>" 	/>
									<input type="hidden" class="input_Code" name="input[Code]" 	value = "<?=$data["event"]["Code"]; ?>" />
								</div>
								<div class="form-group col-md-3">
									<label for="inputCode">Event Code <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="活動獨特碼，系統生成，用以產生相關連結"></i></label>
									<input type="text" class="form-control" id="inputCode" name="input[Code]" value="<?=$data["event"]["Code"]; ?>" placeholder="(系統生成)" disabled />
								</div>
								<div class="form-group col-md-6 col-sm-6">
									<label for="inputTitle">Event Title</label>
									<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["event"]["Title"]; ?>" placeholder="活動標題" data-toggle="tooltip" data-placement="top" title="活動標題"	/>
								</div>
								
								<div class="form-group col-8 p-0">
									<div class="col-12">
										<label">Font Setting</label>
									</div>
									<div class="d-flex">
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFontFamily" 	name="input[Setting][Font-Family]" 	value="<?=$data["event"]["Setting"]["Font-Family"]; ?>" placeholder="文字格式" data-toggle="tooltip" data-placement="top" title="文字格式" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFontSize" 		name="input[Setting][Font-Size]" 		value="<?=$data["event"]["Setting"]["Font-Size"]; ?>"		placeholder="文字大小" data-toggle="tooltip" data-placement="top" title="文字大小" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Font-Color]" 	value="<?=$data["event"]["Setting"]["Font-Color"]; ?>"	placeholder="文字顏色" data-toggle="tooltip" data-placement="top" title="文字顏色" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-4 p-0">
									<div class="col-12">
										<label">Update Frequency <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="更新頻率，請輸入半形數字(0.1為1毫秒)"></i></label>
										<input type="text" class="form-control" id="inputFontColor" 	name="input[Setting][Update-Frequency]" value="<?=$data["event"]["Setting"]["Update-Frequency"]; ?>"	placeholder="更新頻率" data-toggle="tooltip" data-placement="top" title="更新頻率" />
									</div>
								</div>
							</div>
							
							<div class="row col-12 border-bottom">
								<div class="form-group col-md-6 col-sm-6">
									<input type="hidden" class="form-control ipt_bgChoose" name="input[BG][Sel]" value="<?=$data["event"]["BG"]["Sel"]; ?>" />
									<div id="div_setBGImg" class="div_setbg <?=($data["event"]["BG"]["Sel"] == "0") ? ("d-none") : (""); ?>">
										<label for="inputBGImg">BG Image Loc</label>
										<img class="bgImg" src="<?=$data["event"]["BG"]["Loc"]; ?>" alt="<?=$data["event"]["Title"]; ?>">
										<div class="input-group">
											<input type="text" class="form-control ipt_Img" id="inputBGImg" name="input[BG][Loc]" value="<?=$data["event"]["BG"]["Loc"]; ?>" placeholder="背景圖片" data-toggle="tooltip" data-placement="top" title="背景圖片" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_uploadPic(this, 'Event')" type="button" data-toggle="tooltip" data-placement="top" title="上傳圖片"><i class="fas fa-image"></i></button>
												<button class="btn btn-outline-secondary" onclick="js_chgBGShow(this, 'BGCol')" type="button" data-toggle="tooltip" data-placement="top" title="更換成背景顏色"><i class="fas fa-exchange-alt"></i></button>
											</div>
										</div>
									</div>
									<div id="div_setBGCol" class="div_setbg <?=($data["event"]["BG"]["Sel"] == "1") ? ("d-none") : (""); ?>">
										<label for="inputBGCol">Background BG Color</label>
										<div class="input-group">
											<input type="text" class="form-control ipt_Col" id="inputBGCol" name="input[BG][Col]" value="<?=$data["event"]["BG"]["Col"]; ?>" placeholder="背景顏色" data-toggle="tooltip" data-placement="top" title="背景顏色" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_chgBGShow(this, 'BGImg')" type="button" data-toggle="tooltip" data-placement="top" title="更換成背景圖片"><i class="fas fa-exchange-alt"></i></button>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group d-flex col-6 p-0">
									<div class="col-md-6 col-sm-6">
										<label for="inputBGWidth">Width Size</label>
										<input type="text" class="form-control" id="inputBGWidth" name="input[Img][Width]" value="<?=$data["event"]["Img"]["Width"]; ?>" placeholder="背景圖片寬度" data-toggle="tooltip" data-placement="top" title="背景圖片寬度" />
									</div>
									<div class="col-md-6 col-sm-6">
										<label for="inputBGHeigh">Height Size</label>
										<input type="text" class="form-control" id="inputBGHeigh" name="input[Img][Height]" value="<?=$data["event"]["Img"]["Height"]; ?>" placeholder="背景圖片高度" data-toggle="tooltip" data-placement="top" title="背景圖片高度" />
									</div>
								</div>
							</div>
							
							<div class="row col-12 border-bottom ">
								<div class="form-group col-md-6 col-sm-6">
									<input type="hidden" class="form-control ipt_bgChoose" name="input[Img][Sel]" value="<?=$data["event"]["Img"]["Sel"]; ?>" />
									<div id="div_setColImg" class="div_setbg <?=($data["event"]["Img"]["Sel"] == "0") ? ("d-none") : (""); ?>">
										<label for="inputColImg">Player BG Image Loc <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="欄位背景圖片網址"></i></label>
										<img class="colImg" src="<?=$data["event"]["Img"]["Loc"]; ?>" alt="<?=$data["event"]["Title"]; ?>">
										<div class="input-group">
											<input type="text" class="form-control ipt_Img" id="inputColImg" name="input[Img][Loc]" value="<?=$data["event"]["Img"]["Loc"]; ?>" placeholder="背景圖片" data-toggle="tooltip" data-placement="top" title="背景圖片" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_uploadPic(this, 'Event')" type="button" data-toggle="tooltip" data-placement="top" title="上傳圖片"><i class="fas fa-image"></i></button>
												<button class="btn btn-outline-secondary" onclick="js_chgBGShow(this, 'ColCol')" type="button" data-toggle="tooltip" data-placement="top" title="更換成背景顏色"><i class="fas fa-exchange-alt"></i></button>
											</div>
										</div>
									</div>
									<div id="div_setColCol" class="div_setbg <?=($data["event"]["Img"]["Sel"] == "1") ? ("d-none") : (""); ?>">
										<label for="inputColCol">Player BG Color <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="欄位背景顏色"></i></label>
										<div class="input-group">
											<input type="text" class="form-control ipt_Col" id="inputColCol" name="input[Img][Col]" value="<?=$data["event"]["Img"]["Col"]; ?>" placeholder="背景顏色" data-toggle="tooltip" data-placement="top" title="背景顏色" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_chgBGShow(this, 'ColImg')" type="button" data-toggle="tooltip" data-placement="top" title="更換成背景圖片"><i class="fas fa-exchange-alt"></i></button>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group col-6 p-0">
									<div class="col-12">
										<label>Column Setting<small>(Width x Height)</small> <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="總欄位寬度 x 每列欄位高度"></i></label>
									</div>
									<div class="d-flex">
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputColWidth" 	name="input[Setting][Col-Width]" 	value="<?=$data["event"]["Setting"]["Col-Width"]; ?>"		placeholder="欄位寬度" data-toggle="tooltip" data-placement="top" title="欄位寬度" />
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputColHeight" name="input[Setting][Col-Height]" value="<?=$data["event"]["Setting"]["Col-Height"]; ?>" 	placeholder="欄位高度" data-toggle="tooltip" data-placement="top" title="欄位高度" />
										</div>
									</div>
								</div>
								
								<div class="form-group col-md-12 mb-0">
									<label class="mb-0">Every Column's Width Setting <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="總欄位寬度 = 排名數字的欄位寬度 + 玩家名稱欄位寬度 + (總)規則欄位寬度"></i></label>
									<label><em><small>(Rank Width + Name Width + (Total) Rule Width = Column Width)</small></em></label>
								</div>
								
								<div class="form-group col-md-4">
									<label>排名欄位寬度 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="排名數字的欄位寬度"></i></label>
									<input type="text" class="form-control" id="inputRankWidth" name="input[Setting][Rank-Width]" value="<?=$data["event"]["Setting"]["Rank-Width"]; ?>" placeholder="排名欄位寬度" 		data-toggle="tooltip" data-placement="top" title="排名欄位寬度" />
								</div>
								
								<div class="form-group col-md-4">
									<label>玩家名稱欄位寬度 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="玩家名稱部分的欄位寬度"></i></label>
									<input type="text" class="form-control" id="inputNameWidth" name="input[Setting][Name-Width]" value="<?=$data["event"]["Setting"]["Name-Width"]; ?>" placeholder="玩家名稱欄位寬度" data-toggle="tooltip" data-placement="top" title="玩家名稱欄位寬度" />
								</div>
								
								<div class="form-group col-md-4">
									<label>各別規則欄位寬度 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="每項規則各自的欄位寬度(總寬度為規則數量 x 設定的寬度)"></i></label>
									<input type="text" class="form-control" id="inputRuleWidth" name="input[Setting][Rule-Width]" value="<?=$data["event"]["Setting"]["Rule-Width"]; ?>" placeholder="各別規則欄位寬度" data-toggle="tooltip" data-placement="top" title="各別規則欄位寬度" />
								</div>
							</div>
						</div>
						
						<div class="div_edit form-row d-none" id = "div_rules">
							<!-- Card Header - Dropdown -->
							<div class="card-header d-flex justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Ranked Rule</h6>
								<div class="dropdown no-arrow">
									<button type="button" onclick="js_addRuleColumn()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Rule
									</button>
								</div>
							</div>
							
							<div class="form-group col-md-4">
								<label>Show Table Title <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="是否顯示標頭？"></i></label>
								<input type="hidden" class="form-control ipt_Status" name="input[Setting][ShowTitle]" value = "<?=$data["event"]["Setting"]["ShowTitle"]; ?>">
								<div class="btn-group" role="group" aria-label="Status Buttons">
									<button type="button" onclick="js_setStatus(this, 1)" class="btn <?=($data["event"]["Setting"]["ShowTitle"] == "1") ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_1">Yes</button>
									<button type="button" onclick="js_setStatus(this, 0)" class="btn <?=($data["event"]["Setting"]["ShowTitle"] == "0") ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_0">No</button>
								</div>
							</div>
						
							<?php 
								foreach($data["rules"] AS $Key => $Values) :
							?>
							<div class="row align-items-center col-md-12 border-bottom mt-2 ml-1">
								<div class="row col-md-12">
									<div class="form-group col-md-3 col-sm-3">
										<label>Rule</label>
										<input type="hidden" 	class="form-control" name="input[RankRule][ID][]" 	value="<?=$Values["Rule_ID"]; ?>" placeholder="RuleTag ID">
										<input type="text" 		class="form-control" name="input[RankRule][Tag][]" 	value="<?=$Values["Tag"]; ?>" 		placeholder="排序標籤" 			data-toggle="tooltip" data-placement="top" title="排序標籤，請以英文標註">
									</div>
									<div class="form-group col-md-2 col-sm-2">
										<label>Order <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="排序用的順序，請填入半形數字"></i></label>
										<input type="text" class="form-control" name="input[RankRule][Order][]" value="<?=$Values["Order"]; ?>" 		placeholder="檢查順序" 			data-toggle="tooltip" data-placement="top" title="檢查順序(請填入半形阿拉伯數字)" >
									</div>
									<div class="form-group col-md-2 col-sm-2">
										<label>Default <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="預設的起始數值，請填入半形數字"></i></label>
										<input type="text" class="form-control" name="input[RankRule][Default][]" value="<?=$Values["Default"]; ?>" placeholder="預設起始數值" 	data-toggle="tooltip" data-placement="top" title="預設起始數值" >
									</div>
									<div class="form-group col-md-2 col-sm-2">
										<label>Asc <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="昇冪/降冪排序，0.昇冪/1.降冪"></i></label>
										<input type="text" class="form-control" name="input[RankRule][Asc][]" 	value="<?=$Values["Asc"]; ?>" 			placeholder="0.昇冪/1.降冪" data-toggle="tooltip" data-placement="top" title="0.昇冪/1.降冪" >
									</div>
									<div class="form-group col-md-3 col-sm-3">
										<label>Status</label>
										<input type="hidden" class="form-control ipt_Status" name="input[RankRule][Status][]" value="<?=$Values["Status"]; ?>" placeholder="狀態設置">
										<div class="btn-group" role="group" aria-label="Status Buttons">
											<button type="button" onclick="js_setStatus(this, 1)" 	class="btn <?=($Values["Status"] == "1"  ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_1" 				data-toggle="tooltip" data-placement="top" title="Enabled"	><i class="fas fa-tint"></i></button>
											<button type="button" onclick="js_setStatus(this, 0)" 	class="btn <?=($Values["Status"] == "0"  ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_0" 				data-toggle="tooltip" data-placement="top" title="Disabled"	><i class="fas fa-tint-slash"></i></button>
											<button type="button" onclick="js_setStatus(this, -1)" 	class="btn <?=($Values["Status"] == "-1" ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_-1 ml-1" 	data-toggle="tooltip" data-placement="top" title="Delete"		><i class="fas fa-trash-alt"></i></button>
										</div>
									</div>
								</div>
								<div class="row col-md-12">
									<div class="form-group col-md-6">
										<label>Image Loc <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="完整的圖片網址"></i></label>
										<img class="ruleImg" src="<?=$Values["Img"]["Loc"]; ?>" alt="<?=$Values["Tag"]; ?>">
										<div class="input-group">
											<input type="text" class="form-control ipt_Img" name="input[RankRule][Img][Loc][]" 		value = "<?=$Values["Img"]["Loc"]; ?>" 		placeholder="圖片位址" 			data-toggle="tooltip" data-placement="top" title="圖片位址" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_uploadPic(this, 'Rule')" type="button" data-toggle="tooltip" data-placement="top" title="上傳圖片"><i class="fas fa-image"></i></button>
											</div>
										</div>
									</div>
									<div class="form-group col-md-3 row">
										<label>Width x Heigh</label>
										<input type="text" class="form-control col-6 col-sm-3" name="input[RankRule][Img][Width][]" 	value="<?=$Values["Img"]["Width"]; ?>" 	placeholder="圖片寬度" data-toggle="tooltip" data-placement="top" title="圖片寬度">
										<input type="text" class="form-control col-6 col-sm-3" name="input[RankRule][Img][Height][]" 	value="<?=$Values["Img"]["Height"]; ?>" placeholder="圖片高度" data-toggle="tooltip" data-placement="top" title="圖片高度">
									</div>
									<div class="form-group col-md-3 row ml-2">
										<label>Left x Top <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="圖片左側 x 上方 留白，請填入半形數字"></i></label>
										<input type="text" class="form-control col-6 col-sm-3" name="input[RankRule][Img][Left][]" 		value="<?=$Values["Img"]["Left"]; ?>" 	placeholder="圖片左側間隔" data-toggle="tooltip" data-placement="top" title="圖片左側間隔">
										<input type="text" class="form-control col-6 col-sm-3" name="input[RankRule][Img][Top][]" 		value="<?=$Values["Img"]["Top"]; ?>" 		placeholder="圖片頂側間隔" data-toggle="tooltip" data-placement="top" title="圖片頂側間隔">
									</div>
								</div>
							</div>
							<?php
								endforeach;
							?>
							
						</div>
						
						<div class="div_edit form-row d-none" id = "div_players">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Player</h6>
								<div class="dropdown no-arrow">
									<button type="button" onclick="js_addPlayerColumn()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Player
									</button>
								</div>
							</div>
							
							<?php 
								foreach($data["players"] AS $player_Key => $player_Value) :
							?>
							<div class="row align-items-center col-md-12 border-bottom mt-2 ml-1">
								<div class="row col-md-12">
									<div class="form-group col-md-9 col-sm-9">
										<label>Player <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="要展示的玩家名稱"></i></label>
										<input type="text" class="form-control" name="input[Player][Name][]" value = "<?=$player_Value["Name"]; ?>" placeholder="玩家稱謂" data-toggle="tooltip" data-placement="top" title="玩家稱謂" />
										<input type="hidden" name="input[Player][Ranked_ID][]" 	value="<?=$player_Value["Ranked_ID"]; ?>" />
										<input type="hidden" name="input[Player][ID][]" 				value="<?=$player_Value["ID"]; ?>" 				/>
									</div>
									<div class="form-group col-md-3 col-sm-3">
										<label>Status</label>         
										<input type="hidden" class="form-control ipt_Status" name="input[Player][Status][]" value="<?=$player_Value["Ranked_Status"]; ?>" placeholder="狀態設置"></br>
										<div class="btn-group" role="group" aria-label="Status Buttons">
											<button type="button" onclick="js_setStatus(this, 1)" 	class="btn <?=( $player_Value["Ranked_Status"] == "1"  ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_1" 				data-toggle="tooltip" data-placement="top" title="Enabled"	><i class="fas fa-tint"></i>			</button>
											<button type="button" onclick="js_setStatus(this, 0)" 	class="btn <?=( $player_Value["Ranked_Status"] == "0"  ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_0" 				data-toggle="tooltip" data-placement="top" title="Disabled"	><i class="fas fa-tint-slash"></i></button>
											<button type="button" onclick="js_setStatus(this, -1)" 	class="btn <?=( $player_Value["Ranked_Status"] == "-1" ) ? ("btn-primary") : ("btn-secondary"); ?> btnStatus_-1 ml-1" 	data-toggle="tooltip" data-placement="top" title="Delete"		><i class="fas fa-trash-alt"></i>	</button>
										</div>
									</div>
								</div>
								<div class="row col-md-12">
									<div class="form-group col-md-6">
										<label>Image Loc <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="完整的圖片網址"></i></label>
										<img class="playerImg" src="<?=$player_Value["Image"]["Loc"]; ?>" alt="<?=$player_Value["Name"]; ?>">
										<div class="input-group">
											<input type="text" class="form-control ipt_Img" name="input[Player][Img][Loc][]" 		value = "<?=$player_Value["Image"]["Loc"]; ?>" 		placeholder="圖片位址" 			data-toggle="tooltip" data-placement="top" title="圖片位址" />
											<div class="input-group-append">
												<button class="btn btn-outline-secondary" onclick="js_uploadPic(this, 'Player')" type="button" data-toggle="tooltip" data-placement="top" title="上傳圖片"><i class="fas fa-image"></i></button>
											</div>
										</div>
									</div>
									<div class="form-group col-md-3 row">
										<label>Width x Heigh <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="圖片寬度 x 高度，請填入半形數字"></i></label>
										<input type="text" class="form-control col-6 col-sm-6" name="input[Player][Img][Width][]" 	value="<?=$player_Value["Image"]["Width"]; ?>" 	placeholder="圖片寬度" data-toggle="tooltip" data-placement="top" title="圖片寬度">
										<input type="text" class="form-control col-6 col-sm-6" name="input[Player][Img][Height][]" 	value="<?=$player_Value["Image"]["Height"]; ?>" placeholder="圖片高度" data-toggle="tooltip" data-placement="top" title="圖片高度">
									</div>
									<div class="form-group col-md-3 row ml-2">
										<label>Left x Top <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="圖片左側 x 上方 留白，請填入半形數字"></i></label>
										<input type="text" class="form-control col-6 col-sm-6" name="input[Player][Img][Left][]" 		value="<?=$player_Value["Image"]["Left"]; ?>" 	placeholder="圖片左側留白" data-toggle="tooltip" data-placement="top" title="圖片左側留白">
										<input type="text" class="form-control col-6 col-sm-6" name="input[Player][Img][Top][]" 		value="<?=$player_Value["Image"]["Top"]; ?>" 		placeholder="圖片上方留白" data-toggle="tooltip" data-placement="top" title="圖片上方留白">
									</div>
								</div>
							</div>
							<?php 
								endforeach;
							?>
						</div>
						
						<div class="form-row justify-content-end mt-2">
							<button type="button" class="btn btn-primary ml-1" 		onclick="ajax_sendEventData()" 							>Submit</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_resetData()" 										>Reset</button>
							<button type="button" class="btn btn-secondary ml-1" 	onclick="js_ScoreBoard('<?=$eventCode;?>')" >Show Board</button>
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
<script><?php include_once("./tools/js/js_rank_controlTools.php"); ?></script>