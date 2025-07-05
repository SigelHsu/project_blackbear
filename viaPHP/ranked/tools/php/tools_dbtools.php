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
<?php
	//獲取計數器資料
	function fun_getCountersData($arySch = array()) {
		$Counter_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Counter_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Counter_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");
		$returnData = array();
		$sql = "SELECT Counter_ID 		AS Counter_ID, 
									 Counter_No 		AS Counter_No, 
									 Counter_Code 	AS Counter_Code, 
									 Counter_Title 	AS Counter_Title,
									 Target_API 		AS Target_API,
									 Grab_Frequency AS Grab_Frequency,
									 Setting 				AS Setting,
									 Status 				AS Status,
									 Create_Date 		AS Create_Date,
									 Modify_Date 		AS Modify_Date
							FROM tb_counter ";
		$result = fun_getDBData($sql);
		return $result;
	}
	
	//獲取單一計數器資料
	function fun_getCounterData($arySch = array()) {
		$Counter_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Counter_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Counter_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");
		$returnData = array();
		$sql = "SELECT Counter_ID 		AS Counter_ID, 
									 Counter_No 		AS Counter_No, 
									 Counter_Code 	AS Counter_Code, 
									 Counter_Title 	AS Counter_Title,
									 Target_API 		AS Target_API,
									 Grab_Frequency AS Grab_Frequency,
									 Setting 				AS Setting,
									 Status 				AS Status,
									 Create_Date 		AS Create_Date,
									 Modify_Date 		AS Modify_Date
							FROM tb_counter 
						 WHERE ( Counter_No 	= '".$Counter_No."' 
									OR Counter_Code = '".$Counter_Code."'
								 ) ";
		$result = fun_getDBData($sql);
		if( count($result) > 0) {
			$getData = $result[0];
			$returnData = array( 
				"ID" 							=> $getData["Counter_ID"],
				"No" 							=> $getData["Counter_No"],
				"Code" 						=> $getData["Counter_Code"],
				"Title" 					=> $getData["Counter_Title"],
				"Target_API"			=> $getData["Target_API"],
				"Grab_Frequency" 	=> $getData["Grab_Frequency"],
				"Setting"					=> json_decode($getData["Setting"], true),
				"Status"					=> $getData["Status"],
			);
		}
		return $returnData;
	}

	//獲取紀錄的計數器資訊
	function fun_getGrabInfoData($Counter_ID = "") {
		$returnData = array();
		$sql = "SELECT tb_grabinfo.GrabInfo_ID 		AS GrabInfo_ID, 
									 tb_grabinfo.Counter_ID 		AS Counter_ID,
									 tb_grabinfo.Grab_Values 		AS Grab_Values,
									 tb_grabinfo.Grab_Info 			AS Grab_Info,
									 tb_grabinfo.Status 				AS Status, 
									 tb_grabinfo.Create_Date 		AS Create_Date,
									 tb_grabinfo.Modify_Date 		AS Modify_Date
							FROM tb_grabinfo
						 WHERE Counter_ID = '".$Counter_ID."' 
					ORDER BY GrabInfo_ID DESC ";
		$result = fun_getDBData($sql);		//print_r($result); exit();
		
		if( count($result) > 0) {
			foreach($result AS $Key => $Values) {
				
				$returnData[$Key] = array( 
					"GrabInfo_ID" 	=> $Values["GrabInfo_ID"],
					"Counter_ID" 		=> $Values["Counter_ID"],
					"Grab_Values" 	=> $Values["Grab_Values"],
					"Grab_Info" 		=> json_decode($Values["Grab_Info"], true),
					"Status" 				=> $Values["Status"],
					"Create_Date"		=> $Values["Create_Date"],
					"Modify_Date"		=> $Values["Modify_Date"]
				);
			}
		}
		return $returnData;
	}
?>
<?php
	//獲取字幕組資料
	function fun_getCaptionsData($arySch = array()) {
		
		$Caption_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Caption_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Caption_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");

		$returnData = array();
		$sql = "SELECT Caption_ID 		AS Caption_ID, 
									 Caption_No 		AS Caption_No, 
									 Caption_Code 	AS Caption_Code, 
									 Caption_Title 	AS Caption_Title,
									 Setting 				AS Setting,
									 Status 				AS Status,
									 Create_Date 		AS Create_Date,
									 Modify_Date 		AS Modify_Date
							FROM tb_caption ";
		$result = fun_getDBData($sql);
		return $result;
	}
	
	//獲取單一計數器資料
	function fun_getCaptionData($arySch = array()) {
		$Caption_ID 	= (isset($arySch["ID"])) 		? ($arySch["ID"]) 	: ("");
		$Caption_No 	= (isset($arySch["No"])) 		? ($arySch["No"]) 	: ("");
		$Caption_Code = (isset($arySch["Code"])) 	? ($arySch["Code"]) : ("");
		$returnData = array();
		$sql = "SELECT Caption_ID 		AS Caption_ID, 
									 Caption_No 		AS Caption_No, 
									 Caption_Code 	AS Caption_Code, 
									 Caption_Title 	AS Caption_Title,
									 Setting 				AS Setting,
									 Status 				AS Status,
									 Create_Date 		AS Create_Date,
									 Modify_Date 		AS Modify_Date
							FROM tb_caption 
						 WHERE ( Caption_No 	= '".$Caption_No."' 
									OR Caption_Code = '".$Caption_Code."'
								 ) ";
		$result = fun_getDBData($sql);
		if( count($result) > 0) {
			$getData = $result[0];
			$returnData = array( 
				"ID" 							=> $getData["Caption_ID"],
				"No" 							=> $getData["Caption_No"],
				"Code" 						=> $getData["Caption_Code"],
				"Title" 					=> $getData["Caption_Title"],
				"Setting"					=> json_decode($getData["Setting"], true),
				"Status"					=> $getData["Status"],
			);
		}
		return $returnData;
	}

	//獲取字幕組的字幕資訊
	function fun_getSubtitlesData($arySch = array()) {
		
		// 處理搜尋字串
		{
			$sql_schCaptID 			 = "";
			if ( isset($arySch["Caption_ID"]) ) {
				$sql_schCaptID 		.= " AND tb_subtitles.Caption_ID = '".$arySch["Caption_ID"]."'";
			}
			
			$sql_schSubtID 			 = "";
			if ( isset($arySch["Subtitle_ID"]) ) {
				$sql_schSubtID 		.= " AND tb_subtitles.Subtitle_ID = '".$arySch["Subtitle_ID"]."'";
			}
			
			$sql_schSubState 		 = "";
			if ( isset($arySch["Subtitle_Status"]) ) {
				$sql_schSubState 	.= " AND tb_subtitles.Status >= '".$arySch["Subtitle_Status"]."'";
			}
			if ( isset($arySch["Subtitle_StatusR"]) ) {
				$sql_schSubState 	.= " AND tb_subtitles.Status < '".$arySch["Subtitle_StatusR"]."'";
			}
			
			$sql_schSubListOrder 		= " ORDER BY Publish_Order ASC, Subtitle_Order ASC, Subtitle_ID ASC";
			if ( isset($arySch["Subtitle_LsitOrder"]) ) {
				switch($arySch["Subtitle_LsitOrder"]){
					default:
					case 1:
						{
							$sql_schSubListOrder 	= " ORDER BY Publish_Order ASC, Subtitle_Order ASC, Subtitle_ID ASC";
						}
						break;
					case 2:
						{
							$sql_schSubListOrder 	= " ORDER BY Publish_Order DESC, Subtitle_Order DESC, Subtitle_ID DESC";
						}
						break;
					case 3:
						{
							$sql_schSubListOrder 	= " ORDER BY Subtitle_ID DESC, Subtitle_Order DESC, Publish_Order DESC";
						}
						break;
					case 4:
						{
							$sql_schSubListOrder 	= " ORDER BY Modify_Date DESC, Subtitle_ID DESC, Subtitle_Order DESC, Publish_Order DESC";
						}
						break;
				}
				
			}
		}
		
		$returnData = array();
		$sql = "SELECT tb_subtitles.Subtitle_ID 		AS Subtitle_ID, 
									 tb_subtitles.Caption_ID 			AS Caption_ID,
									 tb_subtitles.Subtitle_Order 	AS Subtitle_Order,
									 tb_subtitles.Publish_Order 	AS Publish_Order,
									 tb_subtitles.Time_Tag 				AS Time_Tag,
									 tb_subtitles.Subtitle_Info 	AS Subtitle_Info,
									 tb_subtitles.Other_Info 			AS Other_Info,
									 tb_subtitles.Status 					AS Status, 
									 tb_subtitles.Create_Date 		AS Create_Date,
									 tb_subtitles.Modify_Date 		AS Modify_Date
							FROM tb_subtitles
						 WHERE 1 
									 ".$sql_schCaptID."
									 ".$sql_schSubtID."
									 ".$sql_schSubState."
									 ".$sql_schSubListOrder." ";		// print_r($sql);
		$result = fun_getDBData($sql);		//print_r($result); exit();
		
		if( count($result) > 0) {
			foreach($result AS $Key => $Values) {
				
				$returnData[$Key] = array( 
					"Subtitle_ID" 		=> $Values["Subtitle_ID"],
					"Caption_ID" 			=> $Values["Caption_ID"],
					"Subtitle_Order" 	=> $Values["Subtitle_Order"],
					"Publish_Order" 	=> $Values["Publish_Order"],
					"Time_Tag" 				=> $Values["Time_Tag"],
					"Subtitle_Info" 	=> htmlspecialchars_decode($Values["Subtitle_Info"]),
					"Other_Info" 			=> $Values["Other_Info"],					//json_decode($Values["Other_Info"], true)
					"Status" 					=> $Values["Status"],
					"Create_Date"			=> $Values["Create_Date"],
					"Modify_Date"			=> $Values["Modify_Date"]
				);
			}
		}
		return $returnData;
	}
?>