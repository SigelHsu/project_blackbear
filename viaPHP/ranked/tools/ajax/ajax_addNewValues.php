<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_addNewValues"; //print_r($_POST["input"]);
	
	//exit();
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Counter_ID"] = $_POST["input"]["ID"];
		$inputData["Counter_No"] = $_POST["input"]["No"];
		$inputData["GrabInfo"] = array();
		$inputData["GrabInfo"]["NewVal"] = $_POST["input"]["GrabInfo"]["Value"]["New"];
		
		/*
		foreach($_POST["input"]["GrabInfo"]["ID"] AS $KeyNo => $GrabInfo_ID) {
			$inputData["GrabInfo"][$KeyNo]["GrabInfo_ID"] = $GrabInfo_ID;
			$inputData["GrabInfo"][$KeyNo]["Value"] = $_POST["input"]["GrabInfo"]["Value"][$KeyNo];
		}
		*/
		//print_r($inputData); exit();
		echo fun_updNewData($inputData);
	}
	
	//獲取活動資料
	function fun_updNewData( $data = array() ) {
		
		$Counter_ID = $data["Counter_ID"];
		$Counter_No = $data["Counter_No"];
			$sql = "INSERT INTO tb_grabinfo 
													(
													 Counter_ID, 
													 Grab_Values, 
													 Status, 
													 Create_Date, 
													 Modify_Date
												  )
									 VALUES (
														'".$Counter_ID."',
														'".$data["GrabInfo"]["NewVal"]."',
														'1',
														NOW(),
														NOW()
													);";
			//echo $sql."</br>";
			$result = fun_updDBData($sql);
		
		return true;
	}
	exit();
	
	/*
	ajax_addNewValues
	Array
		(
				[ID] => 1
				[No] => C000001
				[Code] => 7XHTjE
				[Target_API] => https://www.ranked-dev.com/ranked/tools/ajax/ajax_getRandomData.php
				[Grab_Frequency] => 2
				[GrabInfo] => Array
						(
								[Value] => Array
										(
												[New] => 12459498
												[0] => 123459999
												[1] => 123456999
												[2] => 123456799
												[3] => 123456789
										)

								[ID] => Array
										(
												[0] => 4
												[1] => 3
												[2] => 2
												[3] => 1
										)

						)

		)
	*/
?>