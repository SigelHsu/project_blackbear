<?php
	//require_once("../../tools/php/tools_setting.php");
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	
	$data = array();
	$counterCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");
	$data["counter"] 	= fun_getCounterData(array("Code" => $counterCode));	//獲取計數器資料
	$data["info"] 		= fun_getGrabInfoData($data["counter"]["ID"]);				//獲取活動排序規則
	$data["setting"] 	= $data["counter"]["Setting"];
	$data["values"] 	= $data["info"][0]["Grab_Values"];
	echo json_encode($data);
	exit();
	
	
	/*
	tb_counter
	Counter_ID, Counter_No, Counter_Title, Target_API, Setting, Status, Create_Date, Modify_Date
	
	tb_counter.Setting => {
		"background_color" 	: "black",
		"font_color" 				: "white",
		"font_size" 				: "xxx-large",
		"padding" 					: array(5, 5, 5, 5),
		"set_padding" 			: "5px 5px 5px 5px",
		"margin" 						: array(0, 5, 0, 5),
		"set_margin" 				: "0px 5px 0px 5px",
		"set_intervalTime" 	: 3,
		"set_minLength" 		: 15,
		"set_startDuration" : 0.2,
		"set_perDuration" 	: 0.1,
		"set_maxDuration" 	: 1,
	}
	
	CREATE TABLE `db_ranking`.`tb_counter` (
		`Counter_ID` INT NOT NULL AUTO_INCREMENT , 
		`Counter_No` TEXT NOT NULL , 
		`Counter_Title` TEXT NULL , 
		`Target_API` TEXT NULL , 
		`Setting` TEXT NULL COMMENT 'tb_counter.Setting => {\r\n \"background_color\" : \"black\",\r\n \"font_color\" : \"white\",\r\n \"font_size\" : \"xxx-large\",\r\n \"padding\" : array(5, 5, 5, 5),\r\n \"set_padding\" : \"5px 5px 5px 5px\",\r\n \"margin\" : array(0, 5, 0, 5),\r\n \"set_margin\" : \"0px 5px 0px 5px\",\r\n \"set_intervalTime\" : 3,\r\n \"set_minLength\" : 15,\r\n \"set_startDuration\" : 0.2,\r\n \"set_perDuration\" : 0.1,\r\n \"set_maxDuration\" : 1,\r\n }' , 
		`Status` INT NOT NULL , `Create_Date` DATETIME NOT NULL , `Modify_Date` DATETIME NOT NULL , PRIMARY KEY (`Counter_ID`)) ENGINE = InnoDB;
	
	tb_grabinfo
	GrabInfo_ID, Counter_ID, Grab_Info, Grab_Values, Status, Create_Date, Modify_Date
	
	CREATE TABLE `db_ranking`.`tb_grabinfo` (
		`GrabInfo_ID` INT NOT NULL , 
		`Counter_ID` INT NOT NULL , 
		`Grab_Values` TEXT NOT NULL , 
		`Grab_Info` TEXT NOT NULL , 
		`Status` INT NOT NULL , 
		`Create_Date` DATETIME NOT NULL , 
		`Modify_Date` DATETIME NOT NULL ) ENGINE = InnoDB;
	
	
	*/
?>

