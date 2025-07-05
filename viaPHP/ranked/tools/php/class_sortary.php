<?php
	//根據某個 Tag，重新排序陣列(主要是為了根據地位卡，重新排序並列出)
	//這部分主要是依據Status的數量來重新排列
  /*
  // 範例
  // $call_clsSortAryBy = new cls_sortAryby;
  // $call_clsSortAryBy->fun_arySort($ary_roleList, "Status", "ASC", array("isCountTotal" => 0, "isAddValueTag" => 0));
  // $tmp_Ary = $call_clsSortAryBy->fun_returnValues();
  // print_r($tmp_Ary);
  */
	class cls_sortAryby {
		private $p_inputAry;
		private $p_sortBy;
		private $p_orderBy;
		private $p_returnAry;
		private $p_isCountTotal;

		public function __construct ($inputAry = array(), $sortBy = "Status", $orderBy = "ASC", $settingAry = array()) {
			$this->fun_setInputAry($inputAry);
			$this->fun_setSortBy($sortBy);
			$this->fun_setOrderBy($orderBy);
			$this->fun_setReturnAry(array());
		}

		private function fun_setInputAry($inputAry = array()) {
			$this->p_inputAry = $inputAry;
		}
		private function fun_setSortBy($sortBy = array()) {
			$this->p_sortBy = $sortBy;
		}
		private function fun_setOrderBy($orderBy = array()) {
			$this->p_orderBy = $orderBy;
		}
		private function fun_setReturnAry($inputAry = array()) {
			$this->p_returnAry = $inputAry;
		}

		public function fun_returnValues() {
			return $this->p_returnAry;
		}
		public function fun_arySort($inputAry = array(), $sortBy = "Status", $orderBy = "ASC", $settingAry = array()) {
			if(!empty($inputAry)) {
				$this->fun_setInputAry($inputAry);
			}
			if(!empty($sortBy)) {
				$this->fun_setSortBy($sortBy);
			}
			if(!empty($orderBy)) {
				$this->fun_setOrderBy($orderBy);
			}
			$ary_aftSort = $ary_tmp = array();
			$tmp_Ary = new cls_takeAryby;
			$tmp_Ary->fun_takeFromMultiAry($this->p_inputAry, $this->p_sortBy, $settingAry);
			$ary_tmp = $tmp_Ary->fun_returnValues();
	
			switch($this->p_orderBy) {
				default:
				case "ASC": 
					asort($ary_tmp);
					break;
				case "DESC": 
					arsort($ary_tmp);
					break;
			}
			foreach($ary_tmp AS $Key => $Values) {
				$ary_aftSort[] = $inputAry[$Key];
			}

			$this->fun_setReturnAry($ary_aftSort);
		}
	}
?>