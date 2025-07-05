<?php
	require_once("../../tools/php/tools_setting.php");
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_updFileData"; print_r($_POST); print_r(json_decode($_POST["input"], true)); print_r($_FILES); exit();
	
	$inputData = array();
	//整理送入的資料
	{
		
		$dir_target = "img";
		$postData = json_decode($_POST["input"], true);
		$fileData = $_FILES["file"];
		$fileName = trim(trim(stripslashes(json_encode($fileData["name"]))), "\"");	//echo "fileName: ".$fileName; exit();
		
		$inputData["Event_ID"] 	= $postData["Event_ID"];
		$inputData["Event_No"] 	= $postData["Event_No"];
		$inputData["Purpose"] 	= $postData["Purpose"];
		$dir_Purpose = $inputData["Event_No"].( ($inputData["Purpose"] != "Event") ? ("/".$inputData["Purpose"]) : ("") );
		
		$fileLoc = $dir_root."/".$dir_target."/".$dir_Purpose."/";
		$absLink = $html_root."/".$dir_target."/".$dir_Purpose."/";
		
		fun_mkdir($fileLoc, "0777");	//建立資料夾，並設置資料夾權限	//echo "fileLoc ".$fileLoc;
		if (file_exists($fileLoc.$fileName)){
			echo json_encode( array("Loc" => $absLink.$fileName) );
			exit();
		}
		else {
			$from_fileLoc = $fileData["tmp_name"];
			$dest_fileLoc = $fileLoc.basename($fileName);

			# 將檔案移至指定位置
			if( move_uploaded_file($from_fileLoc, $dest_fileLoc) ) {
				echo json_encode( array("Loc" => $absLink.$fileName) );
				exit();
			}
		}
		
		exit();
	}
	
	exit();
	function fun_mkdir($DirLoc = "", $setPeri = "0777") {
		$aryDirList = explode("/", $DirLoc);		//print_r($aryDirList);
		$tmpDirLoc 	= "";
		
		foreach($aryDirList AS $Key => $Values) {
			$tmpDirLoc .= ($tmpDirLoc == "") ? ($Values) : ("/".$Values);
			if($Values != "D:" && $Values != "") {
				
				if(!is_dir($tmpDirLoc)) {
					mkdir($tmpDirLoc, $setPeri);
				}
				else {
					chmod($tmpDirLoc, $setPeri);
				}
			}
		}
		return true;
	}
	
	/*
		ajax_updFileData
		Array (
			[input] => {"Event_No":"E000001","Event_ID":"1"}
		)
		Array (
			[Event_No] => E000001
			[Event_ID] => 1
			[Purpose]  => Event
		)
		Array (
			[file] => Array (
				[name] => horse.png
				[type] => image/png
				[tmp_name] => D:\xampp\tmp\php545E.tmp
				[error] => 0
				[size] => 38511
			)
		)
	*/
?>