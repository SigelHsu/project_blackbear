 <?php 
  //呼叫用以對特定角色，新增/刪除寵愛度的 Class
  /*
  // 範例
  // $call_clsFavor = new cls_withFavor($ary_roleList);
  // $call_clsFavor->fun_modifyFavor(1, array("Title" => "Queen"), array("Type" => 1, "Amount" => 2));
  // $tmp_Ary = $call_clsFavor->fun_returnValues();
  // print_r($tmp_Ary["R02"]);
  */
	class cls_withFavor {
		private $p_orginalAry;
		private $p_favorAry;
		private $p_returnAry;

		public function __construct ($inputAry = array(), $settingAry = array()) {
			$this->p_orginalAry = $inputAry;
			$this->fun_setInputAry($inputAry);
			$this->fun_setReturnAry($inputAry);
		}

		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "Favor", array("isCountTotal" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();
			$tmp_Ary = $this->fun_makeUpFavor($tmp_Ary);
			$this->p_favorAry = $tmp_Ary;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			//print_r($inputAry); echo "outputTag: ".$outputTag."</br>";
			if(!empty($outputTag)) {
				$this->p_orginalAry[$outputTag]["Favor"] = $inputAry;
			}
			else {
				$this->p_orginalAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_orginalAry);
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag]["Favor"] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//用來修改角色持有的寵愛度，$ModifyType(0: 無；1: 新增byID；2: 刪除byID)
		public function fun_modifyFavor($ModifyType = 0, $Role = array("ID"=> "", "Title" => ""), $ModifyFavor = array("Type"=> "", "Amount" => "")) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {					
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}			//echo "cls_withFavor->fun_modifyFavor => Role_ID: ".$Role_ID."</br>"; print_r($this->p_favorAry[$Role_ID]); exit();
			$ModifyFavor_Type 	= ( isset($ModifyFavor["Type"]) ) 	? ($ModifyFavor["Type"]) 		: (0);
			$ModifyFavor_Amount = ( isset($ModifyFavor["Amount"]) ) ? ($ModifyFavor["Amount"]) 	: (0);
			
			$res_Ary = array();		//echo "ModifyFavor_Type: ".$ModifyFavor_Type."</br>"; echo "ModifyFavor_Amount: ".$ModifyFavor_Amount."</br>";	exit();
			switch($ModifyType) {
				default:
				case 0:
					$res_Ary = $this->p_favorAry[$Role_ID];
					break;
				case 1:	//新增
					$res_Ary = $this->fun_addFavorByType($this->p_favorAry[$Role_ID], $ModifyFavor_Type, $ModifyFavor_Amount);					
					break;
				case 2:	//刪除
					$res_Ary = $this->fun_delFavorByType($this->p_favorAry[$Role_ID], $ModifyFavor_Type);					
					break;
			}		//print_r($res_Ary); exit();
			
			$this->fun_updateInputAry($res_Ary, $Role_ID);
		}
		public function fun_returnValues($outputTag = "") {
			if(!empty($outputTag)) {
				return $this->p_returnAry[$outputTag];
			}
			else {
				return $this->p_returnAry;
			}
		}
		public function fun_makeUpFavor($inputAry = array()) {
			
			$tmp_Ary = array();
			foreach($inputAry AS $Key => $Values) {
				$tmp_Ary[$Key] = $Values["Values"];
			}
			return $tmp_Ary;
		}
		public function fun_addFavorByType($inputAry = array(), $type = 0, $value = 0) {
			if($type != "-1") {
				array_push($inputAry["Temp"], array("Type" => $type, "Value" => $value));
			}
			else {
				$inputAry["Basic"] = $inputAry["Basic"] + $value;
			}

			return $inputAry;
		}
		public function fun_delFavorByType($inputAry = array(), $type = 0) {
			if( !isset($inputAry["Temp"]) ) {
				$inputAry["Temp"] = array();
			}
			foreach($inputAry["Temp"] AS $Key => $Values) { 
				if($Values["Type"] == $type) {
					unset($inputAry["Temp"][$Key]);	
				}
			}
			$inputAry["Temp"] = array_values($inputAry["Temp"]);
			return $inputAry;

			// 目前的想法是， favor裡面的 temp為暫時增加的寵愛度
			// 如果 type為 1，則會在該次提案結束後清空(一次))
			// 如果 type為 2，則會在該輪結束後清空(一輪)  #不確定還有沒有其他的例外
			// 先留著這樣...就變成...回合結束/議題結束後，再根據 Type去移除相應的寵愛度
			// $call_clsForFavor = new cls_withFavor($ary_roleList);
			// foreach($ary_roleList AS $Key => $Values) {
			// 	$ary_roleList[$Key]["favor"] = $call_clsForFavor->fun_delFavorByType($Values["favor"], 2);
			// }
		}

		public function fun_sumRolesFavor($inputAry = array()) {
			if(count($inputAry) == 0) {
				return 0;
			}
			$tol_Favor = 0;
			
			$tol_Favor = $tol_Favor + $inputAry["Basic"];
			foreach($inputAry["Temp"] AS $Key => $Values) {
				$tol_Favor += $Values["Value"];
			}
	
			return $tol_Favor;

			// foreach($ary_roleList AS $Key => $Values) {
			// 	echo $Key.": </br>";
			// 	print_r($Values["favor"]);
			// 	echo "</br>";
			// 	fun_sumRolesFavor($Values["favor"]);
			// }
		}
		public function fun_returnCountFavor($Role = array("ID"=> "", "Title" => "")) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {					
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}			//echo "Role_ID: ".$Role_ID."</br>";
			if ( isset($this->p_favorAry[$Role_ID]) ) {
				return $this->fun_sumRolesFavor($this->p_favorAry[$Role_ID]);
			}
			return -1;
		}
	}
?>