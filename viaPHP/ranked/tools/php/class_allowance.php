<?php
  //財政大臣具有額外的稅率，會分成 1: 累進制, 2: 調整制，其他人此部分固定為 0；
	//額外收入是藉由陰謀卡/地位卡觸發的(但不好紀錄...讓玩家主動展示)
	//當地位 < 2時，1/2津貼；寵愛 <= 0時，1/2津貼
  /*
  // 範例
  // $call_ClsAllow = new cls_withAllowance($ary_roleList);
  // $call_ClsAllow->fun_RolesTotalAllowance(array("Title" => "Money"));
  // $ary_AboutAllowance = $call_ClsAllow->fun_returnValues();			//print_r($ary_AboutAllowance);
  */
	class cls_withAllowance {
		private $p_orginalAry;
		private $p_allowanceAry;
		private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			$this->p_orginalAry = $inputAry;
			$this->fun_setInputAry($inputAry);						//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
		}

		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "Allowance", array("isCountTotal" => 0, "isAddValueTag" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();		//print_r($tmp_Ary);
			$this->p_allowanceAry = $tmp_Ary;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_orginalAry[$outputTag]["Allowance"] = $inputAry;
			}
			else {
				$this->p_orginalAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_orginalAry);
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag]["Allowance"] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}
		
		public function fun_modifyAllowance($ModifyType = 0, $Role = array("ID"=> "", "Title" => ""), $Allow = array("Type" => 0, "Quantity" => 0), $settingAry = array()) {
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
			$Allow_Type = $Allow["Type"];											//echo "Allow_Type: ".$Allow_Type."</br>";
			$Allow_Quant = $Allow["Quantity"];								//echo "Allow_Quant: ".$Allow_Quant."</br>";
			
			$res_Ary = $this->p_allowanceAry[$Role_ID];				//echo "before: "; print_r($this->p_allowanceAry[$Role_ID]); echo "</br>";
			switch($ModifyType) {
				default:
				case 0:
					break;
				case 1:	//新增
						$res_Ary = $this->fun_addAllowance($this->p_allowanceAry[$Role_ID], $Allow_Type, $Allow_Quant);
					break;
				case 2:	//刪除
						$res_Ary = $this->fun_subAllowance($this->p_allowanceAry[$Role_ID], $Allow_Type, $Allow_Quant);
					break;
			}
			$this->fun_updateInputAry($res_Ary, $Role_ID);		//echo "after: "; print_r($res_Ary); echo "</br>";
		}
		//增加津貼：$AllowaType: 1. Permanent(永久) 2. Tax(稅率) 3. Templary(暫時)
		public function fun_addAllowance($inputAry = array(), $AllowaType = 0, $amountNum = 0) {
			switch($AllowaType) {
				default:
					break;
				case 1:
					$inputAry["Basic"] += $amountNum;
					break;
				case 2:
					array_push($inputAry["Tax"], $amountNum);
					break;
				case 3:
					array_push($inputAry["Templary"], $amountNum);
					break;
			}
			return $inputAry;
		}
		//減少津貼：$AllowaType: 1. Permanent(永久) 2. Tax(稅率) 3. Templary(暫時)
		public function fun_subAllowance($inputAry = array(), $AllowaType = 0, $amountNum = 0) {
			switch($AllowaType) {
				default:
					break;
				case 1:
					$inputAry["Basic"] -= $amountNum;
					if($inputAry["Basic"] <= 0) $inputAry["Basic"] = 0;
					break;
				case 2:																									//因為稅率基本上不太會降...所以輸入時設定為負數，如果為累進制的話，將所有的相加，如果為調整制的話，取最後一筆的絕對值
					array_push($inputAry["Tax"], "-".$amountNum);
					break;
				case 3:
					array_push($inputAry["Templary"], "-".$amountNum);		//其實如果有加入回合的話會更好，但一回合不一定只增減一次，所以會變成 $inputAry["Templary"][$Round]
					break;
			}
			return $inputAry;
		}
		//單獨計算稅率總和
		public function fun_sumTaxRatex() {
			global $set;
			$inputAry = ( isset( $this->p_allowanceAry["R06"]) ) ? ( $this->p_allowanceAry["R06"] ) : ( array() );
			$tol_TaxRate = 0;
			
			switch($set["TaxType"]) {
				case 1:
					{
						foreach($inputAry["Tax"] AS $Key => $Values) {
							$tol_TaxRate += $Values;
						}
					}
					break;
				default:
				case 2:
					{
						$tol_TaxRate = abs( $inputAry["Tax"][array_key_last($inputAry["Tax"])] );
					}
					break;
			}
			return $tol_TaxRate;
		}
		//個別計算津貼總和
		public function fun_sumRolesAllowance($inputAry = array()) {
			global $set;
			$tol_Allowance = 0;
			
			$tol_Allowance = $tol_Allowance + $inputAry["Basic"];				//echo "Basic: ".$tol_Allowance."</br>";
			$tmp_FinalTax = 0;
			switch($set["TaxType"]) {
				case 1:
					{
						foreach($inputAry["Tax"] AS $Key => $Values) {
							$tmp_FinalTax += $Values;
						}
					}
					break;
				default:
				case 2:
					{
						$tmp_FinalTax = abs( $inputAry["Tax"][array_key_last($inputAry["Tax"])] );
					}
					break;
			}
			$tol_Allowance += $tmp_FinalTax;
			return $tol_Allowance;
		}
		public function fun_RolesTotalAllowance($Role = array("ID"=> "", "Title" => "")) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}						//echo "Role_ID: ".$Role_ID."</br>"; print_r($this->p_allowanceAry[$Role_ID]); //exit();
			
			//最終津貼
			$final_Allowance = $this->fun_sumRolesAllowance($this->p_allowanceAry[$Role_ID]);		//echo "final_Allowance: ".$final_Allowance."</br>";
      
			//計算地位卡，是否低於 2，若是，津貼減半
			$tmp_ClsStatus = new cls_withStatus($this->p_orginalAry);
			$Count_Status = $tmp_ClsStatus->fun_returnCountStatus(array("ID" => $Role_ID));		  //echo "Count_Status: ".$Count_Status."</br>";
			if($Count_Status < 2) $final_Allowance = round($final_Allowance / 2)."(Status)";

			//計算寵愛度，是否等於低於 0，若是，津貼減半(應該減半一次就好)
			if($Count_Status >= 2) {
				$call_clsFavor = new cls_withFavor($this->p_orginalAry);
				$Count_Favor = $call_clsFavor->fun_returnCountFavor(array("ID" => $Role_ID));     //echo "Count_Favor: ".$Count_Favor."</br>";
				if($Count_Favor <= 0) $final_Allowance = round($final_Allowance / 2)."(Favor)";
			}
      
			//檢查角色是否在地牢，若是，沒有津貼
			if($Count_Status >= 2 && $Count_Favor > 0) {
				$thisRole = $this->p_orginalAry[$Role_ID];
				if(isset($thisRole["Role"]["State"]) && ( $thisRole["Role"]["State"] == 9) ) $final_Allowance = round(0)."(Dungeon)";
			}
			
			$this->p_allowanceAry[$Role_ID]["Final"] = $final_Allowance;							//echo "final_Allowance: ".$final_Allowance."</br>";	//print_r($this->p_allowanceAry[$Role_ID]);
			$this->fun_updateInputAry($this->p_allowanceAry[$Role_ID], $Role_ID);			//print_r($this->p_returnAry);
      return $final_Allowance;
		}

		//返回陣列
		public function fun_returnValues() {
			return $this->p_returnAry;
		}
	}
?>