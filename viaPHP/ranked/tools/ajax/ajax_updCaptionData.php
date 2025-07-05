<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	require_once("../../tools/php/tools_common.php");
	//echo "ajax_updEventData"; print_r($_POST["input"]); exit();
	
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Caption_ID"] 			= $_POST["input"]["ID"];
		$inputData["Caption_No"] 			= $_POST["input"]["No"];
		$inputData["Caption_Code"] 		= $_POST["input"]["Code"];
		$inputData["Caption_Title"] 	= $_POST["input"]["Title"];
		
		$inputData["Caption_Set"] 		= $_POST["input"]["Setting"];
		
		//print_r($inputData); //exit();
		$inputData = fun_updCaptionData($inputData);
		echo json_encode($inputData);
		exit();
	}
	
	//新增/更新活動資料
	function fun_updCaptionData( $data = array() ) {
		
		$Caption_ID 		= $data["Caption_ID"];
		$Caption_No 		= $data["Caption_No"];
		if($Caption_ID == 0) {
			$getCounters = fun_getCaptionsData();
			$Caption_No  = "S".str_pad((count($getCounters) + 1), 6, '0', STR_PAD_LEFT);
			do {
				$Caption_Code = fun_randtext(6);
				$trsult = fun_getCounterData(array("Code" => $Caption_Code));
			} while( count($trsult) !=0 );
			
			$sql = "INSERT INTO tb_caption 
													(
														Caption_No, 
														Caption_Code, 
														Caption_Title, 
														Setting, 
														Status, 
														Create_Date, 
														Modify_Date
													) 
									 VALUES (
														'".$Caption_No."', 
														'".$Caption_Code."', 
														'".$data["Caption_Title"]."', 
														'".json_encode($data["Caption_Set"])."', 
														'1', 
														NOW(), 
														NOW()
												  );";
			$data["Caption_ID"] 	= fun_insDBData($sql);	//echo $sql; exit();	//echo "Event_ID: ".$Event_ID."</br>"; exit();
			$data["Caption_No"] 	= $Caption_No;
			$data["Caption_Code"] = $Caption_Code;
		}
		else {
			$sql = "UPDATE tb_caption 
								 SET Caption_Title 		= '".$data["Caption_Title"]."', 
										 Setting 					= '".json_encode($data["Caption_Set"])."', 
										 Modify_Date 			= NOW()
							 WHERE Caption_ID 			= '".$Caption_ID."' ;";
			$result = fun_updDBData($sql);		//echo $sql."</br>"; exit();
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

