
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
				<h6 class="m-0 font-weight-bold text-primary">Create Event</h6>
				<div class="dropdown no-arrow d-none">
					<a href="./index.php?loc=new_event" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
						<i class="fas fa-plus fa-sm text-white-50"></i> Add new Event
					</a>
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
							 aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<form>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputNo">Event No</label>
								<input type="text" class="form-control" id="inputNo" name="input[No]" placeholder="Email" disabled>
							</div>
							<div class="form-group col-md-6">
								<label for="inputTitle">Event Title</label>
								<input type="text" class="form-control" id="inputTitle" name="input[Title]" placeholder="Password">
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
						
						<div class="form-row">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Ranked Rule</h6>
								<div class="dropdown no-arrow">
									<button type="button" onclick="js_addRule()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Rule
									</button>
								</div>
							</div>
						
							<div class="card-header py-3 d-flex flex-row align-items-center col-md-12">
								<div class="form-group col-md-6">
									<label>Rule 1</label>
									<input type="text" class="form-control" name="input[RankRule][Tag][]" placeholder="1234 Main St">
								</div>
								<div class="form-group col-md-3">
									<label for="inputBGWidth">Width Size</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[BG_IMG][Width][]" placeholder="Apartment, studio, or floor">
								</div>
							</div>
						</div>
						
						<div class="form-row">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between col-md-12">
								<h6 class="m-0 font-weight-bold text-primary">Player</h6>
								<div class="dropdown no-arrow">
									<button type="button" onclick="js_addPlayer()" class="d-none d-sm-inline-block btn btn-sm btn btn-outline-info shadow-sm">
										<i class="fas fa-plus fa-sm"></i> Add new Player
									</button>
								</div>
							</div>
						
							<div class="card-header py-3 d-flex flex-row align-items-center col-md-12">
								<div class="form-group col-md-3">
									<label>Player 1</label>
										<input type="text" class="form-control" id="inputBGWidth" name="input[Player][Name][]" placeholder="Apartment, studio, or floor">
								</div>
								<div class="form-group col-md-3">
									<label for="inputBGWidth">Score</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[Player][Score][]" placeholder="Apartment, studio, or floor">
								</div>
								<div class="form-group col-md-3">
									<label for="inputBGWidth">Star</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[Player][Star][]" placeholder="Apartment, studio, or floor">
								</div>
								<div class="form-group col-md-3">
									<label for="inputBGWidth">Card</label>
									<input type="text" class="form-control" id="inputBGWidth" name="input[Player][Card][]" placeholder="Apartment, studio, or floor">
								</div>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>