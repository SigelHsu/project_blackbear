<?php
	$ary_roleList = array(
		'R01' => array(
			'role' => array(
				'code' => 'R01',
				'name' => 'RoyalBastal'
			),
			'player' => 'usera',
			'favor' => array(
				'basic' => 6,
				'temp'	=> array(
					0 => array(
						'type'	=> 2,
						'value' => 4,
					),
					1 => array(
						'type'	=> 1,
						'value' => 3,
					),
				),
			),
			'Status' => array(
				0 => "S01",
				1 => "S08",
				2 => "S26",
			),
			'founds' => array(
				'basic' => 5,
				'tax'		=> 0
			)
		),		
		'R02' => array(
			'role' => array(
				'code' => 'R02',
				'name' => 'Queen'
			),
			'player' => 'userb',
			'favor' => array(
				'basic' => 3,
				'temp'	=> array(
					0 => array(
						'type'	=> 1,
						'value' => 4,
					)
				),
			),
			'Status' => array(
				0 => "S08",
				1 => "S13",
			),
			'founds' => array(
				'basic' => 3,
				'tax'		=> 0
			)
		),
		'R07' => array(
			'role' => array(
				'code' => 'R07',
				'name' => 'Money'
			),
			'player' => 'userC',
			'favor' => array(
				'basic' => 7,
				'temp'	=> array(),
			),
			'Status' => array(
				0 => "S10",
				1 => "S27",
				2 => "S40",
				3 => "S30"
			),
			'founds' => array(
				'basic' => 6,
				'tax'		=> 0
			)
		),
	);

	

	$ary_setRoleList = array(
		'R01' => array(
			'ID' => 'R01', 
			'Title' => array(
				'Basic' => 'Royalty Baster',
				'EN' => 'royalty baster',
				'CH' => '王子',
			)
		),
		'R02' => array(
			'ID' => 'R02', 
			'Title' => array(
				'Basic' => 'Queen',
				'EN' => 'queen',
				'CH' => '皇后',
			)
		),
		'R03' => array(
			'ID' => 'R03', 
			'Title' => array(
				'Basic' => 'Ambensser',
				'EN' => 'ambensser',
				'CH' => '大使',
			)
		),
	);

	$ary_setStatusList = array(
		'S01' => array(
			'ID' => 'S01', 
			'Title' => array(
				'Basic' => 'apple',
				'EN' => 'apple',
				'CH' => '蘋果',
			)
		),
		'S02' => array(
			'ID' => 'S02', 
			'Title' => array(
				'Basic' => 'banana',
				'EN' => 'banana',
				'CH' => '香蕉',
			)
		),
		'S03' => array(
			'ID' => 'S03', 
			'Title' => array(
				'Basic' => 'cocona',
				'EN' => 'cocona',
				'CH' => '椰子',
			)
		),
	);

	// 看起來有必要對每位角色(R)/地位(S)/陰謀(I)卡進行編號
	/*
	// 	有辦法寫出像...
	// 『大使寵愛度+1』  然後系統自動分析後，將文字自動切出 大使 寵愛度 +1 ?
	// 如果要做到 『皇后 對 王子 使用 角色能力/地位/陰謀卡 _____』然後自動觸發後續的動作
	// ...感覺需要 AI...
	*/
	// $tmp_Ary = fun_takeFromMultiAry($ary_roleList, "favor");
	// print_r($tmp_Ary);
	// print_r( fun_makeUpFavor($tmp_Ary) );
	
	//呼叫用以對特定角色，新增/刪除寵愛度的 Class
	class cls_withFavor {
		private $p_inputAry;
		private $p_returnAry;

		public function __construct ($inputAry = array(), $settingAry = array()) {
			$this->fun_setInputAry($inputAry);
			$this->fun_setReturnAry(array());
		}

		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "favor", array("isCountTotal" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();
			$tmp_Ary = $this->fun_makeUpFavor($tmp_Ary);
			$this->p_inputAry = $tmp_Ary;
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		public function fun_returnValues($outputTag = "") {
			if(!empty($outputTag)) {
				return $this->p_returnAry;
			}
			else {
				return $this->p_returnAry;
			}
		}
		public function fun_makeUpFavor($inputAry = array()) {
			
			$tmp_Ary = array();
			foreach($inputAry AS $Key => $Values) {
				$tmp_Ary[$Key] = $Values["values"];
			}

			return $tmp_Ary;
		}
		
		public function fun_addFavorByType($inputAry = array(), $type = 0, $value = 0) {
			if($type != "-1") {
				array_push($inputAry["temp"], array("type" => $type, "value" => $value));
			}
			else {
				$inputAry["basic"] = $inputAry["basic"] + $value;
			}

			return $inputAry;
			//$call_clsForFavor = new cls_withFavor($ary_roleList);
			//foreach($ary_roleList AS $Key => $Values) {
			//	$ary_roleList[$Key]["favor"] = $call_clsForFavor->fun_addFavorByType($Values["favor"], rand("-1", 2), rand("-10", 10));	
			//}
		}
		public function fun_delFavorByType($inputAry = array(), $type = 0) {
			foreach($inputAry["temp"] AS $Key => $Values) { 
				if($Values["type"] == $type) {
					unset($inputAry["temp"][$Key]);	
				}
			}
			$inputAry["temp"] = array_values($inputAry["temp"]);
			return $inputAry;

			// 目前的想法是， favor裡面的 temp為暫時增加的寵愛度
			// 如果 type為 1，則會在該次提案結束後清空
			// 如果 type為 2，則會在該輪結束後清空  #不確定還有沒有其他的例外
			// 先留著這樣...就變成...回合結束/議題結束後，再根據 Type去移除相應的寵愛度
			// $call_clsForFavor = new cls_withFavor($ary_roleList);
			// foreach($ary_roleList AS $Key => $Values) {
			// 	$ary_roleList[$Key]["favor"] = $call_clsForFavor->fun_delFavorByType($Values["favor"], 2);
			// }
		}

		public function fun_sumRolesFavor($inputAry = array()) {
			$tol_Favor = 0;
			
			$tol_Favor = $tol_Favor + $inputAry["basic"];
			foreach($inputAry["temp"] AS $Key => $Values) {
				$tol_Favor += $Values["value"];
			}
	
			return $tol_Favor;

			// foreach($ary_roleList AS $Key => $Values) {
			// 	echo $Key.": </br>";
			// 	print_r($Values["favor"]);
			// 	echo "</br>";
			// 	fun_sumRolesFavor($Values["favor"]);
			// }
		}

		// 測試用
		// $call_clsSortAryBy = new cls_sortAryby;
		// $call_clsSortAryBy->fun_arySort($ary_roleList, "status", "ASC", 1);
		// $tmp_Ary = $call_clsSortAryBy->fun_returnValues();
		// print_r($tmp_Ary);
	}

	//呼叫用以對特定角色，新增/刪除地位卡的 Class
	class cls_withStatus {		
		private $p_roleListAry;
		private $p_statusListAry;
		private $p_inputAry;
		private $p_returnAry;

		/*
		// 範例
		// $tmp_Cls = new cls_withStatus($ary_roleList);
		// $tmp_Cls->fun_modifyStatus(1, array("Title" => "Queen"), array("Title"=>"Cocona"));
		// $tmp_Ary = $tmp_Cls->fun_returnValues();
		// print_r($tmp_Ary);
		
		// $tmp_Cls->fun_modifyStatus(2, array("Title" => "Queen"), array("Title"=>"Cocona"));
		// $tmp_Ary = $tmp_Cls->fun_returnValues();
		// print_r($tmp_Ary);
		*/
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			global $ary_setRoleList;											//print_r($ary_roleList);
			$this->p_roleListAry = $ary_setRoleList;
			global $ary_setStatusList;										//print_r($ary_setStatusList);
			$this->p_statusListAry = $ary_setStatusList;
			$this->fun_setInputAry($inputAry);						//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
		}
		private function fun_setInputAry($inputAry = array()) {
			$tmp_Ary = array();

			$cls_tkAry = new cls_takeAryby;
			$cls_tkAry->fun_takeFromMultiAry($inputAry, "Status", array("isCountTotal" => 0, "isAddValueTag" => 0) );
			$tmp_Ary = $cls_tkAry->fun_returnValues();			//print_r($inputAry);
			$this->p_inputAry = $tmp_Ary;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_inputAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_inputAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_inputAry, $outputTag);
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
					$Role_ID = $this->fun_getRoleTagIDFromName($Role["Title"]);
				}
			}
			else {
				$Role_ID = $Role["ID"];
			}			//echo "Role_ID: ".$Role_ID."</br>";
			$Status_ID = "";
			if( !isset($Status["ID"]) || ( isset($Status["ID"]) && ($Status["ID"] == "") ) ) {
				if( isset($Status["Title"]) && ($Status["Title"] != "") ) {
					$Status_ID = $this->fun_getStatusTagIDFromName($Status["Title"]);
				}
			}
			else {
				$Status_ID = $Status["ID"];
			}			//echo "Status_ID: ".$Status_ID."</br>";
			
			$res_Ary = array();		//print_r($this->p_inputAry[$Role_ID]);
			switch($ModifyType) {
				default:
				case 0:
					$res_Ary = $this->p_inputAry[$Role_ID];
					break;
				case 1:	//新增
					$res_Ary = $this->fun_addStatusByTagID($this->p_inputAry[$Role_ID], $Status_ID);					
					break;
				case 2:	//刪除
					$res_Ary = $this->fun_delStatusByTagID($this->p_inputAry[$Role_ID], $Status_ID);					
					break;
			}
			$this->fun_updateInputAry($res_Ary, $Role_ID);
		}
		//根據所輸入的 Role_Name，從 $ary_roleList中找到相對應的 Status_ID
		public function fun_getRoleTagIDFromName ($TagName = "") {
			foreach($this->p_roleListAry AS $Key => $Values) {
				if( in_array(strtolower($TagName), $Values["Title"]) ) {
					return $Key;
					break;
				}
			}
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
			if( array_search($TagID, $inputAry) != NULL ) {
				unset($inputAry[array_search($TagID, $inputAry)]);	
			}
			return $inputAry;
		}
		//與 fun_delStatusByTagName類似，但就是把 Status_ID 從目標陣列中移除
		public function fun_delStatusByTagID($inputAry = array(), $TagID = "") {
			if( array_search($TagID, $inputAry) != NULL ) {
				unset($inputAry[array_search($TagID, $inputAry)]);	
			}
			return $inputAry;
		}

		//返回陣列
		public function fun_returnValues() {
			return $this->p_returnAry;
		}
	}
	
	$tmp_Cls = new cls_withStatus($ary_roleList);
	$tmp_Cls->fun_modifyStatus(1, array("Title" => "Queen"), array("Title"=>"cocona"));
	$tmp_Cls->fun_modifyStatus(1, array("Title" => "Queen"), array("Title"=>"apple"));
	$tmp_Ary = $tmp_Cls->fun_returnValues();
	
	$tmp_Cls2 = new cls_sortAryby;
	$tmp_Cls2->fun_arySort($tmp_Ary, "Status", "ASC", 0);
	$ary_sortList = $tmp_Cls2->fun_returnValues();
	print_r($ary_sortList);
	// $call_clsSortAryBy = new cls_sortAryby;
	// $call_clsSortAryBy->fun_arySort($ary_roleList, "status", "ASC", 1);
	// $tmp_Ary = $call_clsSortAryBy->fun_returnValues();
	// print_r($tmp_Ary);

?>
<?php	//class
	//根據某個 Tag，重新排序陣列(主要是為了根據地位卡，重新排序並列出)
	//這部分主要是依據Status的數量來重新排列
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
		public function fun_arySort($inputAry = array(), $sortBy = "status", $orderBy = "ASC", $settingAry = array()) {
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

		// 測試用
		// $call_clsSortAryBy = new cls_sortAryby;
		// $call_clsSortAryBy->fun_arySort($ary_roleList, "status", "ASC", 1);
		// $tmp_Ary = $call_clsSortAryBy->fun_returnValues();
		// print_r($tmp_Ary);
	}

	//從陣列中，取出某 Tag的 Key跟 Values (因為太過根據陣列的設計，不適合通用)
	//這部份是用以取出 Stataus/Favor
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
						$ary_return[$Key]["total"] = count($Values[$this->p_findTag]);
					}
					if( $this->p_isAddValueTag == 1 ) {
						$ary_return[$Key]["values"] = $Values[$this->p_findTag];
					}
					else {
						$ary_return[$Key] = $Values[$this->p_findTag];
					}
				}
			}
	
			$this->fun_setReturnAry($ary_return);
		}

		// 測試用
		// $tmp_Ary = new cls_takeAryby;
		// $tmp_Ary->fun_takeFromMultiAry($ary_roleList, "status", array("isCountTotal" => 1));
		// $tmp_Ary2 = $tmp_Ary->fun_returnValues();
		// print_r( $tmp_Ary2 );
	}

	
	exit();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Test</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Product List</h6>
				<div class="dropdown no-arrow">
					<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
						<i class="fas fa-plus fa-sm text-white-50"></i> Add new Product
					</a>
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
							 aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">PNO</th>
								<th scope="col">編號</th>
								<th scope="col">類別</th>
								<th scope="col">名稱</th>
								<th scope="col">條碼</th>
								<th scope="col">倉儲數量</th>
								<th scope="col">工具</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$ary_productList = array(
									0 => array(
										"prod_id" 			=> 1,
										"prod_no" 			=> 'PNO001',
										"prod_code" 		=> 'TR-001',
										"prod_type" 		=> '紙盒',
										"prod_name" 		=> '印刷紙盒',
										"prod_barcode" 	=> '0123456789',
										"prod_quantity" => array(
																				"imports" 	=> '10000',
																				"exports" 	=> '5000',
																				"destroy" 	=> '4000',
																			 ),
										"prod_version" => "1.01",
									),
									1 => array(
										"prod_id" 			=> 2,
										"prod_no" 			=> 'PNO002',
										"prod_code" 		=> 'TR-002',
										"prod_type" 		=> '貼紙',
										"prod_name" 		=> 'TR-001封膜貼紙',
										"prod_barcode" 	=> '',
										"prod_quantity" => array(
																				"imports" 	=> '5000',
																				"exports" 	=> '4000',
																				"destroy" 	=> '0',
																			 ),
										"prod_version" => "1.01",
									),
									2 => array(
										"prod_id" 			=> 3,
										"prod_no" 			=> 'PNO003',
										"prod_code" 		=> 'TR-003',
										"prod_type" 		=> '說明書',
										"prod_name" 		=> 'TR-001說明書',
										"prod_barcode" 	=> '',
										"prod_quantity" => array(
																				"imports" 	=> '5000',
																				"exports" 	=> '4800',
																				"destroy" 	=> '0',
																			 ),
										"prod_version" => "1.01",
									),
								);
							?>
							<?php
								foreach($ary_productList AS $Key => $Values) {
									echo "<tr>";
									echo 	"<th scope = \"row\">".$Values["prod_no"]."</th>";
									echo 	"<td>".$Values["prod_code"]."</td>";
									echo 	"<td>".$Values["prod_type"]."</td>";
									echo 	"<td>".$Values["prod_name"]."</td>";
									echo 	"<td>".$Values["prod_barcode"]."</td>";
									echo 	"<td>".($Values["prod_quantity"]["imports"] - $Values["prod_quantity"]["exports"])."</td>";
									echo 	"<td class = \"row\">";
									echo 		"<button type = \"button\" class = \"btn btn-secondary\" class = \"col\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"Tooltip on top\">";
									echo 		"<i class = \"far fa-file-alt\"></i>查看";
									echo 		"</button>";
									echo 		"<button type = \"button\" class = \"btn btn-secondary\" class = \"col\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"Tooltip on top\">";
									echo 		"<i class = \"far fa-pen\"></i>編輯";
									echo 		"</button>";
									echo 	"</td>";
									echo "</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="paging-area text-center">
					留一行給分頁使用
				</div>
			</div>
		</div>
	</div>
	
</div>