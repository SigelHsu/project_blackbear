<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	require_once("../../tools/php/tools_common.php");
	//echo "ajax_updEventData"; print_r($_POST["input"]); exit();
	
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Event_ID"] 		= $_POST["input"]["ID"];
		$inputData["Event_No"] 		= $_POST["input"]["No"];
		$inputData["Event_Code"] 	= $_POST["input"]["Code"];
		$inputData["Event_Title"] = $_POST["input"]["Title"];
		$inputData["Event_BG"] 		= $_POST["input"]["BG"];
		$inputData["Event_Img"] 	= $_POST["input"]["Img"];
		$inputData["Event_Set"] 	= $_POST["input"]["Setting"];
		
		$inputData["Rule"] = array();
		foreach($_POST["input"]["RankRule"]["Tag"] AS $KeyNo => $RuleTag) {
			$inputData["Rule"][$KeyNo]["Tag"] 					= $RuleTag;
			$inputData["Rule"][$KeyNo]["Rule_ID"] 			= $_POST["input"]["RankRule"]["ID"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Order"] 				= $_POST["input"]["RankRule"]["Order"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Default"] 			= $_POST["input"]["RankRule"]["Default"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Asc"] 					= $_POST["input"]["RankRule"]["Asc"][$KeyNo];
			
			$inputData["Rule"][$KeyNo]["Status"] 				= $_POST["input"]["RankRule"]["Status"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Img"]["Loc"] 		= $_POST["input"]["RankRule"]["Img"]["Loc"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Img"]["Width"] 	= $_POST["input"]["RankRule"]["Img"]["Width"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Img"]["Height"] = $_POST["input"]["RankRule"]["Img"]["Height"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Img"]["Left"] 	= $_POST["input"]["RankRule"]["Img"]["Left"][$KeyNo];
			$inputData["Rule"][$KeyNo]["Img"]["Top"] 		= $_POST["input"]["RankRule"]["Img"]["Top"][$KeyNo];
		}
		
		$inputData["Player"] = array();
		foreach($_POST["input"]["Player"]["ID"] AS $KeyNo => $Player_ID) {
			$inputData["Player"][$KeyNo]["Player_ID"] 		= $Player_ID;
			$inputData["Player"][$KeyNo]["Ranked_ID"] 		= $_POST["input"]["Player"]["Ranked_ID"][$KeyNo];
			$inputData["Player"][$KeyNo]["Name"] 					= $_POST["input"]["Player"]["Name"][$KeyNo];
			
			$inputData["Player"][$KeyNo]["Status"] 				= $_POST["input"]["Player"]["Status"][$KeyNo];
			$inputData["Player"][$KeyNo]["Img"]["Loc"] 		= $_POST["input"]["Player"]["Img"]["Loc"][$KeyNo];
			$inputData["Player"][$KeyNo]["Img"]["Width"] 	= $_POST["input"]["Player"]["Img"]["Width"][$KeyNo];
			$inputData["Player"][$KeyNo]["Img"]["Height"] = $_POST["input"]["Player"]["Img"]["Height"][$KeyNo];
			$inputData["Player"][$KeyNo]["Img"]["Left"] 	= $_POST["input"]["Player"]["Img"]["Left"][$KeyNo];
			$inputData["Player"][$KeyNo]["Img"]["Top"] 		= $_POST["input"]["Player"]["Img"]["Top"][$KeyNo];
		}
		
		//print_r($inputData); //exit();
		$inputData = fun_updEventData($inputData);
		$inputData = fun_updRuleData($inputData);
		$inputData = fun_updPlayerRankData($inputData);
		echo json_encode($inputData);
		exit();
	}
	
	//新增/更新活動資料
	function fun_updEventData( $data = array() ) {
		
		$Event_ID 		= $data["Event_ID"];
		$Event_No 		= $data["Event_No"];
		if($Event_ID == 0) {
			$getEvents = fun_getEventsData();
			$Event_No 	= "E".str_pad((count($getEvents) + 1), 6, '0', STR_PAD_LEFT);
			do {
				$Event_Code = fun_randtext(6);
				$trsult = fun_getEventData(array("Code" => $Event_Code));
			} while( count($trsult) !=0 );
			
			$sql = "INSERT INTO tb_event 
													(
														Event_No, 
														Event_Code, 
														Event_Title, 
														Event_Background, 
														Event_Img, 
														Setting, 
														Status, 
														Create_Date, 
														Modify_Date
													) 
									 VALUES (
														'".$Event_No."', 
														'".$Event_Code."', 
														'".$data["Event_Title"]."', 
														'".json_encode($data["Event_BG"])."', 
														'".json_encode($data["Event_Img"])."', 
														'".json_encode($data["Event_Set"])."', 
														'1', 
														NOW(), 
														NOW()
												  );";
			$data["Event_ID"] 	= fun_insDBData($sql);	//echo $sql; exit();	//echo "Event_ID: ".$Event_ID."</br>"; exit();
			$data["Event_No"] 	= $Event_No;
			$data["Event_Code"] = $Event_Code;
		}
		else {
			$sql = "UPDATE tb_event
								 SET Event_Title 			= '".$data["Event_Title"]."', 
										 Event_Background	= '".json_encode($data["Event_BG"])."', 
										 Event_Img 				= '".json_encode($data["Event_Img"])."', 
										 Setting 					= '".json_encode($data["Event_Set"])."', 
										 Modify_Date 			= NOW()
							 WHERE Event_ID 				= '".$Event_ID."' ;";
			$result = fun_updDBData($sql);		//echo $sql."</br>"; exit();
		}
		
		return $data;
	}
	//新增/更新活動排序規則資料
	function fun_updRuleData( $data = array() ) {
		
		$Event_ID 		= $data["Event_ID"];
		
		foreach($data["Rule"] AS $Key => $Values) {
			
			if($Values["Rule_ID"] == 0) {
				$sql = "INSERT INTO tb_rankRule 
														(
															Event_ID, 
															Rule_Tag, 
															Rule_Img, 
															Rule_Asc, 
															Rule_Order, 
															Rule_Default, 
															Status, 
															Create_Date, 
															Modify_Date
														) 
										 VALUES (
															'".$Event_ID."', 
															'".$Values["Tag"]."', 
															'".json_encode($Values["Img"])."', 
															'".$Values["Asc"]."',  
															'".$Values["Order"]."',  
															'".$Values["Default"]."',  
															'".$Values["Status"]."', 
															NOW(), 
															NOW()
														);";
				$Values["Rule_ID"] = fun_insDBData($sql);
			}
			else {
				$sql = "UPDATE tb_rankRule
									 SET Event_ID 		= '".$Event_ID."', 
											 Rule_Tag 		= '".$Values["Tag"]."', 
											 Rule_Img 		= '".json_encode($Values["Img"])."', 
											 Rule_Asc 		= '".$Values["Asc"]."', 
											 Rule_Order 	= '".$Values["Order"]."', 
											 Rule_Default = '".$Values["Default"]."', 
											 Status 			= '".$Values["Status"]."', 
											 Modify_Date 	= NOW()
								 WHERE RankRule_ID 	= '".$Values["Rule_ID"]."' ;";
				$result = fun_updDBData($sql);	//echo $sql."</br>"; exit();
			}
			
		}
		
		return $data;
	}
	//新增/更新活動參與人員資料
	function fun_updPlayerRankData( $data = array() ) {
		
		$default_score = array();
		foreach($data["Rule"] AS $Key => $Values) {
			$default_score[$Values["Tag"]] = $Values["Default"];
		}
		
		$Event_ID 		= $data["Event_ID"];
		
		foreach($data["Player"] AS $Key => $Values) {
			//先塞到 tb_player裡面
			{
				if($Values["Player_ID"] == 0) {
					$getEvents = fun_getEventPlayersData();
					$Player_No 	= "P".str_pad((count($getEvents) + 1), 5, '0', STR_PAD_LEFT);
					$sql = "INSERT INTO tb_player 
															(
																Player_No, 
																Player_Name, 
																Player_Img, 
																Status, 
																Create_Date, 
																Modify_Date
															) 
											 VALUES (
																'".$Player_No."', 
																'".$Values["Name"]."', 
																'".json_encode($Values["Img"])."', 
																'".$Values["Status"]."', 
																NOW(), 
																NOW()
															);";
					$Values["Player_ID"] = fun_insDBData($sql);
					$Values["Player_No"] = $Player_No;
				}
				/*
				else {
					$sql = "UPDATE tb_player
										 SET Player_Name 		= '".$Values["Name"]."', 
												 Player_Img 		= '".json_encode($Values["Img"])."', 
												 Status 				= '".$Values["Status"]."', 
												 Modify_Date 		= NOW()
									 WHERE Player_ID 			= '".$Values["Player_ID"]."' ;";
					$result = fun_updDBData($sql);
				}
				*/
			}
			
			//再塞到 tb_ranked裡面
			{
				if($Values["Ranked_ID"] == 0) {
					$sql = "INSERT INTO tb_ranked 
															(
																Event_ID, 
																Player_ID, 
																Player_Name, 
																Player_Img, 
																Score, 
																Status, 
																Create_Date, 
																Modify_Date
															) 
											 VALUES (
																'".$Event_ID."', 
																'".$Values["Player_ID"]."', 
																'".$Values["Name"]."', 
																'".json_encode($Values["Img"])."', 
																'".json_encode($default_score)."', 
																'".$Values["Status"]."', 
																NOW(), 
																NOW()
															);";
					$Values["Ranked_ID"] = fun_insDBData($sql);
				}
				else {
					$sql = "UPDATE tb_ranked
										 SET Event_ID 			= '".$Event_ID."', 
												 Player_ID 			= '".$Values["Player_ID"]."', 
												 Player_Name 		= '".$Values["Name"]."', 
												 Player_Img 		= '".json_encode($Values["Img"])."', 
												 Status 				= '".$Values["Status"]."', 
												 Modify_Date 		= NOW()
									 WHERE Ranked_ID 			= '".$Values["Ranked_ID"]."' ;";
					$result = fun_updDBData($sql);		//echo $sql."</br>";
				}
			}
		}
		
		return $data;
	}
	exit();
	
	/*
		Array (
			[ID] => 1
			[No] => E000001
			[Title] => 盧實戰技
			[BG_IMG] => Array (
				[Loc] 	=> 
				[Width] => 
				[Heigh] => 
			)

			[RankRule] => Array (
				[Tag] => Array (
					[0] => Score
					[1] => Star
					[2] => Cards
				)
				[Default] => Array (
					[0] => 0
					[1] => 0
					[2] => 0
				)
				[Asc] => Array (
					[0] => 1
					[1] => 1
					[2] => 1
				)
				[Status] => Array (
					[0] => 1
					[1] => 1
					[2] => 1
				)
			)
	
			[Player] => Array (
				[Ranked_ID] => Array (
					[0] => 1
					[1] => 2
					[2] => 3
					[3] => 4
					[4] => 5
					[5] => 6
					[6] => 7
				)
				[ID] => Array (
					[0] => 1
					[1] => 2
					[2] => 3
					[3] => 4
					[4] => 5
					[5] => 6
					[6] => 7
				)
				[Name] => Array (
					[0] => Rat
					[1] => Cow
					[2] => Tiger
					[3] => Rabbit
					[4] => Dragon
					[5] => Snake
					[6] => Hoses
				)
				[Image] => Array (
					[Loc] => Array (
						[0] => ./img/rat.png
						[1] => ./img/cow.png
						[2] => ./img/tiger.png
						[3] => ./img/rabbit.png
						[4] => ./img/dragon.png
						[5] => ./img/snake.png
						[6] => ./img/horse.png
					)
					[Width] => Array (
						[0] => 
						[1] => 
						[2] => 
						[3] => 
						[4] => 
						[5] => 
						[6] => 
					)
					[Heigh] => Array (
						[0] => 
						[1] => 
						[2] => 
						[3] => 
						[4] => 
						[5] => 
						[6] => 
					)
					[Left] => Array (
						[0] => 
						[1] => 
						[2] => 
						[3] => 
						[4] => 
						[5] => 
						[6] => 
					)
					[Top] => Array (
						[0] => 
						[1] => 
						[2] => 
						[3] => 
						[4] => 
						[5] => 
						[6] => 
					)
				)
			)
		)
	*/
	/*
		Array (
			[Event_ID] => 1
			[Event_No] => E000001
			[Event_Title] => 盧實戰技
			[BG_IMG] => Array (
				[Loc] => 
				[Width] => 
				[Heigh] => 
			)
			[Rule] => Array (
				[0] => Array (
					[Tag] => Score
					[Default] => 0
					[Asc] => 1
					[Status] => 1
					[Img] => Array (
						[Loc] 		=> 
						[Width] 	=> 
						[Height] 	=> 
						[Left] 		=> 
						[Top] 		=> 
					)
				)
				[1] => Array (
					[Tag] => Star
					[Default] => 0
					[Asc] => 1
					[Status] => 1
					[Img] => Array (
						[Loc] 		=> 
						[Width] 	=> 
						[Height] 	=> 
						[Left] 		=> 
						[Top] 		=> 
					)
				)
				[2] => Array (
					[Tag] => Cards
					[Default] => 0
					[Asc] => 1
					[Status] => 1
					[Img] => Array (
						[Loc] 		=> 
						[Width] 	=> 
						[Height] 	=> 
						[Left] 		=> 
						[Top] 		=> 
					)
				)
			)
		)
	*/

?>

