<?php
	//獲取活動資料
	function fun_getEventsData($arySch = array()) {
		$Event_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Event_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Event_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");
		$returnData = array();
		$sql = "SELECT Event_ID 				AS Event_ID, 
									 Event_No 				AS Event_No,
									 Event_Code 			AS Event_Code,
									 Event_Title 			AS Event_Title,
									 Event_Background AS Event_Background,
									 Event_Img 				AS Event_Img,
									 Setting 					AS Setting,
									 Status 					AS Status
							FROM tb_event ";
		$result = fun_getDBData($sql);
		return $result;
	}
	
	//獲取活動資料
	function fun_getEventData($arySch = array()) {
		$Event_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Event_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Event_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");
		$returnData = array();
		$sql = "SELECT Event_ID 				AS Event_ID, 
									 Event_No 				AS Event_No,
									 Event_Code 			AS Event_Code,
									 Event_Title 			AS Event_Title,
									 Event_Background AS Event_Background,
									 Event_Img 				AS Event_Img,
									 Setting 					AS Setting,
									 Status 					AS Status
							FROM tb_event 
						 WHERE ( Event_No 	= '".$Event_No."' 
									OR Event_Code = '".$Event_Code."'
								 ) ";
		$result = fun_getDBData($sql);
		if( count($result) > 0) {
			$getData = $result[0];
			$returnData = array( 
				"ID" 			=> $getData["Event_ID"],
				"No" 			=> $getData["Event_No"],
				"Code" 		=> $getData["Event_Code"],
				"Title" 	=> $getData["Event_Title"],
				"BG"			=> json_decode($getData["Event_Background"], true),
				"Img"			=> json_decode($getData["Event_Img"], true),
				"Setting"	=> json_decode($getData["Setting"], true),
				"Status"	=> $getData["Status"],
			);
		}
		return $returnData;
	}
	
	//獲取活動排序規則
	function fun_getEventRuleData($Event_ID = "") {
		$returnData = array();
		$sql = "SELECT * FROM tb_rankrule WHERE Event_ID = '".$Event_ID."' ORDER BY Rule_Order ASC ";
		$result = fun_getDBData($sql);
		
		if( count($result) > 0) {
			foreach($result AS $Key => $Values) {
				
				$returnData[$Key] = array( 
					"Rule_ID" 	=> $Values["RankRule_ID"],
					"Event_ID" 	=> $Values["Event_ID"],
					"Tag" 			=> $Values["Rule_Tag"],
					"Img"				=> json_decode($Values["Rule_Img"], true),
					"Asc"				=> $Values["Rule_Asc"],
					"Order"			=> $Values["Rule_Order"],
					"Default"		=> $Values["Rule_Default"],
					"Status"		=> $Values["Status"],
				);
			}
		}
		return $returnData;
	}
	
	//獲取玩家資訊
	function fun_getEventPlayersData($arySch = array()) {
		$returnData = array();
		$sql = "SELECT tb_player.Player_ID 			AS Player_ID, 
									 tb_player.Player_No 			AS Player_No,
									 tb_player.Player_Name 		AS Player_Name,
									 tb_player.Player_Img 		AS Player_Img,
									 tb_player.Status 				AS Player_Status
							FROM tb_player 
					ORDER BY Player_ID ASC ";
		$result = fun_getDBData($sql);		//print_r($result); exit();
		return $result;
	}
	//獲取活動玩家資訊
	function fun_getEventPlayerData($Event_ID = "") {
		$returnData = array();
		$sql = "SELECT tb_player.Player_ID 			AS Player_ID, 
									 tb_player.Player_No 			AS Player_No,
									 tb_player.Status 				AS Player_Status,
									 tb_ranked.Ranked_ID 			AS Ranked_ID,
									 tb_ranked.Event_ID 			AS Event_ID,
									 tb_ranked.Player_Name 		AS Player_Name,
									 tb_ranked.Player_Img 		AS Player_Img,
									 tb_ranked.Score 					AS Score,
									 tb_ranked.Status 				AS Ranked_Status 
							FROM tb_player 
				 LEFT JOIN tb_ranked 
								ON tb_player.Player_ID = tb_ranked.Player_ID 
						 WHERE Event_ID = '".$Event_ID."' 
					ORDER BY Ranked_ID ASC ";
		$result = fun_getDBData($sql);		//print_r($result); exit();
		
		if( count($result) > 0) {
			foreach($result AS $Key => $Values) {
				
				$returnData[$Key] = array( 
					"Ranked_ID" 			=> $Values["Ranked_ID"],
					"Event_ID" 				=> $Values["Event_ID"],
					"ID" 							=> $Values["Player_ID"],
					"No" 							=> $Values["Player_No"],
					"Name"						=> $Values["Player_Name"],
					"Image" 					=> json_decode($Values["Player_Img"], true),
					"ForRank" 				=> json_decode($Values["Score"], true),
					"Player_Status"		=> $Values["Player_Status"],
					"Ranked_Status"		=> $Values["Ranked_Status"]
				);
			}
		}
		return $returnData;
	}

?>