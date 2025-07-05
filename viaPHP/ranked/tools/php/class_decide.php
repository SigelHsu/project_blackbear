<?php
	//require_once("./tools/php/setting_llkDecide.php");
  //呼叫用以篩檢決策卡的 Class
  /*
  // 範例
  // $call_clsDecide = new cls_withDecide;
  // $call_clsDecide->fun_getDecideTagIDFromName("當我死了再說");
  */
	class cls_withDecide {
		private $p_setLang;
		private $p_decideListAry;
		// private $p_orginalAry;
		// private $p_StatusAry;
		// private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			global $set;
			$set_lang = $set["Language"];
			$this->p_setLang = $set_lang;
			global $ary_setDecideList;										//print_r($ary_setDecideList);
			$this->p_decideListAry = $ary_setDecideList;
			// $this->p_orginalAry = $inputAry;
			// $this->fun_setInputAry($inputAry);						//print_r($inputAry);
			// $this->fun_setReturnAry($inputAry);
		}
		// private function fun_setInputAry($inputAry = array()) {
		// 	$tmp_Ary = array();

		// 	$cls_tkAry = new cls_takeAryby;
		// 	$cls_tkAry->fun_takeFromMultiAry($inputAry, "Status", array("isCountTotal" => 0, "isAddValueTag" => 0) );
		// 	$tmp_Ary = $cls_tkAry->fun_returnValues();			//print_r($tmp_Ary); echo "</br>";
		// 	$this->p_StatusAry = $tmp_Ary;
		// }
		// private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
		// 	if(!empty($outputTag)) {
		// 		$this->p_StatusAry[$outputTag] = $inputAry;
    //     $this->fun_setReturnAry($this->p_StatusAry[$outputTag], $outputTag);
		// 	}
		// 	else {
		// 		$this->p_StatusAry = $inputAry;
    //     $this->fun_setReturnAry($this->p_StatusAry);
		// 	}
		// }
		// private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
		// 	if(!empty($outputTag)) {
		// 		$this->p_returnAry[$outputTag]["Status"] = $inputAry;
		// 	}
		// 	else {
		// 		$this->p_returnAry = $inputAry;
		// 	}
		// }

		//根據所輸入的 Decide_Name，從 $ary_setDecideList中找到相對應的 Decide_ID
		public function fun_getDecideTagIDFromName ($TagName = "") {
			foreach($this->p_decideListAry AS $Key => $Values) {
				if( in_array(strtolower($TagName), $Values["Title"]) ) {
					return array(
												"ID" 				=> $Key,
												"Title" 		=> $Values["Title"], 
												"Condition" => $Values["Condition"]
											);
					break;
				}
			}
		}

		// //返回陣列
		// public function fun_returnValues() {
		// 	return $this->p_returnAry;
		// }
	}
?>