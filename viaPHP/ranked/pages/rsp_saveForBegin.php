<?php
	// 將初始資料寫入到 Log中紀錄
	// 需判斷 Turn1裡面是否已經有 Log，若沒有就生成新的
?>
<?php
	require_once("../tools/php/setting_llkBasic.php");
	require_once("../tools/php/setting_llkDecide.php");
	require_once("../tools/php/setting_llkRoles.php");
	require_once("../tools/php/setting_llkStatus.php");
	require_once("../tools/php/tools_common.php");
?>
<?php
	require_once("../tools/php/class_log.php");
	//print_r($_POST);
?>
<?php
	
	$setData = $ary_roleList = array();
	$setData = array(
		"GameID" 			=> $_POST["set"]["GameID"],
		"DateOfPlay" 	=> $_POST["set"]["PlayDate"],
		"TaxType" 		=> $_POST["set"]["TaxType"],
		"Language" 		=> "CH",
		"KingsHealth" => "1",
		"Heir" 				=> "R02",
		"DecicionBy" 	=> "R00",
		"HealthLv" 		=> "H00",
		"MobiliLv" 		=> "M00",
		"RevellLv" 		=> "P00",
		"Turn"				=> "1",
		"Phase"				=> "0",
		"Step"				=> "0",
	);

	foreach($_POST["input"]["Begin"] AS $RoleKey => $RoleValue) {
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
        "Temp"	=> array(),
      ),
			"Status" => array(),
      "Allowance" => array(
        "Basic" 		=> $RoleValue["Allowance"]["Basic"],
        "Tax"				=> $RoleValue["Allowance"]["Tax"],
        "Templary" 	=> array()
      ),
      "Intrigue" => array(
        "Used" 		=> array(),
        "Pending"	=> array(),
      ),
			"Allot" => $ary_setRoleList[$RoleKey]["Allot"]
		);
		
		foreach(explode(",", $RoleValue["Status"]) AS $Key => $Value) {
			$ary_roleList[$RoleKey]["Status"][$Key] = trim($Value);
		}
	} 																	//print_r($set); 	print_r($ary_roleList);	exit();
	
	$cls_withLog = new cls_withLog;
	$cls_withLog->fun_writeIntoLog("./../GameLog/".$setData["GameID"]."/Setting", "Set_Start", $setData);
	if(!file_exists( "./../GameLog/".$setData["GameID"]."/Turn1/Log_Set.log" )) {
		$cls_withLog->fun_writeIntoLog("./GameLog/".$setData["GameID"]."/Turn1", "Log_Set", $setData);
	}
	$cls_withLog->fun_writeIntoLog("./../GameLog/".$setData["GameID"]."/Setting", "Roles_Start", $ary_roleList);
	if(!file_exists( "./../GameLog/".$setData["GameID"]."/Turn1/Log_Roles.log" )) {
		$cls_withLog->fun_writeIntoLog("./../GameLog/".$setData["GameID"]."/Turn1", "Log_Roles", $ary_roleList);
	}
	exit();
?>