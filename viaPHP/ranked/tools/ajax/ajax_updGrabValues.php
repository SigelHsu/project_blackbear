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
		$inputData["GrabInfo"]["NewVal"] = mb_convert_kana($_POST["input"]["GrabInfo"]["Value"]["New"], 'n');
		
		foreach($_POST["input"]["GrabInfo"]["ID"] AS $KeyNo => $GrabInfo_ID) {
			$inputData["GrabInfo"][$KeyNo]["ID"] 		= $GrabInfo_ID;
			$inputData["GrabInfo"][$KeyNo]["Value"] = mb_convert_kana($_POST["input"]["GrabInfo"]["Value"][$KeyNo], 'n');
		}
		//print_r($inputData); exit();
		
		foreach($inputData["GrabInfo"] AS $Key => $Values) {
			if($Key == "NewVal" && $Values != "" ) {
				fun_updNewData($inputData);
			}
			else if($Key != "NewVal") {
				fun_updOldData($Values);
			}
		}
		return true;
	}
	
	//新增資料
	function fun_updNewData( $data = array() ) {
		
		$Counter_ID 		= $data["Counter_ID"];
		$Counter_No 		= $data["Counter_No"];
		$GrabInfo_Value = $data["GrabInfo"]["NewVal"];
		
		if(!is_numeric($GrabInfo_Value)) {
			return false;
		}
	
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
													'".$GrabInfo_Value."',
													'1',
													NOW(),
													NOW()
												);";
		//echo $sql."</br>";
		$result = fun_updDBData($sql);
		
		return true;
	}
	//修改資料
	function fun_updOldData( $data = array() ) {
		
		$GrabInfo_ID 		= (isset($data["ID"])) 	 	? ($data["ID"]) 		: (0);
		$GrabInfo_Value = (isset($data["Value"])) ? ($data["Value"]) 	: (0);
		
		if($GrabInfo_ID == 0 || !is_numeric($GrabInfo_Value)) {
			return false;
		}
		
		$sql = "UPDATE tb_grabinfo 
							 SET Grab_Values = '".$GrabInfo_Value."', 
									 Modify_Date = NOW() 
						 WHERE GrabInfo_ID = '".$GrabInfo_ID."'; ";
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
	/*
		"Array(
    [Counter_ID] => 1
    [Counter_No] => C000001
    [GrabInfo] => Array
        (
            [NewVal] => 
            [0] => Array
                (
                    [GrabInfo_ID] => 42
                    [Value] => 1234567
                )

            [1] => Array
                (
                    [GrabInfo_ID] => 40
                    [Value] => 123456789
                )

            [2] => Array
                (
                    [GrabInfo_ID] => 18
                    [Value] => 23499999
                )

            [3] => Array
                (
                    [GrabInfo_ID] => 17
                    [Value] => 23459999
                )

            [4] => Array
                (
                    [GrabInfo_ID] => 16
                    [Value] => 23456999
                )

            [5] => Array
                (
                    [GrabInfo_ID] => 15
                    [Value] => 23456799
                )

            [6] => Array
                (
                    [GrabInfo_ID] => 14
                    [Value] => 23456789
                )

            [7] => Array
                (
                    [GrabInfo_ID] => 11
                    [Value] => 1889189489
                )

            [8] => Array
                (
                    [GrabInfo_ID] => 10
                    [Value] => 158156189489
                )

            [9] => Array
                (
                    [GrabInfo_ID] => 5
                    [Value] => 146156189489
                )

            [10] => Array
                (
                    [GrabInfo_ID] => 4
                    [Value] => 123459999
                )

            [11] => Array
                (
                    [GrabInfo_ID] => 3
                    [Value] => 123456999
                )

            [12] => Array
                (
                    [GrabInfo_ID] => 2
                    [Value] => 123456799
                )

            [13] => Array
                (
                    [GrabInfo_ID] => 1
                    [Value] => 123456789
                )

        )
	*/
?>