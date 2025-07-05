<?php
	//與 class的 cls_sortAryby一致
	function fun_arySortBy($inputAry = array(), $sortBy = "status", $orderBy = "ASC") {
		$ary_aftSort = $ary_tmp = array();
		$ary_tmp = fun_takeFromMultiAry($inputAry, $sortBy);

		switch($orderBy) {
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

		return $ary_aftSort;

		//print_r($ary_roleList);
		//$tmp_Ary = fun_arySort($ary_roleList, "status");
	}

	//與 class的 cls_takeAryby一致
	function fun_takeFromMultiAry($inputAry = array(), $findID = "", $isCountTotal = 0) {

		$ary_return = array();
		foreach($inputAry AS $Key => $Values) {
			if($isCountTotal == 1) {
				$ary_return[$Key]["total"] = count($Values[$findID]);
			}
			$ary_return[$Key]["values"] = $Values[$findID];
		}

		return $ary_return;
	}
?>