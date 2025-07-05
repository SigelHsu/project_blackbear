<?php

	//從陣列中，取出某 Tag的 Key跟 Values (因為太過根據陣列的設計，不適合通用)
	//這部份是用以取出 Stataus/Favor
  /*
  // 測試用
	// $cls_tkAry = new cls_takeAryby;
	// $cls_tkAry->fun_takeFromMultiAry($inputAry, "Allowance", array("isCountTotal" => 0, "isAddValueTag" => 0) );
  // $tmp_Ary = $cls_tkAry->fun_returnValues();
  // print_r( $tmp_Ary );
  */
	class cls_takeAryby {
		private $p_inputAry;
		private $p_findTag;
		private $p_isCountTotal = 0;
		private $p_isAddValueTag = 1;
		private $p_returnAry;

		public function __construct ($inputAry = array(), $findTag = "", $settingAry = array()) {
			$this->fun_setInputAry($inputAry);
			$this->fun_setFindTag($findTag);
			if( isset($settingAry["isCountTotal"]) ) {
				$this->fun_setIsCountTotal( $settingAry["isCountTotal"] );
			}
			if( isset($settingAry["isAddValueTag"]) ) {
				$this->fun_setIsAddValueTag( $settingAry["isAddValueTag"] );
			}
			$this->fun_setReturnAry(array());
		}
		
		private function fun_setInputAry($inputAry = array()) {
			$this->p_inputAry = $inputAry;
		}
		private function fun_setFindTag($findTag = array()) {
			$this->p_findTag = $findTag;
		}
		private function fun_setIsCountTotal($isCountTotal = 0) {
			$this->p_isCountTotal = $isCountTotal;
		}
		private function fun_setIsAddValueTag($isAddValueTag = 1) {
			$this->p_isAddValueTag = $isAddValueTag;
		}
		private function fun_setReturnAry($inputAry = array()) {
			$this->p_returnAry = $inputAry;
		}
		
		public function fun_returnValues() {
			return $this->p_returnAry;
		}

		public function fun_takeFromMultiAry($inputAry, $findTag, $settingAry) {
			if(!empty($inputAry)) {
				$this->fun_setInputAry($inputAry);
			}
			if(!empty($findTag)) {
				$this->fun_setFindTag($findTag);
			}
			if( !empty($settingAry) && (isset($settingAry["isCountTotal"])) ) {
				$this->fun_setIsCountTotal( $settingAry["isCountTotal"] );
			}
			if( !empty($settingAry) && (isset($settingAry["isAddValueTag"])) ) {
				$this->fun_setIsAddValueTag( $settingAry["isAddValueTag"] );
			}

			$ary_return = array();
			if($this->p_findTag != "") {
				foreach($this->p_inputAry AS $Key => $Values) {
					if( $this->p_isCountTotal == 1 ) {
						$ary_return[$Key]["Total"] = count($Values[$this->p_findTag]);
					}
					if( $this->p_isAddValueTag == 1 ) {
						$ary_return[$Key]["Values"] = $Values[$this->p_findTag];
					}
					else {
						$ary_return[$Key] = $Values[$this->p_findTag];
					}
				}
			}
	
			$this->fun_setReturnAry($ary_return);
		}
	}
?>