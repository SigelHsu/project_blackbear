<?php
	/*
	// !這部分還有些未完成的部分：
	//	紀錄 Log、印出 Log資訊
	*/
	//接旨期: Audience
	//接旨期前(beforeAudience: 回合小結、寫入角色Log、抓取資料)、接旨期(Audience: 健康卡、軍隊卡、人民卡﹑陰謀卡張數﹑津貼)
	//1. 根據角色 & 回合數，計算當回合需發放的陰謀卡數量(軍隊卡/人民卡另外登記)
	//2. 根據角色，計算當回合需發放的津貼數量
	//3. 根據角色狀態、健康卡，判斷是否發放津貼/陰謀卡
	//目前 Log就另外紀錄、然而健康卡/軍隊卡/人民卡比較接近環境...

	//在進入接旨期前，先抓取 健康卡牌、角色資料(陰謀卡、津貼、稅金)
	//個人發放的習慣是: 王子、皇后、男爵、主教、大使、財務、總務(不過大使在 setting_llkRoles.php排在最後)
	//這部分就整理完後，直接全列出來，讓玩家自行決定發放順序
?>
<?php
	class cls_withAudience{
		private $p_setLang;
		private $p_setRoleListAry;
		private $p_AllotAry;
		private $p_orginalAry;
		private $p_rolesAry;
		private $p_returnAry;
		private $p_settingAry;
		private $p_setRound;
		
		public function __construct ($inputAry = array(), $settingAry = array("Round" => 0)) {
			global $set;
			$set_lang = $set["Language"];
			$this->p_setLang = $set_lang;
			global $ary_setRoleList;												//print_r($ary_setIntrigueList);
			$this->p_setRoleListAry = $ary_setRoleList;
			$this->p_orginalAry = $inputAry;
			$this->p_settingAry = $settingAry;							//echo "settingAry: </br>"; print_r($this->p_settingAry);
			$this->p_setRound 	= $settingAry["Round"];
			$this->fun_setInputAry($inputAry);							//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
			$this->fun_beforeAudience();
		}
		private function fun_setInputAry($inputAry = array()) {
			//$tmp_Ary = array();
			$this->p_rolesAry = $inputAry;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_rolesAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_rolesAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_rolesAry[$outputTag], $outputTag);
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//先收集一些需要的資訊
		private function fun_beforeAudience() {
			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($this->p_rolesAry, "Allot", array("isCountTotal" => 0, "isAddValueTag" => 0) );
			$this->p_AllotAry = $cls_tkAry->fun_returnValues();			//echo "this->p_AllotAry: ";	print_r($this->p_AllotAry); echo "</br>";
		}

		//印出
		public function fun_printOrderForAudience($Round = 0, $inputAry = array() ) {
			if($Round !== 0) {
				$this->p_setRound = $Round;
			}
			if(count($inputAry) !== 0) {
				$this->fun_setInputAry($inputAry);										//print_r($inputAry);
				$this->fun_setReturnAry($inputAry);
				$this->fun_beforeAudience();
			}
			//print_r($this->p_AllotAry);
			global $setting_State, $setting_Color;
			$cls_callAllow = new cls_withAllowance($this->p_orginalAry); 
			$resultStr  = "";
			//$resultStr .= "第 ".$this->p_setRound."回合:</br></br>";
			foreach($this->p_AllotAry AS $Role_ID => $Values) {
				$tmpColor = ( isset($this->p_orginalAry[$Role_ID]["Color"]) && ($this->p_orginalAry[$Role_ID]["Color"] != "") ) ? 
										($setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Color"]) : ("rgb(90 20 239)");
				$tmpColorT = $setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Title"][$this->p_setLang];
				$tmpStyle = "border-left: ".$tmpColor." solid";
				$resultStr .= "<div style = '".$tmpStyle."' data-toggle = \"tooltip\" data-placement = \"top\" title = \"".$tmpColorT."\">";
				$resultStr .= 	"角色：".$this->p_setRoleListAry[$Role_ID]["Title"][$this->p_setLang]." ";
				$resultStr .= 	"(狀態：".$setting_State[$this->p_rolesAry[$Role_ID]["Role"]["State"]].")</br>";
				$resultStr .= 	"寵愛度：".$this->p_rolesAry[$Role_ID]["Favor"]["Basic"]."</br>";
				$resultStr .= 	"領取陰謀卡：".($Values["Intrigue"][(($Round % 2 == 0) ? ("Even") : ("Odd"))])."</br>";
				$resultStr .= 	"領取津貼：".$cls_callAllow->fun_RolesTotalAllowance( array("ID" => $Role_ID) )."</br>";
				$resultStr .= "</div>";
				$resultStr .= "</br>";
			}

			return $resultStr;
		}
		//保留在回合結束時處理....好像也沒有必要?
		public function fun_updateAllot() {
			//fun_sumRolesAllowance
			global $set;

			foreach($this->p_rolesAry AS $Role_ID => $Values) {
				$tmp_FinalTax = 0;
				switch($set["TaxType"]) {
					case 1:
						{
							foreach($Values["Allowance"]["Tax"] AS $Key => $Values) {
								$tmp_FinalTax += $Values;
							}
						}
						break;
					default:
					case 2:
						{
							$tmp_FinalTax = abs( $Values["Allowance"]["Tax"][array_key_last($Values["Allowance"]["Tax"])] );
						}
						break;
				}
				$this->p_rolesAry[$Role_ID]["Allot"] = array("Basic" 	=> $Values["Allowance"]["Basic"], 
																					 					 "Tax" 		=> $tmp_FinalTax);
			}
			$this->fun_setReturnAry($this->p_rolesAry);			//print_r($this->p_rolesAry);
		}
		
		//返回陣列
		public function fun_returnValues() {
			return $this->p_returnAry;
		}
	}
?>

<?php
  /*
  // 範例
	// $cls_withAud = new cls_withAudience($ary_roleList);
	// $cls_withAud->fun_printOrderForAudience(2);
	// $cls_withAud->fun_updateAllot();	//放在回合結束時處理，還有設定 Tax的部分
	// 因為有少數的陰謀卡/地位卡，可以在接旨期使用，這部分先留作 Log
  */
?>