<?php require_once("../../tools/ajax/ajax_getRankData.php"); ?>

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
								<input type="text" class="form-control" id="inputNo" name="input[No]" value="<?php echo $data["event"]["No"]; ?>" placeholder="No" disabled>
							</div>
							<div class="form-group col-md-6">
								<label for="inputTitle">Event Title</label>
								<input type="text" class="form-control" id="inputTitle" name="input[Title]" value="<?php echo $data["event"]["Title"]; ?>" placeholder="Title" disabled>
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
									<input type="text" class="form-control" name="input[RankRule][Tag][]" value="<?php echo $Values["Tag"]; ?>" placeholder="1234 Main St">
								</div>
								<div class="form-group col-md-6">
									<label for="inputBGWidth">Width Size</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[BG_IMG][Width][]" value="<?php echo $Values["Asc"]; ?>" placeholder="Apartment, studio, or floor">
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
									<img class="playerImg" src="<?=$player_Value["Image"]; ?>" alt="<?=$player_Value["Name"]; ?>">
									<input type="text" class="form-control" name="input[Player][Name][]" 	value = "<?=$player_Value["Name"]; ?>" 	placeholder="Name" 	disabled />
									<input type="text" class="form-control d-none" name="input[Player][Image][]" value = "<?=$player_Value["Image"]; ?>" placeholder="Image" disabled />
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
							<button type="button" onclick="ajax_sendScoreData()" class="btn btn-primary ml-1">Submit</button>
							<button type="button" onclick="fun_resetData()" 		class="btn btn-secondary ml-1">Reset</button>
							<button type="button" onclick="ajax_previewScoreBoard()" class="btn btn-secondary ml-1">Preview</button>
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