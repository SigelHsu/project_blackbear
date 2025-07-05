<?php
	// 先讀取 Log紀錄
	// 然後將所輸入的資料，經過 class_turn處理後，
	// 將結果寫入到 Log中紀錄
?>
<?php
	require_once("../tools/php/setting_llkBasic.php");
	require_once("../tools/php/setting_llkDecide.php");
	require_once("../tools/php/setting_llkHealth.php");
	require_once("../tools/php/setting_llkIntrigue.php");
	require_once("../tools/php/setting_llkMobilization.php");
	require_once("../tools/php/setting_llkRebellion.php");
	require_once("../tools/php/setting_llkRoles.php");
	require_once("../tools/php/setting_llkStatus.php");
	require_once("../tools/php/tools_common.php");
?>
<?php
	require_once("../tools/php/class_allowance.php");
	require_once("../tools/php/class_analyzer.php");
	require_once("../tools/php/class_audience.php");
	require_once("../tools/php/class_council.php");
	require_once("../tools/php/class_decide.php");
	require_once("../tools/php/class_diplomacy.php");
	require_once("../tools/php/class_favor.php");
	require_once("../tools/php/class_intrigue.php");
	require_once("../tools/php/class_log.php");
	require_once("../tools/php/class_role.php");
	require_once("../tools/php/class_sortary.php");
	require_once("../tools/php/class_status.php");
	require_once("../tools/php/class_takeary.php");
	require_once("../tools/php/class_turn.php");
?>
<?php
	//print_r($_POST);	exit();
	//處理相關資訊
	$setData = $ary_roleList = $returnData = array();
	$inputSentense = $_POST["inputSentense"];
	$setData = array(
		"GameID" 			=> $_POST["set"]["GameID"],
		"DateOfPlay" 	=> $_POST["set"]["PlayDate"],
		"TaxType" 		=> $_POST["set"]["TaxType"],
		"Language" 		=> "CH",
		"KingsHealth" => $_POST["set"]["KingsHealth"],
		"Heir" 				=> $_POST["set"]["Heir"],
		"DecicionBy" 	=> $_POST["set"]["DecicionBy"],
		"HealthLv" 		=> $_POST["set"]["HealthLv"],
		"MobiliLv" 		=> $_POST["set"]["MobiliLv"],
		"RevellLv" 		=> $_POST["set"]["RevellLv"],
		"Turn"				=> $_POST["set"]["Turn"],
		"Phase"				=> $_POST["set"]["Phase"],
		"Step"				=> $_POST["set"]["Step"],
	);

	foreach($_POST["input"] AS $RoleKey => $RoleValue) {
		$ary_roleList[$RoleKey] = array(
			"Role" => array(
				"Code" 	=> $RoleValue["Role"]["ID"],
				"Name" 	=> $ary_setRoleList[$RoleKey]["Title"]["Basic"],
				"State" => $RoleValue["Role"]["State"]
			),
			"Player" 	=> $RoleValue["Player"],
			"Color" 	=> $RoleValue["Color"],
      "Favor" => array(
        "Basic" => $RoleValue["Favor"]["Basic"],
        "Temp"	=> json_decode($RoleValue["Favor"]["Temp"], TRUE),
      ),
			"Status" => array(),
      "Allowance" => array(
        "Basic" 		=> $RoleValue["Allowance"]["Basic"],
        "Tax"				=> json_decode($RoleValue["Allowance"]["Tax"], TRUE),
        "Templary" 	=> array()
      ),
      "Intrigue" => array(
        "Used" 		=> array(),
        "Pending"	=> json_decode($RoleValue["Intrigue"]["Pending"], TRUE),
      ),
			"Allot" => $ary_setRoleList[$RoleKey]["Allot"]
		);
		
		foreach(explode(",", $RoleValue["Status"]) AS $Key => $Value) {
			$ary_roleList[$RoleKey]["Status"][$Key] = trim($Value);
		}
		foreach(explode(",", $RoleValue["Intrigue"]["Used"]) AS $Key => $Value) {
			$ary_roleList[$RoleKey]["Intrigue"]["Used"][$Key] = trim($Value);
		}
	}
	
	//echo "rsp_SentenseSend.php: ".$inputSentense."</br>"; 	print_r($setData);		echo "</br>"; 	print_r($ary_roleList);		echo "</br>";		exit();

	//將原有的 Log資訊讀取出來，方便後續添加寫入
	{
		if($setData["Turn"] == 0) {
			exit();
		}
		$cls_withLog = new cls_withLog;

		// $fileLoc = "./../GameLog/".$setData["GameID"]."/Turn".$setData["Turn"];
		// $log["Sentense"] 	= $cls_withLog->fun_readFromLog($fileLoc, "Log_Sentense");
		// $log["Record"] 		= $cls_withLog->fun_readFromLog($fileLoc, "Log_Record"); 												//print_r($log);
		// $log["Sentense"] 	= ( $log["Sentense"] != "" ) 	? ( $log["Sentense"] ) 	: ( array() );
		// $log["Record"] 		= ( $log["Record"] != "" ) 		? ( $log["Record"] ) 		: ( array() );
		// $log["Sentense"][$setData["Phase"]] 	= ( $log["Sentense"][$setData["Phase"]] != "" ) 	? ( $log["Sentense"][$setData["Phase"]] ) 	: ( array() );
		// $log["Record"][$setData["Phase"]] 		= ( $log["Record"][$setData["Phase"]] != "" ) 		? ( $log["Record"][$setData["Phase"]] ) 		: ( array() );
	}

	//會議期(Phase 3)比較是個特例，因為每項議題會有6個步驟(第 6步(Step 6)為完結)
	//主要是想將會議期期間，每項議題放在一起
	// if($setData["Phase"] == 3) {
	// 	$getLastPeti = end($log["Sentense"][$setData["Phase"]]);
	// 	$log["Sentense"][$setData["Phase"]][$getLastPeti] = ($log["Sentense"][$setData["Phase"]][$getLastPeti] != "") ? ($log["Sentense"][$setData["Phase"]][$getLastPeti]) : ( array() );
	// 	$log["Record"][$setData["Phase"]][$getLastPeti] 	= ($log["Record"][$setData["Phase"]][$getLastPeti] != "") 	? ($log["Record"][$setData["Phase"]][$getLastPeti]) 	: ( array() );
		
	// 	//判斷最後一項議題，是否已經有 Step 6(效果結算)的紀錄，是就新建一項議題，否就延續下去
	// 	$newLastPeti = $getLastPeti;
	// 	if(end($log["Sentense"][$setData["Phase"]][$getLastPeti]) == "6") {
	// 		$newLastPeti = $getLastPeti + 1;
	// 		$log["Sentense"][$setData["Phase"]][$newLastPeti] = $log["Record"][$setData["Phase"]][$newLastPeti] = array();
	// 	}
	// 	{
	// 		$log["Sentense"][$setData["Phase"]][$newLastPeti][$setData["Step"]] 	= $inputSentense;
	// 		$cls_withTurn 																												= new cls_withTurn($ary_roleList, array("Turn" => $setData["Turn"]));
	// 		$resData 																															= $cls_withTurn->fun_withPhases( $setData["Phase"], $inputSentense, array("PetiStep" => $setData["Step"]) );
	// 		$log["Record"][$setData["Phase"]][$newLastPeti][$setData["Step"]] 		= $resData;

	// 		if($setData["Step"] == "3") {
	// 			$cls_withTurn 																											= new cls_withTurn($resData["RoleResult"], array("Turn" => $setData["Turn"]));
	// 			$resData 																														= $cls_withTurn->fun_withPhases( $setData["Phase"], $resData["WithPetit"], array("PetiStep" => 4) );
	// 			$log["Record"][$setData["Phase"]][$newLastPeti][4] 									= $resData;

	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 								= "計算結果：(大使會計算在相反票數)</br>";
	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 							 .= "　總淨寵愛度為：".$resData["WithPetit"]["Step4"]["Pure"]."；</br>";
	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 							 .= "　贊成方共 ".$resData["WithPetit"]["Step4"]["VoteYes"]."票，";
	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 							 .= "其淨寵愛為：".$resData["WithPetit"]["Step4"]["ForYes"]."；</br>";
	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 							 .= "　反對方共 ".$resData["WithPetit"]["Step4"]["VoteNo"]."票，";
	// 			$log["Sentense"][$setData["Phase"]][$newLastPeti][4] 							 .= "其淨寵愛為：".$resData["WithPetit"]["Step4"]["ForNo"]."。</br>";

	// 			$setData["Step"] = 4;
	// 		}
	// 	}
	// }
	// else {
	// 	$log["Sentense"][$setData["Phase"]][] 	= $inputSentense;
	// 	$cls_withTurn 													= new cls_withTurn($ary_roleList, array("Turn" => $setData["Turn"]));
	// 	$resData 																= $cls_withTurn->fun_withPhases( $setData["Phase"], $inputSentense, array("PetiStep" => $setData["Step"]) );
	// 	$log["Record"][$setData["Phase"]][] 		= $resData;
	// }					//print_r($resData);		//print_r($log);			exit();

	$returnData["SendData"]["Set"] 			= $setData;																													//從前端送入，以陣列形式儲存的回合設置紀錄
	$returnData["SendData"]["Role"] 		= $ary_roleList;																										//從前端送入，以陣列形式儲存的玩家角色紀錄
	$returnData["SendData"]["Sentense"] = $inputSentense;																										//從前端送入，以字串形式儲存的輸入字串紀錄
	$returnData["ResultData"]["Set"] 		= $setData;																													//處理後要返回，以陣列形式儲存的回合設置紀錄(用來取代 form_PlayRecord原有的)
	$returnData["ResultData"]["Role"] 	= $ary_roleList;																										//處理後要返回，以陣列形式儲存的玩家角色紀錄(用來取代 box_orderMod原有的)
	// $returnData["ResultData"]["Log"]		= fun_showLogSentense($setData["Turn"], $log["Sentense"]);					//處理後要返回，以字串形式儲存的輸入字串紀錄(用來取代 box_RecordLogList)
	// $returnData["Log"]["Sentense"]			= $log["Sentense"];																									//處理後，以陣列形式儲存的輸入字串紀錄
	// $returnData["Log"]["Record"]				= $log["Record"];																										//處理後，以陣列形式儲存的回合紀錄

	//重新處理角色順序
	{
		$cls_withTurnUPD 									= new cls_withTurn($ary_roleList, array("Turn" => $setData["Turn"]));
		$RolesOrder = $cls_withTurnUPD->fun_withPhases("R");
		$RolesOrder["Audience"] 	= ( $RolesOrder["OrderAudi"] !== "" ) 						? ($RolesOrder["OrderAudi"]) 							: ("");
		$RolesOrder["AutoPeti"] 	= ( $RolesOrder["OrderCoun"]["AutoPeti"] !== "" ) ? ($RolesOrder["OrderCoun"]["AutoPeti"]) 	: ("");
		$RolesOrder["Petition"] 	= ( $RolesOrder["OrderCoun"]["OrdCoun"] !== "" ) 	? ($RolesOrder["OrderCoun"]["OrdCoun"]) 	: ("");
		$RolesOrder["Vote"] 			=	( $RolesOrder["OrderCoun"]["OrdVote"] !== "" ) 	? ($RolesOrder["OrderCoun"]["OrdVote"]) 	: ("");				//print_r($RolesOrder);
		$returnData["ResultData"]["RolesOrder"] = $RolesOrder;	//處理後要返回，以陣列並字串形式儲存的玩家順序紀錄(用來取代 box_orderAudi|box_orderPeti|box_orderVote)
	}

	//echo json_encode($returnData["ResultData"]);	//print_r($returnData);			exit();
	
	//將資料寫入到 Log裡面(這邊會取代舊有的資料)
	$cls_withLog->fun_writeIntoLog($fileLoc, "Log_Set", $returnData["SendData"]["Set"]);				//以陣列形式儲存的回合設置紀錄，寫入到 Log檔案中
	$cls_withLog->fun_writeIntoLog($fileLoc, "Log_Roles", $returnData["ResultData"]["Role"]);		//以陣列形式儲存的玩家角色紀錄，寫入到 Log檔案中
	// $cls_withLog->fun_writeIntoLog($fileLoc, "Log_Sentense", $returnData["Log"]["Sentense"]);			//以陣列形式儲存的輸入字串紀錄，寫入到 Log檔案中
	// $cls_withLog->fun_writeIntoLog($fileLoc, "Log_Record", $returnData["Log"]["Record"]);					//以陣列形式儲存的所有回饋紀錄，寫入到 Log檔案中

	//如果 Phase為 4(End)，需要將部分資料寫到下一輪
	if($setData["Phase"] == "4") {
		$setNextData = array(
			"GameID" 			=> $setData["GameID"],
			"DateOfPlay" 	=> $setData["PlayDate"],
			"TaxType" 		=> $setData["TaxType"],
			"Language" 		=> $setData["Language"],
			"KingsHealth" => $setData["KingsHealth"],
			"Heir" 				=> $setData["Heir"],
			"DecicionBy" 	=> $setData["DecicionBy"],

			"HealthLv" 		=> $setData["HealthLv"],
			"MobiliLv" 		=> $setData["MobiliLv"],
			"RevellLv" 		=> $setData["RevellLv"],
			"Turn"				=> ($setData["Turn"] + 1),
			"Phase"				=> 0,
			"Step"				=> 0,
		);
		$nextFileLoc = "./../GameLog/".$setData["GameID"]."/Turn".$setNextData["Turn"];
		$cls_withLog->fun_writeIntoLog($nextFileLoc, "Log_Set", $setNextData);
		$cls_withLog->fun_writeIntoLog($nextFileLoc, "Log_Roles", $returnData["ResultData"]["Role"]);
		$returnData["ResultData"]["Set"] 			= $setNextData;
	}

	echo json_encode($returnData["ResultData"]);			//只有這部分會用到
	exit();
?>