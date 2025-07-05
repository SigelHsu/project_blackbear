<?php
  //陰謀卡Intrigue(已使用Used、待處理Pending{array(ID=>"", Turns=>"", StartTurn=>"", EndTurn=>"")}), 
  /*
  // 範例
	// $call_clsIntri = new cls_withIntrigue($ary_roleList);
	// $call_clsIntri->fun_modifyIntrigue(1, array("Title" => "Queen"), array("Title" => "elephant", "Type" => 1));
	// $call_clsIntri->fun_modifyIntrigue(1, array("Title" => "Queen"), array("Title" => "apple", "Type" => 1));
	// $call_clsIntri->fun_modifyIntrigue(1, array("Title" => "Queen"), array("Title" => "conana", "Type" => 2));
	// $call_clsIntri->fun_modifyIntrigue(1, array("Title" => "Queen"), array("Title" => "dumping", "Type" => 2));
	// $call_clsIntri->fun_modifyIntrigue(2, array("Title" => "Queen"), array("Title" => "elephant", "Type" => 1), array("push" => 0) );
	// $call_clsIntri->fun_modifyIntrigue(2, array("Title" => "Queen"), array("Title" => "conana", "Type" => 2), array("push" => 1) );
	// print_r($call_clsIntri->fun_returnValues());
	// print_r($call_clsIntri->fun_returnPendingValues());
  */
	class cls_withIntrigue {
		private $p_setLang;
		private $p_intrigueListAry;
		private $p_hasIntriAry;
		private $p_usedIntriAry;
		private $p_pendingIntriAry;
		private $p_orginalAry;
		private $p_IntrigueAry;
		private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			global $set;
			$set_lang = $set["Language"];										//print_r($set); exit();
			$this->p_setLang = $set_lang;
			global $ary_setIntrigueList;										//print_r($ary_setIntrigueList);
			$this->p_intrigueListAry = $ary_setIntrigueList;
			$this->p_orginalAry = $inputAry;
			$this->fun_setInputAry($inputAry);							//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
			$this->fun_setHasAry();
		}
		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "Intrigue", array("isCountTotal" => 0, "isAddValueTag" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();			//echo "tmp_Ary: ";	print_r($tmp_Ary); echo "</br>";
			$this->p_IntrigueAry = $tmp_Ary;
		}
		private function fun_setHasAry() {
			$this->p_hasIntriAry 			= array();			
			$this->p_usedIntriAry 		= array();			
			$this->p_pendingIntriAry 	= array();

			foreach($this->p_intrigueListAry AS $Key => $Values) {
				$this->p_hasIntriAry[$Key] = 0;
			}																												//echo "p_hasIntriAry: "; print_r($this->p_hasIntriAry);	echo "</br>";

			foreach($this->p_IntrigueAry AS $Role_ID => $Values) {	//echo "p_IntrigueAry: "; print_r($this->p_IntrigueAry);	echo "</br>";
				if(isset($Values["Used"])) {
					$Values["Used"] = array_filter($Values["Used"]);
					foreach($Values["Used"] AS $Key => $IntriAry) {
						//if(!isset($this->p_hasIntriAry[$IntriAry["ID"]]) ) {
							$this->p_hasIntriAry[$IntriAry["ID"]] 		= $Role_ID;
							$this->p_usedIntriAry[$IntriAry["ID"]] 		= $Role_ID;
						//}					
					}
				}
				if(isset($Values["Pending"])) {
					$Values["Pending"] = array_filter($Values["Pending"]);
					foreach($Values["Pending"] AS $Key => $IntriAry) {
						//if(!isset($this->p_hasIntriAry[$IntriAry["ID"]]) ) {
							$this->p_hasIntriAry[$IntriAry["ID"]] 		= $Role_ID;
							$this->p_pendingIntriAry[$IntriAry["ID"]] = $Role_ID;
						//}					
					}
				}
			}
			ksort($this->p_hasIntriAry);			//print_r($this->p_hasIntriAry);
			ksort($this->p_usedIntriAry);
			ksort($this->p_pendingIntriAry);
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_IntrigueAry[$outputTag] = $inputAry;
				$this->fun_setReturnAry($this->p_IntrigueAry[$outputTag], $outputTag);
			}
			else {
				$this->p_IntrigueAry = $inputAry;
				$this->fun_setReturnAry($this->p_IntrigueAry);
			}
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag]["Intrigue"] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//根據所輸入的 Intrigue_Name，從 $ary_setIntrigueList中找到相對應的 Intrigue_ID
		public function fun_getIntrigueTagIDFromName ($TagName = "") {
			//echo "fun_getIntrigueTagIDFromName ".$TagName; exit();
			$intrigueListAry = $this->p_intrigueListAry;
			foreach($intrigueListAry AS $Key => $Values) {
				if( in_array(strtolower($TagName), $Values["Title"]) ) {
					return $Key;
					break;
				}
			}
		}
		//Intri[Type]: 1. Used, 2. Pending
		public function fun_modifyIntrigue($ModifyType = 0, $Role = array("ID"=> "", "Title" => ""), $Intri = array("ID"=> "", "Title" => "", "Type" => 0), $settingAry = array()) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {					
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}																									//echo "Role_ID: ".$Role_ID."</br>";
			$Intri_ID = "";
			if( !isset($Intri["ID"]) || ( isset($Intri["ID"]) && ($Intri["ID"] == "") ) ) {
				if( isset($Intri["Title"]) && ($Intri["Title"] != "") ) {
					$Intri_ID = $this->fun_getIntrigueTagIDFromName($Intri["Title"]);
				}
			}
			else {
				$Intri_ID = $Intri["ID"];
			}																									//echo "Intri_ID: ".$Intri_ID."</br>"; //exit();
			$Intri_Type = $Intri["Type"];											//echo "Intri_Type: ".$Intri_Type."</br>";
			
			$res_Ary = $this->p_IntrigueAry[$Role_ID];				//echo "before: "; print_r($this->p_IntrigueAry[$Role_ID]); echo "</br>";
			switch($ModifyType) {
				default:
				case 0:
					break;
				case 1:	//新增
						$res_Ary = $this->fun_addIntrigueByTagID($this->p_IntrigueAry[$Role_ID], $Intri_ID, $Intri_Type, $settingAry);
					break;
				case 2:	//刪除
						$res_Ary = $this->fun_delInterigueByTagID($this->p_IntrigueAry[$Role_ID], $Intri_ID, $Intri_Type, $settingAry);
					break;
			}
			$this->fun_updateInputAry($res_Ary, $Role_ID);		//echo "after: "; print_r($res_Ary[$Role_ID]); echo "</br>";
			$this->fun_setHasAry();
		}
		//根據 $TagType，將 Intrigue_ID 直接放到陣列裡面
		public function fun_addIntrigueByTagID($inputAry = array(), $TagID = "", $TagType = 0, $set = array("Turns" => 0, "Start" => 0, "To" => array(), "Effect" => "") ) {
			switch($TagType) {
				default:
					break;
				case 1:		//Used
					if( !isset($inputAry["Used"]) ) {
						$inputAry["Used"] = array();
					}
					array_push($inputAry["Used"], 
										array("ID" 			=> $TagID,
													"To" 			=> $set["To"], 		//這部分還沒想到比較好的放入方法，先放著
													"Effect" 	=> "",
													"Turns" 	=> 0, 
													"Start" 	=> $set["Start"], 
													"End" 		=> ($set["Start"] + $set["Turns"])
													));
					break;
				case 2:		//Pending
					if( !isset($inputAry["Pending"]) ) {
						$inputAry["Pending"] = array();
					}
					array_push($inputAry["Pending"], 
										array("ID" 			=> $TagID,
													"To" 			=> $set["To"],  		//這部分還沒想到比較好的放入方法，先放著
													"Effect" 	=> "", 
													"Turns" 	=> $set["Turns"], 
													"Start" 	=> $set["Start"], 
													"End" 		=> ($set["Start"] + $set["Turns"])
													));
					break;
			}
			return $inputAry;
		}
		//根據 $TagType，將 Intrigue_ID 從陣列中刪除
		public function fun_delInterigueByTagID($inputAry = array(), $TagID = "", $TagType = 0, $setAry = array("push" => "")) {
			switch($TagType) {
				default:
					break;
				case 1:		//Used
					$cls_tkAry = new cls_takeAryby;
					$cls_tkAry->fun_takeFromMultiAry($inputAry["Used"], "ID", array("isCountTotal" => 0, "isAddValueTag" => 0) );
					$tmp_Ary = $cls_tkAry->fun_returnValues();			//echo "tmp_Ary: ";	print_r($tmp_Ary); echo "</br>";
					if( array_search($TagID, $tmp_Ary) !== NULL ) {
						$get_DelAry = $inputAry["Used"][array_search($TagID, $tmp_Ary)];
						unset($inputAry["Used"][array_search($TagID, $tmp_Ary)]);
						$inputAry["Used"] = array_values($inputAry["Used"]);
					}
					break;
				case 2:		//Pending
					$cls_tkAry = new cls_takeAryby;
					$cls_tkAry->fun_takeFromMultiAry($inputAry["Pending"], "ID", array("isCountTotal" => 0, "isAddValueTag" => 0) );
					$tmp_Ary = $cls_tkAry->fun_returnValues();			//echo "tmp_Ary: ";	print_r($tmp_Ary); echo "</br>";
					
					if( array_search($TagID, $tmp_Ary) !== NULL ) { //先從 Pending區移除，然後將其加入到 Used區
						$get_DelAry = $inputAry["Pending"][array_search($TagID, $tmp_Ary)];
						unset($inputAry["Pending"][array_search($TagID, $tmp_Ary)]);
						if(isset($setAry["push"]) && ($setAry["push"] == 1) ) array_push($inputAry["Used"], $get_DelAry);
						$inputAry["Pending"] 	= array_values($inputAry["Pending"]);
						$inputAry["Used"] 		= array_values($inputAry["Used"]);
					}
					break;
					
			}
			
			return $inputAry;
		}

		//返回陣列
		public function fun_returnValues() {
			return $this->p_returnAry;
		}
		public function fun_returnUsedValues() {
			return $this->p_usedIntriAry;
		}
		public function fun_returnPendingValues() {
			print_r($this->p_hasIntriAry);
			return $this->p_pendingIntriAry;
		}
	}
?>