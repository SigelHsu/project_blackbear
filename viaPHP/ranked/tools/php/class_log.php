<?php
	//Log處理(地位卡因為可以重複使用，因此只能記錄到 Log)、外交期(基本上就是 Log)、會議期處理 <-因為這部分需要處理讀檔寫檔，想說最後再處理
	//再一個遊戲開始前的設置(將 setting_llkRoles.php的 $ary_setRoleList部分資料，添加到 $ary_roleList裡面)

	class cls_withLog {
		private $p_orginalAry;
		private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			// global $set_round;
			// $this->p_setRound = $set_round;
			// global $set_turn;
			// $this->p_setTurn = $set_turn;
			// $this->p_orginalAry = $inputAry;
			// $this->fun_setInputAry($inputAry, $settingAry);						//print_r($inputAry);
			// $this->fun_setReturnAry($inputAry);
		}

		/*
		// private function fun_setInputAry($inputAry = array(), $settingAry = array()) {
		// 	if( count($inputAry) != 0 ) {
		// 		$this->p_orginalAry = $inputAry;
		// 	}

		// 	// if( isset($settingAry["Round"]) ) {
		// 	// 	$this->p_setRound = $settingAry["Round"];
		// 	// }
		// 	if( isset($settingAry["Turn"]) ) {
		// 		$this->p_setTurn = $settingAry["Turn"];
		// 	}
		// }
		// private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
		// 	if(!empty($outputTag)) {
		// 		$this->p_orginalAry[$outputTag] = $inputAry;
    //     $this->fun_setReturnAry($this->p_orginalAry[$outputTag], $outputTag);
		// 	}
		// 	else {
		// 		$this->p_orginalAry = $inputAry;
    //     $this->fun_setReturnAry($this->p_orginalAry);
		// 	}
		// }
		// private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
		// 	if(!empty($outputTag)) {
		// 		$this->p_returnAry[$outputTag] = $inputAry;
		// 	}
		// 	else {
		// 		$this->p_returnAry = $inputAry;
		// 	}
		// }
		*/

		//https://www.w3schools.com/php/php_file_create.asp
		public function fun_writeIntoLog ($set_FileLoc = "", $set_FileName = "", $set_FileInfo = array()) {			
			//echo "</br> fun_writeIntoLog </br>";
			$this->fun_mkdirForLog($set_FileLoc);

			$set_FullFileLoc  = "";
			$set_FullFileLoc .= ( substr($set_FileLoc, -1) === "/" ) ? ($set_FileLoc) 	: ($set_FileLoc."/");
			$set_FullFileLoc .= ($set_FileName.".log");					//$set_FullFileLoc .= ( preg_match("/./", $set_FileName) ) ? ($set_FileName) 	: ($set_FileName.".log");

			//echo "set_FullFileLoc: ".$set_FullFileLoc."</br>";
			$logFile 		= fopen($set_FileLoc."/".$set_FileName.".log", "w") or die("Unable to open file!");
			$insertTXT 	= json_encode($set_FileInfo);
			fwrite($logFile, $insertTXT);
			fclose($logFile);
			//return $rtnAry;
		}

		//https://www.w3schools.com/php/func_filesystem_readfile.asp
		//https://www.php.net/manual/en/function.file-get-contents.php
		//https://liaosankai.pixnet.net/blog/post/27533126 			PHP 取得檔案的副檔名(PHP Get File Extension) @ ::SANKAI:: :: 痞客邦 ::
		public function fun_readFromLog ($set_FileLoc = "", $set_FileName = "") {
			//echo "</br> fun_readFromLog </br>";
			$logInfo = "";
			$set_FullFileLoc  = "";
			$set_FullFileLoc .= ( substr($set_FileLoc, -1) === "/" ) ? ($set_FileLoc) 	: ($set_FileLoc."/");
			$set_FullFileLoc .= ($set_FileName.".log");					//$set_FullFileLoc .= ( preg_match("/./", $set_FileName) ) ? ($set_FileName) 	: ($set_FileName.".log");
			
			//echo "set_FileName: ".$set_FileName. "-> ".preg_match("/./", $set_FileName)."</br>";			echo "set_FullFileLoc: ".$set_FullFileLoc."</br>";
			if(file_exists( $set_FullFileLoc )) {
				$logInfo = file_get_contents($set_FullFileLoc, TRUE);
				$logInfo = json_decode($logInfo, 1);
			}

			return $logInfo;
		}

		//https://www.w3schools.com/php/func_filesystem_mkdir.asp
		//https://stackoverflow.com/questions/22032345/warning-mkdir-file-exists
		public function fun_mkdirForLog ($set_FileLoc = "") {
			$ary_dir = preg_split("/\//", $set_FileLoc);
			$tempLoc = "";
			foreach($ary_dir AS $Key => $Value) {
				if( ($Value === ".") || ($Value === "..") ) {
					$tempLoc .= $Value;
				}
				else {
					$tempLoc .= "/".$Value;			//echo "tempLoc: ".$tempLoc."</br>";
					if( !file_exists($tempLoc) ) {
						@mkdir($tempLoc, 0777, TRUE);
					}
				}
			}
		}

		// //返回陣列
		// public function fun_returnValues() {
		// 	return $this->p_returnAry;
		// }
	}
?>

<?php
 	/*
  // 範例
	// $cls_withLog = new cls_withLog;
	// $fileLoc = "./GameLog/20240102/Setting";
	// $cls_withLog->fun_writeIntoLog($fileLoc, "Roles", $ary_roleList );
	// $cls_withLog->fun_readFromLog(".", "FileName");
	*/
?>