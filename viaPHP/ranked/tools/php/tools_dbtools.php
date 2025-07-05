<?php
	//獲取活動資料
	function fun_getEventData($Event_No = "") {
		$returnData = array();
		$sql = "SELECT * FROM tb_event WHERE Event_No = '".$Event_No."' ";
		$result = fun_getDBData($sql);
		if( count($result) > 0) {
			$getData = $result[0];
			$returnData = array( 
				"ID" 			=> $getData["Event_ID"],
				"No" 			=> $getData["Event_No"],
				"Title" 	=> $getData["Event_Title"],
				"Img"			=> $getData["Event_Img"],
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
					"Image"			=> $Values["Rule_Img"],
					"Asc"				=> $Values["Rule_Asc"],
					"Order"			=> $Values["Rule_Order"],
					"Status"		=> $Values["Status"],
				);
			}
		}
		return $returnData;
	}
	
	//獲取活動玩家資訊
	function fun_getEventPlayerData($Event_ID = "") {
		$returnData = array();
		$returnData = array();
		$sql = "SELECT tb_player.Player_ID 			AS Player_ID, 
									 tb_player.Player_No 			AS Player_No,
									 tb_player.Player_Name 		AS Player_Name,
									 tb_player.Player_Img 		AS Player_Img,
									 tb_player.Status 				AS Player_Status,
									 tb_ranked.Ranked_ID 			AS Ranked_ID,
									 tb_ranked.Event_ID 			AS Event_ID,
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
					"Image" 					=> json_decode($Values["Player_Img"], true)["Loc"],
					"ForRank" 				=> json_decode($Values["Score"], true),
					"Player_Status"		=> $Values["Player_Status"],
					"Ranked_Status"		=> $Values["Ranked_Status"]
				);
			}
		}
		return $returnData;
	}

?>