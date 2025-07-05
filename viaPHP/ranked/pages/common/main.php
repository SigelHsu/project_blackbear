<!-- Begin Page Content -->
<div id="div_main" class="container-fluid">
	<?php 
		$getLoc = ( isset($_REQUEST["loc"]) ) ? ($_REQUEST["loc"]) : ("");
		$navigate_url = "";
		switch($getLoc) {
			case "main":
				$navigate_url = "./pages/dashboard.php";
				break;
			default:
			case "listEvent": 
				$navigate_url = "./pages/event/event_list.php";
				break;
			case "newEvent": 
				$navigate_url = "./pages/event/event_create.php";
				break;
			case "editEvent": 
				$navigate_url = "./pages/event/event_edit.php";
				break;
			case "scoreEvent": 
				$navigate_url = "./pages/event/event_score.php";
				break;
			case "scoreBoard": 
				$navigate_url = "./pages/event/event_scoreBoard.php";
				break;
		}
		
		require_once($navigate_url); 
	?>
</div>
<!-- /.container-fluid -->