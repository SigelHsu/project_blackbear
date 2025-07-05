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
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Event Score Board</h6>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputNo">Event No</label>
								<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?=$data["event"]["No"]; ?>" placeholder="No" disabled>
								<input type="hidden" name="input[ID]" value = "<?=$data["event"]["ID"]; ?>">
								<input type="hidden" name="input[No]" value = "<?=$data["event"]["No"]; ?>">
							</div>
							<div class="form-group col-md-6">
								<label for="inputTitle">Event Title</label>
								<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?=$data["event"]["Title"]; ?>" placeholder="Title" disabled>
							</div>
						</div>
						
						<div class="form-row d-none">
							<div class="form-group col-md-6">
								<label for="inputBGIMG">Event Background Image Loc</label>
								<input type="text" class="form-control" id="inputBGIMG" name="input[BG_IMG][Loc]" placeholder="1234 Main St">
							</div>
							<div class="form-group col-md-3">
								<label for="inputBGWidth">Width Size</label>
								<input type="text" class="form-control" id="inputBGWidth" name="input[BG_IMG][Width]" placeholder="Apartment, studio, or floor">
							</div>
							<div class="form-group col-md-3">
								<label for="inputBGHeigh">Heigh Size</label>
								<input type="text" class="form-control" id="inputBGHeigh" name="input[BG_IMG][Heigh]" placeholder="Apartment, studio, or floor">
							</div>
						</div>
						
						<div class="form-row d-none">
							<div class="card-header d-flex justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Ranked Rule</h6>
								<div class="dropdown no-arrow">
									<button type="button" onclick="js_addRule()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Rule
									</button>
								</div>
							</div>
						
							<?php 
								foreach($data["rules"] AS $Key => $Values) :
							?>
							<div class="card-header d-flex col-md-12">
								<div class="form-group col-md-6">
									<label>Rule</label>
									<input type="text" class="form-control" name="input[RankRule][Tag][]" value="<?=$Values["Tag"]; ?>" placeholder="1234 Main St">
								</div>
								<div class="form-group col-md-6">
									<label for="inputRuleAsc">Asc</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[RankRule][Asc][]" value="<?=$Values["Asc"]; ?>" placeholder="Apartment, studio, or floor">
								</div>
							</div>
							<?php
								endforeach;
							?>
							
						</div>
						
						<div class="form-row">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Player</h6>
								<div class="dropdown no-arrow d-none">
									<button type="button" onclick="js_addPlayer()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Player
									</button>
								</div>
							</div>
							
							<?php 
								foreach($data["players"] AS $player_Key => $player_Value) :
							?>
							<div class="card-header py-3 d-flex flex-row align-items-center col-md-12">
								<div class="form-group col-md-3">
									<label>Player <?=$player_Key; ?></label>
									<img class="playerImg" src="<?=$player_Value["Image"]["Loc"]; ?>" alt="<?=$player_Value["Name"]; ?>">
									<input type="text" class="form-control" name="input[Player][Name][]" 	value = "<?=$player_Value["Name"]; ?>" 	placeholder="Name" 	disabled />
									<input type="text" class="form-control d-none" name="input[Player][Image][Loc][]" value = "<?=$player_Value["Image"]["Loc"]; ?>" placeholder="Image" disabled />
									<input type="hidden" name="input[Player][Ranked_ID][]" value="<?=$player_Value["Ranked_ID"]; ?>">
									<input type="hidden" name="input[Player][ID][]" value="<?=$player_Value["ID"]; ?>">
								</div>
								
								<?php 
									foreach($player_Value["ForRank"] AS $forRank_Key => $forRank_Value) :
								?>
								<div class="form-group col-md-3">
									<label for="inputforRank<?=$forRank_Key; ?>"><?=$forRank_Key; ?></label>
									<input type="text" class="form-control" id="inputforRank<?=$forRank_Key; ?>" name="input[Player][forRank][<?=$forRank_Key; ?>][]" value = "<?=$forRank_Value; ?>" placeholder="<?=$forRank_Key; ?>">
								</div>
								<?php 
									endforeach;
								?>
								
							</div>
							<?php 
								endforeach;
							?>
						</div>
						
						<div class="form-row justify-content-end">
							<button type="button" onclick="ajax_sendScoreData()" 	class="btn btn-primary ml-1">Submit</button>
							<button type="button" onclick="js_resetData()" 				class="btn btn-secondary ml-1">Reset</button>
							<button type="button" onclick="js_ScoreBoard()" 			class="btn btn-secondary ml-1">Show Board</button>
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
<script><?php include_once("./tools/js/js_rank_controlTools.php"); ?></script>