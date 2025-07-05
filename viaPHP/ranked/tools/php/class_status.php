<?php
  //呼叫用以對特定角色，新增/刪除地位卡的 Class
  /*
  // 範例
  // $tmp_Cls = new cls_withStatus($ary_roleList);
  // $tmp_Cls->fun_modifyStatus(1, array("Title" => "Queen"), array("Title"=>"cocona"));	//新增S03
  // $tmp_Cls->fun_modifyStatus(1, array("Title" => "Queen"), array("Title"=>"apple"));		//新增S01
  // $tmp_Ary = $tmp_Cls->fun_returnValues();	//print_r($tmp_Ary);	echo "</br>";
  // $tmp_Cls->fun_modifyStatus(2, array("Title" => "Queen"), array("Title"=>"cocona"));	//移除S03
  // $tmp_Ary = $tmp_Cls->fun_returnValues();	//print_r($tmp_Ary);	echo "</br>";
  */
	class cls_withStatus {
		private $p_statusListAry;
		private $p_hasStatusAry;
		private $p_orginalAry;
		private $p_StatusAry;
		private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			global $ary_setStatusList;										//print_r($ary_setStatusList);
			$this->p_statusListAry = $ary_setStatusList;
			$this->p_orginalAry = $inputAry;
			$this->fun_setInputAry($inputAry);						//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
			$this->fun_setHasAry();
		}
		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "Status", array("isCountTotal" => 0, "isAddValueTag" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();			//print_r($tmp_Ary); echo "</br>";
			$this->p_StatusAry = $tmp_Ary;
		}
		private function fun_setHasAry() {
			foreach($this->p_statusListAry AS $Key => $Values) {
				$this->p_hasStatusAry[$Key] = 0;
			}
			foreach($this->p_StatusAry AS $Role_ID => $Values) {
				foreach($Values AS $Key => $Status_ID) {
					if(!isset($this->p_hasStatusAry[$Status_ID]) || ($this->p_hasStatusAry[$Status_ID] == 0) ) {
						$this->p_hasStatusAry[$Status_ID] = $Role_ID;
					}					
				}
			}
			ksort($this->p_hasStatusAry);			//print_r($this->p_hasStatusAry);
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_StatusAry[$outputTag] = $inputAry;
        $this->fun_setReturnAry($this->p_StatusAry[$outputTag], $outputTag);
			}
			else {
				$this->p_StatusAry = $inputAry;
        $this->fun_setReturnAry($this->p_StatusAry);
			}
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag]["Status"] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//用來修改角色持有的地位卡，$ModifyType(0: 無；1: 新增byID；2: 刪除byID)
		public function fun_modifyStatus($ModifyType = 0, $Role = array("ID"=> "", "Title" => ""), $Status = array("ID"=> "", "Title" => "")) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {					
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}			                //echo "Role_ID: ".$Role_ID."</br>";
			$Status_ID = "";      //因為地位卡不會重複，要先檢查是否有人有持有。
			if( !isset($Status["ID"]) || ( isset($Status["ID"]) && ($Status["ID"] == "") ) ) {
				if( isset($Status["Title"]) && ($Status["Title"] != "") ) {
					$Status_ID = $this->fun_getStatusTagIDFromName($Status["Title"]);
				}
			}
			else {
				$Status_ID = $Status["ID"];
			}			//echo "Status_ID: ".$Status_ID."</br>";
			
			$res_Ary = $this->p_StatusAry[$Role_ID];		//print_r($this->p_StatusAry[$Role_ID]);
			switch($ModifyType) {
				default:
				case 0:
					break;
				case 1:	//新增
					if($this->p_hasStatusAry[$Status_ID] === 0) {
						$res_Ary = $this->fun_addStatusByTagID($this->p_StatusAry[$Role_ID], $Status_ID);
						$this->p_hasStatusAry[$Status_ID] = $Role_ID;
					}
					break;
				case 2:	//刪除
					if($this->p_hasStatusAry[$Status_ID] !== 0) {
						$res_Ary = $this->fun_delStatusByTagID($this->p_StatusAry[$Role_ID], $Status_ID);
						$this->p_hasStatusAry[$Status_ID] = 0;
					}
					break;
			}
			$this->fun_updateInputAry($res_Ary, $Role_ID);
		}
		//根據所輸入的 Status_Name，從 $ary_setStatusList中找到相對應的 Status_ID
		public function fun_getStatusTagIDFromName ($TagName = "") {
			foreach($this->p_statusListAry AS $Key => $Values) {
				if( in_array(strtolower($TagName), $Values["Title"]) ) {
					return $Key;
					break;
				}
			}
		}
		//主要是根據所輸入的 Status_Name，用 fun_getStatusTagIDFromName()，尋找相對應的 Status_ID後，加入到目標陣列中
		public function fun_addStatusByTagName($inputAry = array(), $TagName = "") {
			$TagID = $this->fun_getStatusTagIDFromName($TagName);
			array_push($inputAry, $TagID);
			return $inputAry;
		}
		//與 fun_addStatusByTagName類似，但就是把 Status_ID 直接放到陣列裡面
		public function fun_addStatusByTagID($inputAry = array(), $TagID = "") {
			array_push($inputAry, $TagID);
			return $inputAry;
		}
		//主要是根據所輸入的 Status_Name，用 fun_getStatusTagIDFromName()，尋找相對應的 Status_ID後，從目標陣列中移除
		public function fun_delStatusByTagName($inputAry = array(), $TagName = "") {
			$TagID = $this->fun_getStatusTagIDFromName($TagName);
			if( array_search($TagID, $inputAry) !== NULL ) {
				unset($inputAry[array_search($TagID, $inputAry)]);	
			}
			return array_values($inputAry);
		}
		//與 fun_delStatusByTagName類似，但就是把 Status_ID 從目標陣列中移除
		public function fun_delStatusByTagID($inputAry = array(), $TagID = "") {
			if( array_search($TagID, $inputAry) !== NULL ) {
				unset($inputAry[array_search($TagID, $inputAry)]);	
			}
			return array_values($inputAry);
		}

		//返回陣列
		public function fun_returnValues() {
			return $this->p_returnAry;
		}
		public function fun_returnCountStatus($Role = array("ID"=> "", "Title" => "")) {
			$Role_ID = "";
			if( !isset($Role["ID"]) || ( isset($Role["ID"]) && ($Role["ID"] == "") ) ) {
				if( isset($Role["Title"]) && ($Role["Title"] != "") ) {
					$tmp_ClsRoles = new cls_withRole;
					$Role_ID = $tmp_ClsRoles->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}			                                          //echo "Role_ID: ".$Role_ID."</br>";
			if ( isset($this->p_StatusAry[$Role_ID]) ) {
				return count($this->p_StatusAry[$Role_ID]);
			}
			return -1;
		}
	}
?>