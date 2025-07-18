<?php
	require_once("../../tools/php/tools_setting.php");
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");

	$data = array();
	$eventCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");
	$data["event"] 		= fun_getEventData(array("Code" => $eventCode));	//獲取活動資料
	$data["rules"] 		= fun_getEventRuleData($data["event"]["ID"]);			//獲取活動排序規則
	$data["players"] 	= fun_getEventPlayerData($data["event"]["ID"]);		//獲取活動玩家資訊
	
	echo json_encode($data);
	exit();
	
	/*
		{
			"event":	
				{"ID":"1","No":"E000001","Title":"\u76e7\u5be6\u6230\u6280","Img":"","Status":"1"},
			"rules":[
				{"Rule_ID":"1","Event_ID":"1","Tag":"Score","Image":".\/img\/blood.png","Asc":"1","Order":"1","Status":"1"},
				{"Rule_ID":"2","Event_ID":"1","Tag":"Star","Image":".\/img\/star.png","Asc":"1","Order":"2","Status":"1"},
				{"Rule_ID":"3","Event_ID":"1","Tag":"Cards","Image":".\/img\/card-game.png","Asc":"1","Order":"3","Status":"1"}
				],
		  "players":[
				{"Ranked_ID":"1","Event_ID":"1","ID":"1","No":"P00001","Name":"Rat","Image":".\/img\/rat.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"2","Event_ID":"1","ID":"2","No":"P00002","Name":"Cow","Image":".\/img\/cow.png","ForRank":{"Score":60,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"3","Event_ID":"1","ID":"3","No":"P00003","Name":"Tiger","Image":".\/img\/tiger.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"4","Event_ID":"1","ID":"4","No":"P00004","Name":"Rabbit","Image":".\/img\/rabbit.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"5","Event_ID":"1","ID":"5","No":"P00005","Name":"Dragon","Image":".\/img\/dragon.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"6","Event_ID":"1","ID":"6","No":"P00006","Name":"Snake","Image":".\/img\/snake.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"},
				{"Ranked_ID":"7","Event_ID":"1","ID":"7","No":"P00007","Name":"Hoses","Image":".\/img\/horse.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"}
			]
		}
	*/
	/*
		$data["event"] = array( 
			"ID" 		=> "0",
			"No" 		=> "",
			"Code" 	=> "",
			"Title" => "",
			"Setting" => array(
				"ShowTitle" 				=> "1",
				"Font-Family" 			=> "sans-serif",
				"Font-Size" 				=> "20",
				"Font-Color" 				=> "",
				"Update-Frequency" 	=> "1",
				"Col-Width" 				=> "",
				"Col-Height" 				=> "",
				"Rank-Width" 				=> "",
				"Name-Width" 				=> "",
				"Rule-Width" 				=> "",
			),
			"BG" => array(
				"Sel" 		=> "1",
				"Loc" 		=> "",
				"Col" 		=> "",
			),
			"Img" => array(
				"Sel" 		=> "1",
				"Loc" 		=> "",
				"Col" 		=> "",
				"Width" 	=> "",
				"Height" 	=> "",
			),
		);
		$data["rules"] = array(
			0 => array(
				"Rule_ID" => "0",
				"Tag" 		=> "",
				"Order" 	=> "1",
				"Default" => "0",
				"Asc"			=> "1",
				"Status"	=> "1",
				"Img"			=> array(
					"Loc" 		=> "",
					"Width" 	=> "",
					"Height" 	=> "",
					"Left" 		=> "",
					"Top" 		=> "",
				),
			),
		);
		$data["players"] = array(
			0 => array(
				"Ranked_ID" 			=> "0",
				"ID" 							=> "0",
				"Name" 						=> "",
				"Ranked_Status" 	=> "1",
				"Image" 		=> array(
					"Loc" 			=> "",
					"Width" 		=> "",
					"Height" 		=> "",
					"Left" 			=> "",
					"Top" 			=> "",
				),
			),
		);
	
	*/
?>

