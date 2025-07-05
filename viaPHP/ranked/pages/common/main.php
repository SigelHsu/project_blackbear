<!-- Begin Page Content -->
<div id="div_main" class="container-fluid">
	<?php 
		$getLoc = ( isset($_REQUEST["loc"]) ) ? ($_REQUEST["loc"]) : ("");
		$navigate_url = "";
		switch($getLoc) {
			default:
			case "main":
				$navigate_url = "./pages/dashboard.php";
				break;
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
				
			case "listCount":
				$navigate_url = "./pages/count/counter_list.php";
				break;
			case "newCount": 
				$navigate_url = "./pages/count/counter_create.php";
				break;
			case "editCount": 
				$navigate_url = "./pages/count/counter_edit.php";
				break;
			case "scoreCount": 
				$navigate_url = "./pages/count/counter_score.php";
				break;
			case "jumpCount":
				$navigate_url = "./pages/count/jump_counter.php";
				break;
		}
		
		require_once($navigate_url); 
	?>
</div>
<!-- /.container-fluid -->