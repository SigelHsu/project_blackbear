<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_updSubtitlesInfo"; //print_r($_POST);
	
	$get_modifyType = ( isset($_POST["modify_type"]) ) ? ($_POST["modify_type"]) : ("");		//NewSub, ChgOrder, ChgSub, PubSub
	
	switch($get_modifyType) {
		case "NewSub":			//新增字幕內容
			{
				if ( $_POST["input"]["Subtitle"]["Info"]["New"] == "") {
					return false;
				}
				
				//整理送入的資料
				$inputData["Caption_ID"] = $_POST["input"]["ID"];
				$inputData["Caption_No"] = $_POST["input"]["No"];
				$inputData["Subtitle"] = array();
				$inputData["Subtitle"]["NewSub"] = array(
					"ID" 			=> 0,
					"Order" 	=> ( $_POST["input"]["Subtitle"]["Order"]["New"] ) 	? ( mb_convert_kana($_POST["input"]["Subtitle"]["Order"]["New"], 'n') ) : (99999999),
					"Time" 		=> ( $_POST["input"]["Subtitle"]["Time"]["New"]  ) 	? ( $_POST["input"]["Subtitle"]["Time"]["New"] ) 												: (""),
					"Info" 		=> ( $_POST["input"]["Subtitle"]["Info"]["New"]  ) 	? ( htmlspecialchars($_POST["input"]["Subtitle"]["Info"]["New"]) ) 			: (""), 
					"Other" 	=> array(
						"create" 	=> array(),
						"modify" 	=> array(),
						"publish" => array()
					)
				);
				$inputData["Subtitle"]["NewSub"]["Other"]["create"][] = array(
					"id" 		=> '0', 
					"user" 	=> 'Blackbear',
					"time" 	=> date("Y-m-d H:i:s"),
					"info" 	=> $inputData["Subtitle"]["NewSub"]["Info"]
				);
				
				fun_insNewSubtitleData($inputData);
				return true;
			}
			break;
			
		case "ChgOrder":		//修改字幕順序
			{
				if ( $_POST["input"]["ID"] == "") {
					return false;
				}
				print_r($_POST); 
				return true;
				$caption_ID 			= $_POST["input"]["ID"];
				$tmp_ListSubtitle	= $_POST["input"]["Subtitle"];
				$subtitle_List 		= array();
				//整理送入的資料POrder
				foreach($tmp_ListSubtitle["ID"] as $Key => $subtitle_ID) {
					$subtitle_List[$Key]["Order"] 	= ($Key + 1);
					$subtitle_List[$Key]["ID"] 			= $subtitle_ID;
					$subtitle_List[$Key]["Info"] 		= $tmp_ListSubtitle["Info"][$Key];
					$subtitle_List[$Key]["Time"] 		= $tmp_ListSubtitle["Time"][$Key];
					$subtitle_List[$Key]["Status"] 	= $tmp_ListSubtitle["Status"][$Key];
					
					$subtitle_List[$Key]["Other"] 	= array(
						"id" 		=> '2', 
						"user" 	=> 'ChgOrder',
						"time" 	=> date("Y-m-d H:i:s"),
						"order"	=> "from ".$tmp_ListSubtitle["Order"][$Key]." to ".$Key,
						"info" 	=> $tmp_ListSubtitle["Info"][$Key]
					);
					print_r($subtitle_List);
					fun_updOldSubtitleData($subtitle_List[$Key]);
				}
				
				//print_r($subtitle_List);
				return true;
			}
			break;
			
		case "ChgSub":			//修改字幕內容
			{
				if ( $_POST["target_ID"] == "" || $_POST["subtitle_Info"] == "") {
					return false;
				}
				
				//整理送入的資料
				$inputData["target_ID"] = $_POST["target_ID"];
				$inputData["Subtitle"] = array();
				$inputData = array(
					"ID" 			=> $_POST["target_ID"],
					"Order" 	=> ( $_POST["subtitle_Order"] ) ? ( mb_convert_kana($_POST["subtitle_Order"], 'n') ) : (99999999),
					"Time" 		=> ( $_POST["subtitle_Time"]  ) ? ( $_POST["subtitle_Time"] ) 											 : (""),
					"Info" 		=> ( $_POST["subtitle_Info"]  ) ? ( htmlspecialchars($_POST["subtitle_Info"]) ) 		 : ("")
				);
				$inputData["Other"] = array(
					"id" 		=> '1', 
					"user" 	=> 'Bigbird',
					"time" 	=> date("Y-m-d H:i:s"),
					"info" 	=> $inputData["Info"]
				);
				
				fun_updOldSubtitleData($inputData);
				return true;
			}
			break;
			
		case "PubSub":		//發佈字串
			{
				if ( $_POST["target_ID"] == "" ) {
					return false;
				}
				
				//整理送入的資料
				$inputData["target_ID"] = $_POST["target_ID"];
				$inputData["Subtitle"] = array();
				$inputData = array(
					"Cap_ID"	=> $_POST["caption_ID"],
					"ID" 			=> $_POST["target_ID"],
					"Order" 	=> ( $_POST["subtitle_Order"] ) ? ( mb_convert_kana($_POST["subtitle_Order"], 'n') ) : (99999999),
					"Time" 		=> ( $_POST["subtitle_Time"]  ) ? ( $_POST["subtitle_Time"] ) 											 : (""),
					"Info" 		=> ( $_POST["subtitle_Info"]  ) ? ( htmlspecialchars($_POST["subtitle_Info"]) ) 		 : ("")
				);
				$inputData["Other"] = array(
					"id" 		=> '2', 
					"user" 	=> 'LittleOne',
					"time" 	=> date("Y-m-d H:i:s"),
					"info" 	=> $inputData["Info"]
				);																								//print_r($inputData);
				fun_publishSubtitleData($inputData);
				return true;
			}
			break;
			
		case "Published":		//當某個字幕推送完畢後，需要執行這段，將 tb_subtitles.status改成 3
			{
				if ( $_POST["target_ID"] == "") {
					return false;
				}
				
				fun_publishedSubtitleData( array("ID" => $_POST["target_ID"]) );
				return true;
			}
			break;
	}
	
	exit();
?>
<?php
	//新增字幕
	function fun_insNewSubtitleData( $data = array() ) {
		
		$Caption_ID 		= $data["Caption_ID"];
		$Subtitle_Info 	= $data["Subtitle"]["NewSub"];
	
		$sql = "INSERT INTO tb_subtitles 
												(
													Caption_ID, 
													Subtitle_Order, 
													Time_Tag, 
													Subtitle_Info, 
													Other_Info, 
													Status, 
													Create_Date, 
													Modify_Date
												)
								 VALUES (
													'".$Caption_ID."',
													'".$Subtitle_Info["Order"]."',
													'".$Subtitle_Info["Time"]."',
													'".$Subtitle_Info["Info"]."',
													'".json_encode($Subtitle_Info["Other"])."',
													'1',
													NOW(),
													NOW()
												);";
		//echo $sql."</br>";
		$result = fun_insDBData($sql);
		return $result;
	}
	
	//修改字幕
	function fun_updOldSubtitleData( $data = array() ) {
		
		$Subtitle_ID 	 		= (isset($data["ID"])) 	 		? ($data["ID"]) 		: (0);
		$Subtitle_Info 		= (isset($data["Info"])) 		? ($data["Info"]) 	: ('');
		$Subtitle_Order 	= (isset($data["Order"])) 	? ($data["Order"]) 	: (99999999);
		$Subtitle_TimeTag = (isset($data["Time"])) 		? ($data["Time"]) 	: ('');
		$Subtitle_Other 	= (isset($data["Other"])) 	? ($data["Other"]) 	: (array());
		
		if($Subtitle_ID == 0 || $Subtitle_Info == "") {
			return false;
		}
		$sql = "UPDATE tb_subtitles 
							 SET Subtitle_Order = '".$Subtitle_Order."', 
									 Time_Tag 			= '".$Subtitle_TimeTag."', 
									 Subtitle_Info 	= '".$Subtitle_Info."', 
									 Other_Info 		= JSON_ARRAY_APPEND(other_info, '$.modify', '".json_encode($Subtitle_Other)."'), 
									 Modify_Date 		= NOW() 
						 WHERE Subtitle_ID = '".$Subtitle_ID."'; ";
		//echo $sql."</br>";
		$result = fun_updDBData($sql);	//print_r($result);
		
		return true;
	}
	
	//發佈字幕
	function fun_publishSubtitleData( $data = array() ) {
		//echo "fun_publishSubtitleData";
		$Subtitle_ID 	 		= (isset($data["ID"])) 	 		? ($data["ID"]) 		: (0);
		$Subtitle_Info 		= (isset($data["Info"])) 		? ($data["Info"]) 	: ('');
		$Subtitle_sOrder 	= (isset($data["Order"])) 	? ($data["Order"]) 	: (99999999);
		$Subtitle_TimeTag = (isset($data["Time"])) 		? ($data["Time"]) 	: ('');
		$Subtitle_Other 	= (isset($data["Other"])) 	? ($data["Other"]) 	: (array());
		
		if($Subtitle_ID == 0 || $Subtitle_Info == "") {
			return false;
		}
		$data_subtitles 	= fun_getSubtitlesData( array("Caption_ID" => $data["Cap_ID"], "Subtitle_Status" => 2) );
		$Subtitle_pOrder 	= (count($data_subtitles) + 1);
		
		$sql = "UPDATE tb_subtitles 
							 SET Subtitle_Order = '".$Subtitle_sOrder."', 
									 Publish_Order 	= '".$Subtitle_pOrder."', 
									 Time_Tag 			= '".$Subtitle_TimeTag."', 
									 Subtitle_Info 	= '".$Subtitle_Info."',
									 Other_Info 		= JSON_ARRAY_APPEND(other_info, '$.modify', '".json_encode($Subtitle_Other)."'),
									 Status 				= 2, 
									 Modify_Date 		= NOW() 
						 WHERE Subtitle_ID = '".$Subtitle_ID."'; ";
		//echo $sql."</br>";
		$result = fun_updDBData($sql);
		
		return true;
	}
	
	//已發佈字幕
	function fun_publishedSubtitleData( $data = array() ) {
		$Subtitle_ID 	 		= (isset($data["ID"])) 	 		? ($data["ID"]) 		: (0);
		
		if($Subtitle_ID == 0) {
			return false;
		}
		$data_subtitles = fun_getSubtitlesData( array("Subtitle_ID" => $Subtitle_ID) );
		
		$inputData["Subtitle"] = array();
		$inputData["Other"] = array(
			"id" 		=> '3', 
			"user" 	=> 'AutoMachine',
			"time" 	=> date("Y-m-d H:i:s"),
			"info" 	=> $data_subtitles[0]["Subtitle_Info"]
		);
		
		$sql = "UPDATE tb_subtitles 
							 SET Other_Info 		= JSON_ARRAY_APPEND(other_info, '$.modify', '".json_encode($inputData["Other"])."'),
									 Status 				= 3, 
									 Modify_Date 		= NOW() 
						 WHERE Subtitle_ID = '".$Subtitle_ID."'; ";			//echo $sql."</br>";
		$result = fun_updDBData($sql);
		
		return true;
	}
	
	exit();
?>