<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_updSubtitlesInfo"; //print_r($_POST);
	
	
	$get_modifyType = ( isset($_POST["modify_type"]) ) ? ($_POST["modify_type"]) : ("");		//NewSub, ChgOrder, ChgSub, PubSub
	
	//利用 ajax抓取資料	ipt_grabType == 1的時候，抓最新的資料；2的時候，抓全部的資料
	switch($get_modifyType) {
		case "NewSubtitles":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 			=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 	=> 2,
																								 "Subtitle_StatusR" => 3)
																					);
				echo json_encode($rtn_newSub);
			}
			break;
			
		case "AllSubtitles":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 			=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 	=> 2)
																					);
				echo json_encode($rtn_newSub);
			}
			break;
			
		case "ZenSubtitles":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 			=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 	=> 1)
																					);
				echo json_encode($rtn_newSub);
			}
			break;
			
		case "LastSubtitles":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 				=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 		=> 2,
																								 "Subtitle_StatusR" 	=> 4, 
																								 "Subtitle_LsitOrder" => 2)
																					);
				if( count($rtn_newSub) > 0) {
					echo json_encode( array(0 => $rtn_newSub[0]) );
				}
				else {
					echo json_encode( array(0 => array( "Subtitle_ID" => "", "Subtitle_Info" => "") ) );
				}
			}
			break;
			
		case "LastAddSub":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 				=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 		=> 1,
																								 "Subtitle_StatusR" 	=> 2, 
																								 "Subtitle_LsitOrder" => 3)
																					);
				if( count($rtn_newSub) > 0) {
					echo json_encode( array(0 => $rtn_newSub[0]) );
				}
				else {
					echo json_encode( array(0 => array( "Subtitle_ID" => "", "Subtitle_Info" => "") ) );
				}
			}
			break;
			
		case "LastModifySub":
			{
				$rtn_newSub = array();
				if ( $_POST["caption_ID"] == "") {
					echo json_encode($rtn_newSub);
				}
				
				$rtn_newSub = fun_getSubtitlesData(array("Caption_ID" 				=> $_POST["caption_ID"], 
																								 "Subtitle_Status" 		=> 1,
																								 "Subtitle_StatusR" 	=> 2, 
																								 "Subtitle_LsitOrder" => 4)
																					);
				if( count($rtn_newSub) > 0) {
					echo json_encode( array(0 => $rtn_newSub[0]) );
				}
				else {
					echo json_encode( array(0 => array( "Subtitle_ID" => "", "Subtitle_Info" => "") ) );
				}
			}
			break;
	}
	
	exit();
?>