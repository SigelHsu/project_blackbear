<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	require_once("../../tools/php/tools_common.php");
	//echo "ajax_updEventData"; print_r($_POST["input"]); exit();
	
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Counter_ID"] 			= $_POST["input"]["ID"];
		$inputData["Counter_No"] 			= $_POST["input"]["No"];
		$inputData["Counter_Code"] 		= $_POST["input"]["Code"];
		$inputData["Counter_Title"] 	= $_POST["input"]["Title"];
		
		$inputData["Target_API"] 			= $_POST["input"]["Target_API"];
		$inputData["Grab_Frequency"] 	= $_POST["input"]["Grab_Frequency"];
		
		$inputData["Counter_Set"] 		= $_POST["input"]["Setting"];
		
		//print_r($inputData); //exit();
		$inputData = fun_updCounterData($inputData);
		echo json_encode($inputData);
		exit();
	}
	
	//新增/更新活動資料
	function fun_updCounterData( $data = array() ) {
		
		$Counter_ID 		= $data["Counter_ID"];
		$Counter_No 		= $data["Counter_No"];
		if($Counter_ID == 0) {
			$getCounters = fun_getCountersData();
			$Counter_No  = "C".str_pad((count($getCounters) + 1), 6, '0', STR_PAD_LEFT);
			do {
				$Counter_Code = fun_randtext(6);
				$trsult = fun_getCounterData(array("Code" => $Counter_Code));
			} while( count($trsult) !=0 );
			
			$sql = "INSERT INTO tb_counter 
													(
														Counter_No, 
														Counter_Code, 
														Counter_Title, 
														Target_API, 
														Grab_Frequency, 
														Setting, 
														Status, 
														Create_Date, 
														Modify_Date
													) 
									 VALUES (
														'".$Counter_No."', 
														'".$Counter_Code."', 
														'".$data["Counter_Title"]."', 
														'".$data["Target_API"]."', 
														'".$data["Grab_Frequency"]."', 
														'".json_encode($data["Counter_Set"])."', 
														'1', 
														NOW(), 
														NOW()
												  );";
			$data["Count_ID"] 	= fun_insDBData($sql);	//echo $sql; exit();	//echo "Event_ID: ".$Event_ID."</br>"; exit();
			$data["Count_No"] 	= $Counter_No;
			$data["Count_Code"] = $Counter_Code;
		}
		else {
			$sql = "UPDATE tb_counter
								 SET Counter_Title 		= '".$data["Counter_Title"]."', 
										 Target_API				= '".$data["Target_API"]."', 
										 Grab_Frequency 	= '".$data["Grab_Frequency"]."', 
										 Setting 					= '".json_encode($data["Counter_Set"])."', 
										 Modify_Date 			= NOW()
							 WHERE Counter_ID 			= '".$Counter_ID."' ;";
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

