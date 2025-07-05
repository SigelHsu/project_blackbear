<?php
	//用以展示角色的下拉式選單
	function fun_selectorRoles($inputID = "input_Key_RoleID", $inputTitle = "input[Key][RoleID]", $selOption = "") {
		global $ary_setRoleList, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$inputID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		foreach($ary_setRoleList AS $Key => $Values) {
			$isSeled = ($Values["ID"] === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Values["ID"]."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示地位卡的下拉式選單
	function fun_selectorStatus($inputID = "input_Key_StatusID]", $inputTitle = "input[Key][StatusID]", $selOption = "") {
		global $ary_setStatusList, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$inputID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		foreach($ary_setStatusList AS $Key => $Values) {
			$isSeled = ($Values["ID"] === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Values["ID"]."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示顏色的下拉式選單
	function fun_selectorColor($inputID = "input_Key_ColorID", $inputTitle = "input[Key][ColorID]", $selOption = "") {
		global $setting_Color, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$inputID."\" class = \"Begin_Color form-control col\" name = \"".$inputTitle."\" 
														data-toggle = \"tooltip\" data-placement = \"top\" title = \"玩家顏色 Player Color\" >";
		$rtn_option .= 	"<option value = \"C00\" ".$isSeled." >Not Selected</option>";
		foreach($setting_Color AS $Key => $Values) {
			$isSeled = ($Key === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Key."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示狀態的下拉式選單
	function fun_selectorState($inputID = "input_Key_StateID", $inputTitle = "input[Key][StateID]", $selOption = "") {
		global $setting_State, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$inputID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		foreach($setting_State AS $Key => $Value) {
			$isSeled = ($Key === (int)$selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Key."\" ".$isSeled." >".$Value."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示健康卡的下拉式選單
	function fun_selectorHealth($setID = "set_HealthLv", $inputTitle = "set[HealthLv]", $selOption = "") {
		global $ary_setHealthList, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$setID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		$rtn_option .= 	"<option value = \"H00\" ".$isSeled." >Not Selected</option>";
		foreach($ary_setHealthList AS $Key => $Values) {
			$isSeled = ($Values["ID"] === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Values["ID"]."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示軍隊動員卡的下拉式選單
	function fun_selectorMobilization($setID = "set_MobiliLv", $inputTitle = "set[MobiliLv]", $selOption = "") {
		global $ary_setMobilizationList, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$setID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		$rtn_option .= 	"<option value = \"M00\" ".$isSeled." >Not Selected</option>";
		foreach($ary_setMobilizationList AS $Key => $Values) {
			$isSeled = ($Values["ID"] === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Values["ID"]."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}
	//用以展示人民動亂卡的下拉式選單
	function fun_selectorRebellion($setID = "set_RevellLv", $inputTitle = "set[RevellLv]", $selOption = "") {
		global $ary_setRebellionList, $set;
		$set_lang = $set["Language"];
		$rtn_option  = "";
		$rtn_option .= "<select id = \"".$setID."\" class = \"form-control col\" name = \"".$inputTitle."\" >";
		$rtn_option .= 	"<option value = \"P00\" ".$isSeled." >Not Selected</option>";
		foreach($ary_setRebellionList AS $Key => $Values) {
			$isSeled = ($Values["ID"] === $selOption) ? ("selected") : ("");
			$rtn_option .= "<option value = \"".$Values["ID"]."\" ".$isSeled." >".$Values["Title"][$set_lang]."</option>";
		}
		$rtn_option .= "</select>";

		return $rtn_option;
	}

	//將輸入的 Log Array，轉換成字串返回
	function fun_showLogSentense($setTurn = 0, $inputAry = array() ) {
		global $setting_Phase;

		$res_Sent  = "";
		$res_Sent .= "※第 ".$setTurn."回合※</br></br>";

		foreach($inputAry AS $PhaseKey => $PhaseValues) {
			$res_Sent .= $setting_Phase[$PhaseKey];
			$res_Sent .= ": </br>";

			if($PhaseKey != 3){	//接旨期|外交期
				foreach($PhaseValues AS $LogKey => $LogValues) {
					$res_Sent .= "　".$LogKey.". ".$LogValues."</br>";
				}
			}
			else {							//會議期
				foreach($PhaseValues AS $PetitKey => $PetitValues) {
					$res_Sent .= "　第 ".$PetitKey."項: </br>";

					foreach($PetitValues AS $StepKey => $StepValue) {
						$res_Sent .= "　　＃步驟 ".$StepKey.": ".$StepValue."</br>";
					}
				}
			}								
			$res_Sent .= "</br></hr>";
		}

		return $res_Sent;
	}
	
	//建立角色起始時的 Form表
	function fun_genRoleBeginForm ($input_rolesList = array()) {
		global $ary_roleList;
		$rtn_String = "";
		
		foreach($input_rolesList AS $RoleKey => $RoleValues) {
			$rtn_String .= "<hr />";
			$rtn_String .= "<div id = \"box_Role_Begin_".$RoleKey."\" class = \"Box_RoleBegin col-xl-12 col-lg-12\">";
			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group form-row col-12\">";
			$rtn_String .= 			fun_selectorRoles("input_Begin_".$RoleKey."_Role_ID", "input[Begin][".$RoleKey."][Role][ID]", $RoleKey);
			$tmp_Player  = (isset($ary_roleList[$RoleKey])) ? ($ary_roleList[$RoleKey]["Player"]) : ("");
			$rtn_String .= 	"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Player\" class = \"Begin_Role form-control col\" 
															name = \"input[Begin][".$RoleKey."][Player]\" value = \"".$tmp_Player."\" 
															data-toggle = \"tooltip\" data-placement = \"top\" title = \"玩家名稱 Player Name\" >";
			$tmp_Color   = (isset($ary_roleList[$RoleKey])) ? ($ary_roleList[$RoleKey]["Color"]) : ($RoleValues["Color"]);
			$rtn_String .= 			fun_selectorColor("input_Begin_".$RoleKey."_Color", "input[Begin][".$RoleKey."][Color]", $tmp_Color);
			$tmp_State 	 = (isset($ary_roleList[$RoleKey]["Role"]["State"])) ? ($ary_roleList[$RoleKey]["Role"]["State"]) : ($RoleValues["State"]);
			$rtn_String .= 			"(".fun_selectorState("input_Begin_".$RoleKey."_State", "input[Begin][".$RoleKey."][Role][State]", $tmp_State).")";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-money-bill-wave\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"起始金錢 Money\"> 起始金錢 Money</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Allowance_Basic\" class = \"Begin_Allow form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Money]\" value = \"".$RoleValues["Begin"]["Money"]."\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-coins\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"起始金錢 Money\"> 起始津貼 Allowance</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Allowance_Basic\" class = \"Begin_Allow form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Allowance][Basic]\" value = \"".$RoleValues["Begin"]["Allowance"]["Basic"]."\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-suitcase\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"稅率 Tax Rate\"> 起始稅率 Tax Rate</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Allowance_Tax\" class = \"Begin_Tax form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Allowance][Tax][]\" value = \"".$RoleValues["Begin"]["Allowance"]["Tax"]."\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .=  		"<label><i class = \"fas fa-heart\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"起始寵愛度 Favor\"> 起始寵愛度 Favor</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Favor_Basic\" class = \"Begin_Favor form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Favor][Basic]\" value = \"".$RoleValues["Begin"]["Favor"]."\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-hourglass-end\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"(臨時寵愛度)\"> (臨時寵愛度)</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Favor_Temp\" class = \"form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Favor][Temp]\" value = \"\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$rtn_String .= 			"<label><i class = \"fas fa-medal\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"起始地位 Status：輸入編號，用『,』分開\"> 起始地位 Status</i></label>";
			$rtn_String .= 			"<label>(".$RoleValues["Begin"]["Status"]." 張)</label>";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$tmp_StatusList = (isset($ary_roleList[$RoleKey]["Status"])) ? (implode(",", $ary_roleList[$RoleKey]["Status"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_Begin_".$RoleKey."_Status\" class = \"Begin_Status form-control col\" 
																	name = \"input[Begin][".$RoleKey."][Status]\" value = \"".$tmp_StatusList."\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";
			$rtn_String .= "</div>";
		}

		return $rtn_String;
	}
	//建立角色回合間的 Form表
	function fun_genRoleForm ($input_rolesList = array()) {
		global $ary_setRoleList;
		$rtn_String = "";

		foreach($input_rolesList AS $RoleKey => $RoleValues) {
			$rtn_String .= "<hr />";
			$rtn_String .= "<div id = \"box_Role_".$RoleKey."\" class = \"col-xl-12 col-lg-12\">";
			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group form-row col-12\">";
			$rtn_String .= 			fun_selectorRoles("input_Begin_".$RoleKey."_Role_ID", "input[".$RoleKey."][Role][ID]", $RoleKey);
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Player\" class = \"form-control col\" 
																	name = \"input[".$RoleKey."][Player]\" value = '".$RoleValues["Player"]."' 
																	data-toggle = \"tooltip\" data-placement = \"top\" title = \"玩家名稱 Player Name\" >";
			$tmp_Color   = (isset($RoleValues["Color"])) ? ($RoleValues["Color"]) : ($ary_setRoleList[$RoleKey]["Color"]);
			$rtn_String .= 			fun_selectorColor("input_".$RoleKey."_Color", "input[".$RoleKey."][Color]", $tmp_Color);
			$rtn_String .= 			"(".fun_selectorState("input_".$RoleKey."_Role_State", "input[".$RoleKey."][Role][State]", $RoleValues["Role"]["State"]).")";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-coins\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"津貼 Allowance\"> 津貼 Allowance</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Allowance_Basic\" class = \"form-control col\" 
																	name = \"input[".$RoleKey."][Allowance][Basic]\" value = '".$RoleValues["Allowance"]["Basic"]."' >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-suitcase\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"稅率 Tax Rate\"> 稅率 Tax Rate</i></label>";
			$tmp_AllowanceTax = (isset($RoleValues["Allowance"]["Tax"])) ? (json_encode($RoleValues["Allowance"]["Tax"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Allowance_Tax\" class = \"Role_Allowance Favor_Tax form-control col\" 
																	name = \"input[".$RoleKey."][Allowance][Tax]\" value = '".$tmp_AllowanceTax."' >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .=  		"<label><i class = \"fas fa-heart\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"寵愛度 Favor\"> 寵愛度 Favor</i></label>";
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Favor_Basic\" class = \"form-control col\" 
																	name = \"input[".$RoleKey."][Favor][Basic]\" value = '".$RoleValues["Favor"]["Basic"]."' >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col\">";
			$rtn_String .= 			"<label><i class = \"fas fa-hourglass-end\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"(臨時寵愛度)\"> (臨時寵愛度)</i></label>";
			$tmp_FavorTempList = (isset($RoleValues["Favor"]["Temp"])) ? (json_encode($RoleValues["Favor"]["Temp"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Favor_Temp\" class = \"Role_Favor Favor_Temp form-control col\" 
																	name = \"input[".$RoleKey."][Favor][Temp]\" value = '".$tmp_FavorTempList."' >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$rtn_String .= 			"<label><i class = \"fas fa-medal\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"地位 Status\"> 地位 Status</i></label>";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$tmp_StatusList = (isset($RoleValues["Status"])) ? (implode(",", $RoleValues["Status"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Status\" class = \"Role_Status form-control col\" 
																	name = \"input[".$RoleKey."][Status]\" value = '".$tmp_StatusList."' >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= 	"<div class = \"form-row\">";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$rtn_String .= 			"<label><i class = \"fas fa-medal\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"陰謀 Intrigue\"> 陰謀 Intrigue</i></label>";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$tmp_IntrigueUsedList = (isset($RoleValues["Intrigue"]["Used"])) ? (implode(",", $RoleValues["Intrigue"]["Used"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Intrigue_Used\" class = \"Role_Intrigue Intrigue_Used form-control col\" 
																	name = \"input[".$RoleKey."][Intrigue][Used]\" value = '".$tmp_IntrigueUsedList."' 
																	data-toggle = \"tooltip\" data-placement = \"top\" title = \"已處理的陰謀卡 Used\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 		"<div class = \"form-group col-12\">";
			$tmp_IntriguePendList = (isset($RoleValues["Intrigue"]["Pending"])) ? (json_encode($RoleValues["Intrigue"]["Pending"])) : ("");
			$rtn_String .= 			"<input type = \"text\" id = \"input_".$RoleKey."_Intrigue_Pending\" class = \"Role_Intrigue Intrigue_Pending form-control col\" 
																	name = \"input[".$RoleKey."][Intrigue][Pending]\" value = '".$tmp_IntriguePendList."' 
																	data-toggle = \"tooltip\" data-placement = \"top\" title = \"待處理的陰謀卡 Pending\" >";
			$rtn_String .= 		"</div>";
			$rtn_String .= 	"</div>";

			$rtn_String .= "</div>";
		}

		return $rtn_String;
	}
?>