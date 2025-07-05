<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_updRankData"; print_r($_POST["input"]);
	
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Event_ID"] = $_POST["input"]["ID"];
		$inputData["Event_No"] = $_POST["input"]["No"];
		$inputData["Player"] = array();
		foreach($_POST["input"]["Player"]["Ranked_ID"] AS $KeyNo => $Ranked_ID) {
			$inputData["Player"][$KeyNo]["Ranked_ID"] = $Ranked_ID;
			$inputData["Player"][$KeyNo]["Player_ID"] = $_POST["input"]["Player"]["ID"][$KeyNo];
			
			foreach($_POST["input"]["Player"]["forRank"] AS $RankTag => $RankValues) {
				$inputData["Player"][$KeyNo]["forRank"][$RankTag] = $RankValues[$KeyNo];				
			}			
		}
		
		//print_r($inputData);
		echo fun_updRankData($inputData);
	}
	
	//獲取活動資料
	function fun_updRankData( $data = array() ) {
		
		$Event_ID = $data["Event_ID"];
		$Event_No = $data["Event_No"];
		foreach($data["Player"] AS $Key => $Values) {
			$sql = "UPDATE tb_ranked
								 SET tb_ranked.Score='".json_encode($Values["forRank"])."'
							 WHERE Ranked_ID 	= '".$Values["Ranked_ID"]."' 
								 AND Event_ID 	= '".$Event_ID."' 
								 AND Player_ID 	= '".$Values["Player_ID"]."' ;";
			//echo $sql."</br>";
			$result = fun_updDBData($sql);
		}
		
		return true;
	}
	exit();
	
	/*
		Array (
			[Event_ID] => 1
			[Event_No] => E000001
			[Player] => Array (
				[0] => Array (
					[Ranked_ID] => 1
					[Player_ID] => 1
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)

				[1] => Array (
					[Ranked_ID] => 2
					[Player_ID] => 2
					[forRank] => Array  (
						[Score] => 60
						[Star] => 3
						[Cards] => 2
					)
				)

				[2] => Array (
					[Ranked_ID] => 3
					[Player_ID] => 3
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)

				[3] => Array (
					[Ranked_ID] => 4
					[Player_ID] => 4
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)

				[4] => Array (
					[Ranked_ID] => 5
					[Player_ID] => 5
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)

				[5] => Array (
					[Ranked_ID] => 6
					[Player_ID] => 6
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)

				[6] => Array (
					[Ranked_ID] => 7
					[Player_ID] => 7
					[forRank] => Array (
						[Score] => 30
						[Star] => 3
						[Cards] => 2
					)
				)
				
			)
		)
	*/
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
				{"Ranked_ID":"7","Event_ID":"1","ID":"7","No":"P00007","Name":"Hoses","Image":".\/img\/horse.png","ForRank":{"Score":30,"Star":3,"Cards":2},"Player_Status":"1","Ranked_Status":"1"}]}
	*/
	/*
		Array (
			[input] => Array (
				[ID] => 1
				[No] => E000001
				[BG_IMG] => Array (
					[Loc] => 
					[Width] => 
					[Heigh] => 
				)

				[RankRule] => Array (
					[Tag] => Array (
						[0] => Score
						[1] => Star
						[2] => Cards
					)

					[Asc] => Array (
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

					[forRank] => Array (
						[Score] => Array (
							[0] => 30
							[1] => 60
							[2] => 30
							[3] => 30
							[4] => 30
							[5] => 30
							[6] => 30
						)

						[Star] => Array (
							[0] => 3
							[1] => 3
							[2] => 3
							[3] => 3
							[4] => 3
							[5] => 3
							[6] => 3
						)

						[Cards] => Array (
							[0] => 2
							[1] => 2
							[2] => 2
							[3] => 2
							[4] => 2
							[5] => 2
							[6] => 2
						)
					)
				)
			)
		)
	*/
?>