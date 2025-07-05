<?php
	/*
	// !這部分還有些未完成的部分：
	//	紀錄 Log、印出 Log資訊
	*/
	//外交期: Diplomacy
	//外交期前(beforeDiplomacy: 回合小結、寫入角色Log、抓取資料)、外交期(Diplomacy: 紀錄 Log-使用的陰謀卡﹑使用的能力、使用的地位卡)﹑
	//1. 需要紀錄是哪一回合: 第 N回合
	//2. 根據覲見的角色，主要紀錄並且計算相應的資訊(陰謀、地位、寵愛、金錢)
	//3. 因為稍微改過，這邊的紀錄方式會是 {角色}覲見國王；{角色} 使用 {陰謀/地位/能力}:{相關名稱}，{目標角色} {陰謀/地位/寵愛/金錢} {提升/減少/封印}:{數量}
	//目前 Log就另外紀錄、然而健康卡/軍隊卡/人民卡比較接近環境...
	//因為覲見順序純看玩家本身，所以沒有對此多加設計

	//外交期理論上只需要紀錄 某 對 某 使用 陰謀卡/地位/能力，寵愛/地位/金錢 (本次/本回合) 下降/上升 N: 地位卡名稱
	//範例 大使 對 大使，使用 陰謀卡:XXX，寵愛 上升 2 => 大使使用陰謀卡XXX，使自身寵愛度永久上升2點
	//紀錄出來的應該會變成 外交期=>{某A} 對 {某B} 使用 {能力}，{目標事物} {升降} {N數量}: {地位卡名稱(若有)}
?>
<?php
	class cls_withDiplomacy {

		private $p_setRoleListAry;
		private $p_orginalAry;
		private $p_rolesAry;
		private $p_returnAry;
		private $p_settingAry;
		private $p_setTurn;
		
		public function __construct ($inputAry = array(), $settingAry = array("Turn" => 0)) {
			global $ary_setRoleList;												//print_r($ary_setIntrigueList);
			$this->p_setRoleListAry = $ary_setRoleList;
			$this->p_orginalAry = $inputAry;
			$this->p_settingAry = $settingAry;							//echo "settingAry: </br>"; print_r($this->p_settingAry);
			$this->p_setTurn 	= $settingAry["Turn"];
			$this->fun_setInputAry($inputAry);							//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
		}
		private function fun_setInputAry($inputAry = array()) {
			//$tmp_Ary = array();
			$this->p_rolesAry = $inputAry;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_rolesAry[$outputTag] = $inputAry;
				$this->fun_setReturnAry($this->p_rolesAry[$outputTag], $outputTag);
			}
			else {
				$this->p_rolesAry = $inputAry;
				$this->fun_setReturnAry($this->p_rolesAry);
			}
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//分析使用的能力檢查字串，如果具有 "使用"，則進入分析，否則直接寫入 Log(畢竟可能有...皇后來晉見、來詢問寵愛度/卡牌功能等可能性)
		public function fun_useAbilityInDiplomacy($inputSent = "") {
			//echo "fun_useAbilityInDiplomacy ".$inputSent."</br>";														//print_r($this->p_orginalAry); echo "</br></br>";
			if( preg_match("/使用|Used|used|Use|use/", $inputSent) ) {
				//進行分析:
				$cls_anazSent = new cls_withAnalyze;
				$ary_anazData = $cls_anazSent->fun_analyzeSentenseForGeneral($inputSent);			//print_r($ary_anazData); echo "</br></br>"; //exit();
				$resultAry = $cls_anazSent->fun_activeEffective($inputSent, $ary_anazData, $this->p_rolesAry);
				/*
				$req_Turns = 0;
				if($ary_anazData["Basic"]["Ability"]["Type"] == "Intrigue") {
					$Intri_Type = ( preg_match("/後|After|after/", $inputSent) ) ? 2 : 1;
					$req_Turns = $cls_anazSent->get_numerics($ary_anazData["Basic"]["Ability"]["Title"])[0];
					$cls_withIntri = new cls_withIntrigue($this->p_rolesAry);
					$this->fun_updateInputAry($cls_withIntri->fun_modifyIntrigue( 1, 
																		array("ID" => $ary_anazData["Basic"]["Roles"]["To"][1]["ID"]), 
																		array("ID" => $ary_anazData["Basic"]["Ability"]["ID"], "Type" => $Intri_Type), 
																		array("Turns" 	=> $req_Turns, 
																					"Start" 	=> $this->p_settingAry["Turn"], 
																					"Effect" 	=> $ary_anazData["Basic"]["Effect"][1]["Type"],
																					"To"		 	=> $ary_anazData["Basic"]["Roles"]["To"]
																				 ) 
																		)
																	 );
					$this->fun_updateInputAry($cls_withIntri->fun_returnValues());							//print_r($cls_withIntri->fun_returnValues()); exit();
				}
				$resultAry = $this->p_rolesAry;
				if($req_Turns == 0) {
					foreach($ary_anazData["Data"] AS $Key => $Values) {
						switch($Values["Effect"]["Type"]) {
							case "Intrigue":					//調整陰謀卡
								$resultAry = $this->p_rolesAry;
								break;
								
							case "Status":						//調整地位卡
								$cls_withStat = new cls_withStatus($this->p_rolesAry);
								$cls_withStat->fun_modifyStatus( $Values["Effect"]["Cause"], 
																								array("ID"=> $Values["Roles"]["To"]["ID"]), 
																								array("ID"=> $Values["Effect"]["Other"]["ID"]) );
								$resultAry = $cls_withStat->fun_returnValues();
								break;

							case "Money":							//調整金錢
							case "Allowance":					//調整津貼
							case "Tax":								//調整稅率
								//echo "Allowance: ".$Values["Effect"]["Other"]["Type"]."</br>"; exit();
								$cls_withAllow = new cls_withAllowance($this->p_rolesAry);
								$cls_withAllow->fun_modifyAllowance( $Values["Effect"]["Cause"], 
																								array("ID"=> $Values["Roles"]["To"]["ID"]), 
																								array("Type"=> $Values["Effect"]["Other"]["Type"], 
																											"Quantity"=> $Values["Effect"]["Quantity"]) );
								$resultAry = $cls_withAllow->fun_returnValues();
								break;

							case "Favor":							//調整寵愛度
								$cls_withFavor = new cls_withFavor($this->p_rolesAry);
								$cls_withFavor->fun_modifyFavor( $Values["Effect"]["Cause"], 
																								array("ID" => $Values["Roles"]["To"]["ID"]), 
																								array("Type" => $Values["Effect"]["Other"]["Type"], 
																											"Amount" => $Values["Effect"]["Quantity"]) );
								$resultAry = $cls_withFavor->fun_returnValues();
								break;
						}
					}
				}
				*/
			}
			$this->fun_updateInputAry($resultAry); 		//print_r($this->fun_returnValues());
			//寫入 Log
			{
				//$inputSent跟 $this->fun_returnValues() 分別寫入 Log以及 登記到總表中
				//這部分因為還沒有寫 Log部分的程式，晚點再研究...
				//理論上還需要另外搭配描述文字會比較好...皇后晉見國王  皇后 使用 陰謀卡:XXX，使得...；皇后詢問寵愛度； 之類的
			}
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
	// $testSentense = "財政 使用 能力:賄賂，總務 地位 下降 1:私人保鑣，財政 地位 增加 1:私人保鑣，財政 金錢 減少 5";
	// $testSentense = "皇后 使用 陰謀卡:蘋果(2回合後)，皇后 陰謀卡 增加 3";
	// $testSentense = "皇后 使用 陰謀卡:蘋果(完成)，皇后 津貼 增加 4";
	// $testSentense = "大使 使用 地位卡:吟遊詩人，大使 金錢 增加 8";
	// $testSentense = "財務 使用 提案:稅率，財務 稅率 增加 5";
	// $testSentense = "王子 使用 地位卡:獄卒，皇后 金錢 減少 8";
	// $testSentense = "財務 使用 提案:稅率，財務 稅率 減少 3";
	// $testSentense = "總管 使用 地位卡:吟遊詩人，總管 寵愛度 增加 8";
	// $cls_withDep = new cls_withDiplomacy($ary_roleList, array("Turn" => 3));
	// print_r($cls_withDep->fun_useAbilityInDiplomacy($testSentense));
  */
?>