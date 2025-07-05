<?php
	//$testSentense = "總管 使用 能力:請願 > 使 皇后 金錢 減少 1，男爵 金錢 增加 1";
	//$testSentense = "主教 使用 陰謀:XXX 來 請願 > 使 大使 地位 減少 1，男爵 金錢 增加 1";
	//發現字串裡面有 "請願"時，執行另一段函式(能否請願 > 綠燈: 已請願, 黃燈: 待請願, 紅燈: 無法請願)
	//應該會包括: 拆分字串/分析、投票流程、寵愛度結算、(判斷是否國王主持)決策卡/懿旨，結果(若通過: 實際處理效果: 男爵 的 請願，皇后)

	//fun_analyzeSentenseForGeneral()這是一般類型的，使用卡牌/能力 ...但如果是請願類別的，就要另外處理
	//另一種思路...但 fun_splitSentense()和 fun_analyzeSentense()要重寫
	//$testSentense = "大使 使用 陰謀卡:蘋果,大使 寵愛 上升 2:本次";
	//$testSentense = "男爵 使用 地位卡:賭徒，皇后 金錢 減少 1，男爵 金錢 增加 1";
	//$testSentense = "財政 使用 能力:賄賂，總務 地位 下降 1:私人保鑣，財政 地位 增加 1:私人保鑣，財政 金錢 減少 5";
	//$testSentense = "國王 使用 軍隊卡:級別三，全員 寵愛度 下降 1";
	//0: 使用者; 1: 受影響者1; 2: 受影響者2; 3: 受影響者3
	//0-0: 使用者; 0-1: 無特殊; 0-2: 能力種類; 0-3: 能力名稱
	//N-0: 對象; N-1: 效果對象; N-2: 效果結果; N-3: 效果數量; N-4:效果持續/卡牌名稱

	// $cls_anazSent = new cls_withAnalyze;
	// print_r($cls_anazSent->fun_analyzeSentenseForGeneral($testSentense));
	/*
	$ary_abiUsed["Basic"] = array(
		"Roles" => array(
			"From" 	=> $ary_inpSent[0][0],
			"To" 		=> array(),
		),
		"Ability" => array(
			"Type" 	=> $Values[2],				//陰謀/地位/能力
			"Title" => $Values[3],				//相關名稱
		),
		"Effect" => array(
			"Type" 			=> $ary_inpSent[2][0],		//地位/寵愛/金錢
			"Cause" 		=> $ary_inpSent[2][1],		//上升/下降
			"Quantity" 	=> $ary_inpSent[2][2],		//數量
			"Other" 		=> $ary_inpSent[2][3]			//持續時間/卡牌名稱(地位)
		),
	);
	*/
	class cls_withAnalyze {
		private $p_setLang;
		private $p_orginalSent;
		private $p_analyzeAry;
		private $p_returnAry;

		public function __construct ($inputAry = "", $settingAry = array()) {
			global $set;
			$set_lang = $set["Language"];
			$this->p_setLang = $set_lang;
			$this->fun_setInputAry($inputAry);						//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
		}
		private function fun_setInputAry($inputAry = array()) {
			$this->p_orginalSent = $inputAry;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_analyzeAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_analyzeAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_inputAry, $outputTag);
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag]["Role"] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}

		//用以切割字串，整理成可以分析的詞語
		//下列的網址是教你怎麼用正規化去篩選拆分
		//https://medium.com/verybuy-dev/php%E6%AD%A3%E8%A6%8F%E8%A1%A8%E9%81%94%E5%BC%8F%E6%AF%94%E5%B0%8D-89b03ebc10eb
		public function fun_splitSentenseForGeneral($inputSent = "") { 		
			$ary_inpSent = array();
			//foreach(preg_split("/;|；/", $inputSent) AS $Key => $Value) {
				foreach( preg_split("/,|，/", $inputSent) AS $Key => $Value ) {
					$ary_inpSent[$Key] = preg_split("/: | |:|：/", $Value);
				}
			//}
			return $ary_inpSent;
		}
		public function fun_analyzeSentenseForGeneral($inputSent = "") {
			if( $inputSent === "") {
				$inputSent = $this->p_orginalSent;
			}

			$ary_inpSent = $this->fun_splitSentenseForGeneral($inputSent); 		//print_r($ary_inpSent); echo "</br>";
			$cls_intri 	= new cls_withIntrigue;
			$cls_status = new cls_withStatus;
			
			foreach($ary_inpSent AS $Key => $Values) {
				if($Key == 0) {
					$ary_abiUsed = array(
						"Basic" => array(
							"Roles" => array(
								"From" 	=> $this->fun_analyzeByRoles($Values[0]),
								"To" 		=> array(),
							),
							"Ability" => $this->fun_analyzeByAbility( array("Type" => $Values[2], "Title" => $Values[3]) ),
							"Effect" 	=> array(),
							"Log"		 	=> array( $Key => $Values )
						),
						"Data" => array()
					);
				}
				else {
					$ary_abiUsed["Basic"]["Roles"]["To"][$Key] 	= $this->fun_analyzeByRoles($Values[0]);
					$ary_abiUsed["Basic"]["Effect"][$Key] 			= $this->fun_analyzeByEffect(array("Type" => $Values[1], "Cause" => $Values[2], "Quantity" => $Values[3], "Other" => (isset($Values[4]) ? trim($Values[4]) : "") ));
					$ary_abiUsed["Basic"]["Log"][$Key] 					= $Values;
					$ary_abiUsed["Data"][$Key] 									= array(
						"Roles" => array(
							"From" 	=> $ary_abiUsed["Basic"]["Roles"]["From"],
							"To" 		=> $ary_abiUsed["Basic"]["Roles"]["To"][$Key],
						),
						"Ability" => $ary_abiUsed["Basic"]["Ability"],
						"Effect" 	=> $ary_abiUsed["Basic"]["Effect"][$Key]
					);
				}
			}
			return $ary_abiUsed;
		}
		
		public function fun_splitSentenseForCouncil($inputSent = "") { 		
			$ary_inpSent = array();
			//foreach(preg_split("/;|；/", $inputSent) AS $Key => $Value) {
				foreach( preg_split("/>|＞/", $inputSent) AS $Key => $Value ) {
					$ary_inpSent[$Key] = preg_split("/ |:|：/", trim($Value));
				}
			//}
			return $ary_inpSent;
		}
		public function fun_splitSentenseForVote($inputSent = "") { 		
			$ary_inpSent = array();
			foreach( preg_split("/,|，/", $inputSent) AS $Key => $Value ) {
				$ary_inpSent[$Key] = preg_split("/ |:|：/", trim($Value));
			}
			return $ary_inpSent;
		}
		public function fun_splitSentenseForDecision($inputSent = "") { 		
			$ary_inpSent = array();
			foreach( preg_split("/ |:|：/", $inputSent) AS $Key => $Value ) {
				$ary_inpSent[$Key] = preg_split("/,|，/", trim($Value));
			}
			return $ary_inpSent;
		}
		public function fun_splitSentenseForConclusion($inputSent = "") { 
			$ary_inpSent = array();
			foreach( preg_split("/;|；/", $inputSent) AS $Key1 => $Value1 ) {
				if($Key1 == 0) {
					$ary_inpSent["Conclusion"] = preg_split("/ |:|：/", trim($Value1));
					$ary_inpSent["Conclusion"] = array_values( array_filter($ary_inpSent["Conclusion"]) );
				}
				else {
					$ary_inpSent["ConEffect"][] = $this->fun_analyzeSentenseForGeneral(trim($Value1));
				}
			}
			return $ary_inpSent;
		}
		public function fun_analyzeSentenseForCouncil($inputSent = "", $petiStep = 0) {
			//echo "fun_analyzeSentenseForCouncil: ".$inputSent.":".$petiStep."</br>";
			if( $inputSent === "") {
				$inputSent = $this->p_orginalSent;
			}
			switch($petiStep) {
				default:
				case 0:
					$ary_abiUsed = array();
					break;
				case 1:
					$ary_inpSent = $this->fun_splitSentenseForCouncil($inputSent); 											//print_r($ary_inpSent); echo "</br>";
					$ary_abiUsed["Step".$petiStep] = $this->fun_analyzeCouncilStep1($ary_inpSent);
					break;
				case 2:
					$ary_inpSent = $this->fun_splitSentenseForCouncil($inputSent);											//print_r($ary_inpSent); echo "</br>";
					$ary_abiUsed["Step".$petiStep][] = $this->fun_analyzeCouncilStep2($ary_inpSent);		//可能會有很多筆使用能力/卡牌的資料
					break;
				case 3:
					$ary_inpSent = $this->fun_splitSentenseForVote($inputSent);													//print_r($ary_inpSent); echo "</br>";
					$ary_abiUsed["Step".$petiStep] = $this->fun_analyzeCouncilStep3($ary_inpSent);			//可能會有很多筆投票資料，雖然後來改成以逗號分隔
					break;
				case 5:
					$ary_inpSent = $this->fun_splitSentenseForDecision($inputSent);											//print_r($ary_inpSent); echo "</br>"; exit();
					$ary_abiUsed["Step".$petiStep] = $this->fun_analyzeCouncilStep5($ary_inpSent);			//由於主教的異端指控，需要翻開兩張決策卡
					break;
				case 6:
					$ary_inpSent = $this->fun_splitSentenseForConclusion($inputSent);										//print_r($ary_inpSent); echo "</br>"; exit();
					$ary_abiUsed["Step".$petiStep] = $this->fun_analyzeCouncilStep6($ary_inpSent);			//可能會有很多筆受影響的資料，這裡改用分號來區分(除了第一筆資料)
					break;
			}
			return $ary_abiUsed;	//這東西要想辦法寫到 Log裡面，在每次分析前，要從 Log裡面先讀出來，然後改寫
		}
		//1.請願內容: {角色} 藉由 {陰謀/地位/能力}:{能力名稱} > 進行 請願:{敘述}(Log紀錄)
		public function fun_analyzeCouncilStep1($ary_inpSent = array()) {
			foreach($ary_inpSent AS $Key => $Values) {
				if($Key == 0) {
					$ary_abiUsed = array(
						"Basic" => array(
							"Roles" => array(
								"From" 	=> $this->fun_analyzeByRoles($Values[0]),
							),
							"Ability" 	=> $this->fun_analyzeByAbility( array("Type" => $Values[2], "Title" => $Values[3]) ),
							"Petition" 	=> array(),
							"Log"		 		=> array( $Key => $Values )
						),
						"Data" => array()
					);
				}
				else {
					$ary_abiUsed["Basic"]["Petition"] 		= trim($Values[2], "/ |{|}/");
					$ary_abiUsed["Basic"]["Log"][$Key] 		= $Values;
					$ary_abiUsed["Data"]["Petition"]			= array(
						"Roles" => array(
							"From" 	=> $ary_abiUsed["Basic"]["Roles"]["From"],
						),
						"Ability" => $ary_abiUsed["Basic"]["Ability"],
						"Request" => $ary_abiUsed["Basic"]["Petition"]
					);
				}
			}

			return $ary_abiUsed;
		}		
		//2.使用卡牌: {角色} 使用 {陰謀/地位/能力}:{能力名稱} > 效果:{效果字串}(包含了 "效果" 文字，表示為條件滿足後觸發，於步驟6時再次觸發(Log紀錄)
		//					 {角色} 使用 {陰謀/地位/能力}:{能力名稱}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱/持續}(通常為影響投票結果，但有例外:如保留請願/封印請願的)(效果觸發)
		public function fun_analyzeCouncilStep2($ary_inpSent = array()) {
			foreach($ary_inpSent AS $Key => $Values) {
				if($Key == 0) {
					$ary_abiUsed = array(
						"Basic" => array(
							"Roles" => array(
								"From" 	=> $this->fun_analyzeByRoles($Values[0]),
							),
							"Ability" => $this->fun_analyzeByAbility( array("Type" => $Values[2], "Title" => $Values[3]) ),
							"Effect" 	=> array(),
							"Log"		 	=> array( $Key => $Values )
						),
						"Data" => array()
					);
				}
				else {
					$ary_abiUsed["Basic"]["Effect"] 		= trim($Values[1], "/ |{|}/");
					$ary_abiUsed["Basic"]["Log"][$Key] 		= $Values;
					$ary_abiUsed["Data"]["Addition"]			= array(
						"Roles" => array(
							"From" 	=> $ary_abiUsed["Basic"]["Roles"]["From"],
						),
						"Ability" => $ary_abiUsed["Basic"]["Ability"],
						"Effect" 	=> $ary_abiUsed["Basic"]["Effect"]
					);
				}
			}

			return $ary_abiUsed;
		}
		//3.投票紀錄: {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)(Log紀錄)、
		//					 {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述), {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)， {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)
		public function fun_analyzeCouncilStep3($ary_inpSent = array()) {
			foreach($ary_inpSent AS $Key => $Values) {
				if( preg_match("/(|)/", $Values[0]) ) {
					$ary_abiUsed["Basic"]["Roles"][$Key] 						= $this->fun_analyzeByRoles(explode("(", $Values[0])[0]);
					$ary_abiUsed["Basic"]["Roles"][$Key]["RoleExt"] = trim(explode("(", $Values[0])[1], "/(|)/");
				}
				else {
					$ary_abiUsed["Basic"]["Roles"][$Key] 					= $this->fun_analyzeByRoles($Values[0]);
				}
				if( preg_match("/(|)/", $Values[1]) ) {
					$ary_abiUsed["Basic"]["Roles"][$Key]["Vote"] 		= $Values[1];
					$ary_abiUsed["Basic"]["Roles"][$Key]["VoteID"] 	= $this->fun_analyzeTheVote($Values[1]);
					$ary_abiUsed["Basic"]["Roles"][$Key]["VoteExt"] = trim(explode("(", $Values[1])[1], "/(|)/");
				}
				else {
					$ary_abiUsed["Basic"]["Roles"][$Key]["Vote"] 		= $Values[1];
					$ary_abiUsed["Basic"]["Roles"][$Key]["VoteID"] 	= $this->fun_analyzeTheVote($Values[1]);
				}
				$ary_abiUsed["Basic"]["Log"][$Key] = $Values;
			}
			$ary_abiUsed["Data"]["Votes"] = $ary_abiUsed["Basic"]["Roles"];

			return $ary_abiUsed;
		}
		//5.決策結果: {決策卡/攝政王}: {通過/不通過}(PS.主教的異端指控需要紀錄兩張)(Log紀錄)、
		public function fun_analyzeCouncilStep5($ary_inpSent = array()) {
			foreach($ary_inpSent[1] AS $Key => $Values) {
				$ary_abiUsed["Basic"]["Decision"][$Key] = $this->fun_analyzeByDecision($Values);
				$ary_abiUsed["Basic"]["Log"][$Key] = $Values;
			}
			$ary_abiUsed["Data"]["Decision"] = $ary_abiUsed["Basic"]["Decision"];

			return $ary_abiUsed;
		}
		//6.實際效果結算: 結論 > {通過/否決/保留} -> 先判斷是否保留，是的話，整個內容要複製到 pending裡面
		//							{角色} 使用 能力:請願，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} 
		//							{角色} 使用 {陰謀/地位/能力:{能力名稱}}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} (效果觸發 & Log紀錄)
		public function fun_analyzeCouncilStep6($ary_inpSent = array()) {
			
			$ary_abiUsed["Conclusion"] = array (
				"ID" 		=> $this->fun_analyzeTheConclusion($ary_inpSent["Conclusion"][2]),
				"Title" => $ary_inpSent["Conclusion"][2]
			);
			if($ary_abiUsed["Conclusion"]["ID"] === "9") {
				//取得整筆 請願，直接放入 pending的 Log部分(部分可能為空)
				//在結論環節使用過的卡牌，部分可能會有所保留(還是不保留?)	
			}
			else {
				$ary_abiUsed["ConEffect"] = $ary_inpSent["ConEffect"];
				/*
				foreach($ary_inpSent["ConEffect"] AS $Key => $Value) {
					print_r($Value);
					$ary_abiUsed["ConEffect"][$Key] = array(

					);

				}
				*/
			}
			return $ary_abiUsed;
		}

		//使文字式分割成的陣列，實際作用的部分
		public function fun_activeEffective ($inputSent = "", $ary_anazData = array(), $roleAry = array()) {
			//echo "fun_activeEffective: </br>";	print_r($ary_anazData);
			$resultAry = array();
			$req_Turns = 0;
			if($ary_anazData["Basic"]["Ability"]["Type"] == "Intrigue") { 		//echo "Intrigue";
				$Intri_Type = ( preg_match("/後|After|after/", $inputSent) ) ? 2 : 1;
				$req_Turns = $this->get_numerics($ary_anazData["Basic"]["Ability"]["Title"])[0];
				$cls_withIntri = new cls_withIntrigue($roleAry);
				$cls_withIntri->fun_modifyIntrigue( 1, 
																						array("ID" => $ary_anazData["Basic"]["Roles"]["To"][1]["ID"]), 
																						array("ID" => $ary_anazData["Basic"]["Ability"]["ID"], "Type" => $Intri_Type), 
																						array("Turns" 	=> $req_Turns, 
																									"Start" 	=> $this->p_settingAry["Round"], 
																									"Effect" 	=> $ary_anazData["Basic"]["Effect"][1]["Type"],
																									"To"		 	=> $ary_anazData["Basic"]["Roles"]["To"]
																									) 
																					);
				$roleAry = $cls_withIntri->fun_returnValues();							//print_r($roleAry); exit();
			}
			$resultAry = $roleAry;
			if($req_Turns == 0) {
				foreach($ary_anazData["Data"] AS $Key => $Values) {
					switch($Values["Effect"]["Type"]) {
						case "Intrigue":					//調整陰謀卡
							$resultAry = $roleAry;
							break;
							
						case "Status":						//調整地位卡
							$cls_withStat = new cls_withStatus($roleAry);
							$cls_withStat->fun_modifyStatus( $Values["Effect"]["Cause"], 
																								array("ID"=> $Values["Roles"]["To"]["ID"]), 
																								array("ID"=> $Values["Effect"]["Other"]["ID"]) );
							$resultAry = $cls_withStat->fun_returnValues();
							break;

						case "Money":							//調整金錢
						case "Allowance":					//調整津貼
						case "Tax":								//調整稅率
							//echo "Allowance: ".$Values["Effect"]["Other"]["Type"]."</br>"; exit();
							$cls_withAllow = new cls_withAllowance($roleAry);
							$cls_withAllow->fun_modifyAllowance( $Values["Effect"]["Cause"], 
																										array("ID"=> $Values["Roles"]["To"]["ID"]), 
																										array("Type"=> $Values["Effect"]["Other"]["Type"], 
																													"Quantity"=> $Values["Effect"]["Quantity"]) );
							$resultAry = $cls_withAllow->fun_returnValues();
							break;

						case "Favor":							//調整寵愛度
							$cls_withFavor = new cls_withFavor($roleAry);
							$cls_withFavor->fun_modifyFavor( $Values["Effect"]["Cause"], 
																								array("ID" => $Values["Roles"]["To"]["ID"]), 
																								array("Type" => $Values["Effect"]["Other"]["Type"], 
																											"Amount" => $Values["Effect"]["Quantity"]) );
							$resultAry = $cls_withFavor->fun_returnValues();
							//print_r($resultAry);
							break;
					}
				}
			}
			return $resultAry;
		}

		public function fun_analyzeByRoles ($inputTag = "") {
			$cls_roles = new cls_withRole;
			if( preg_match("/全員|所有人|All|all/", $inputTag) ) {
				return array(
					"ID" 		=> "All",
					"Name" 	=> $inputTag
				);
			}
			else {
				return array(
								"ID" 		=> $cls_roles->fun_getRoleTagIDFromName($inputTag),
								"Name" 	=> $inputTag
				);
			}
		}
		public function fun_analyzeByAbility ( $inputAry = array("Type" => "", "Title" => "") ) {
			$cls_intri 	= new cls_withIntrigue;
			$cls_status = new cls_withStatus;
			$ary_anzAbi = array();
			switch($inputAry["Type"]) {
				case ( preg_match("/陰謀卡|陰謀|Intrigue|intrigue/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzAbi = array(
						"Type" 	=> "Intrigue",
						"ID"	 	=> $cls_intri->fun_getIntrigueTagIDFromName(preg_split("/\(/", $inputAry["Title"])[0]),
						"Title"	=> $inputAry["Title"]
					);
					break;
				case ( preg_match("/地位卡|地位|Status|status/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzAbi = array(
						"Type" 	=> "Status",
						"ID"	 	=> $cls_status->fun_getStatusTagIDFromName($inputAry["Title"]),
						"Title"	=> $inputAry["Title"]
					);
					echo "Status";
					break;
				case ( preg_match("/角色能力|能力|Ability|ability/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzAbi = array(
						"Type" 	=> "Ability",
						"ID"	 	=> $inputAry["From"],
						"Title"	=> $inputAry["Title"]
					);
					break;
				case ( preg_match("/軍隊動員卡|軍隊動員|軍隊卡|動員卡|軍隊|動員|Militry/", $inputAry["Type"]) ? TRUE: FALSE ):
						$ary_anzAbi = array(
							"Type" 	=> "Militry",
							"ID"	 	=> "待處理",
							"Title"	=> $inputAry["Title"]
						);
						break;
				case ( preg_match("/人民暴動卡|人民動亂卡|人民暴動|人民動亂|人民卡|動亂卡|暴動卡|人民|動亂|暴動|People/", $inputAry["Type"]) ? TRUE: FALSE ):
						$ary_anzAbi = array(
							"Type" 	=> "People",
							"ID"	 	=> "待處理",
							"Title"	=> $inputAry["Title"]
						);
						break;
			}
			return $ary_anzAbi;
		}
		public function fun_analyzeByEffect ( $inputAry = array("Type" => "", "Cause" => "", "Quantity" => "", "Other" => "") ) {
			$cls_intri 	= new cls_withIntrigue;
			$cls_status = new cls_withStatus;
			$ary_anzEff = array();
			switch($inputAry["Type"]) {
				case ( preg_match("/陰謀卡|陰謀|Intrigue|intrigue/", $inputAry["Type"]) ? TRUE : FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Intrigue",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> $this->fun_analyzeTheDuration($inputAry["Other"]),			//永久/一次/一回合(陰謀卡通常是永久)
							"ID" 		=> 0,
							"Title" => $inputAry["Other"]
						)
					);
					break;
				case ( preg_match("/地位卡|地位|Status|status/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Status",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> $this->fun_analyzeTheDuration($inputAry["Other"]),		//永久/一次/一回合(地位卡通常是永久，但遇到封印會是一回合)
							"ID" 		=> $cls_status->fun_getStatusTagIDFromName($inputAry["Other"]),
							"Title" => $inputAry["Other"]
						)
					);
					break;
				case ( preg_match("/津貼|Allowance|allowance|Allow|allow/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Allowance",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> 1,									//津貼(永久)
							"ID" 		=> 0,
							"Title" => $inputAry["Other"]
						)
					);
					break;
				case ( preg_match("/稅率|稅金|Tax Rate|Tax|Rate|tax rate|tax|rate/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Tax",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> 2,									//稅率(永久)
							"ID" 		=> 0,
							"Title" => $inputAry["Other"]
						)
					);
					break;
				case ( preg_match("/金錢|Money|money/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Money",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> 3,									//金錢(登記用)
							"ID" 		=> 0,
							"Title" => $inputAry["Other"]
						)
					);
					break;
				case ( preg_match("/寵愛度|寵愛|Favor|favor/", $inputAry["Type"]) ? TRUE: FALSE ):
					$ary_anzEff = array(
						"Type" 			=> "Favor",
						"Cause"			=> $this->fun_analyzeTheCause($inputAry["Cause"]),
						"Quantity" 	=> $inputAry["Quantity"],
						"Other"			=> array(
							"Type"	=> $this->fun_analyzeTheDuration($inputAry["Other"]),		//永久/一次/一回合(寵愛度因為有在會議期使用的陰謀卡，所以三種狀況都有)
							"ID" 		=> 0,
							"Title" => $inputAry["Other"]
						)
					);
					break;
			}
			return $ary_anzEff;
		}
		public function fun_analyzeByDecision ($inputTag = "") {
			//$cls_decision = new cls_withDecision;	//尚未寫好
			$call_clsDecide = new cls_withDecide;
			$ary_findDecide = $call_clsDecide->fun_getDecideTagIDFromName("inputTag");
			return array(
							"ID" 				=> $ary_findDecide["ID"],
							"Name" 			=> $inputTag, 
							"Condition" => $ary_findDecide["Condition"][$this->p_setLang]
			);
		}
		public function fun_analyzeTheVote ($inputVote = "") {
			//echo "fun_analyzeTheVote(".$inputVote."): </br>";
			return ( preg_match("/贊成|同意|Yes|yes|Agree|agree/", $inputVote) ? 1 : (
									preg_match("/反對|不同意|No|no|Disagree|disagree/", $inputVote) ? -1 : 0
								)
						);
		}
		public function fun_analyzeTheCause ($inputCause = "") {
			return ( preg_match("/上升|提升|增加|Add|add/", $inputCause) ? 1 : ( 
									preg_match("/下降|減少|Sub|sub/", $inputCause) ? 2 : ( 
										preg_match("/封鎖|封印|Forbidden|forbidden/", $inputCause) ? 3 : 0 
									) 
								)
						);
		}
		public function fun_analyzeTheDuration ($inputDuration = "") {
			return ( preg_match("/永久|Permanent|permanent/", $inputDuration) ? "-1" : ( 
									preg_match("/一次|單次|本次|One Times|times|This time|this time|This|this|Single|single|Once|once/", $inputDuration) ? "1" : ( 
										preg_match("/一回合|一回|回合|One Turn|Turn|turn|Turns|turns/", $inputDuration) ? "2" : "-1" 
									) 
								)
						);
		}
		public function fun_analyzeTheConclusion ($inputConclusion = "") {
			return ( preg_match("/通過|承認|Passed|passed|Pass|pass/", $inputConclusion) ? "1" : ( 
									preg_match("/不通過|否決|Unpassed|unpassed|Deny|deny|Rejected|rejected|Reject|reject/", $inputConclusion) ? "-1" : ( 
										preg_match("/保留|待議|Pending|pending/", $inputConclusion) ? "9" : "0" 
									) 
								)
						);
		}
		//抓出具有數字的部分
		public function get_numerics ($str) {
			preg_match_all('/\d+/', $str, $matches);
			return $matches[0];
		}
	}


	/*
	//下方的是初始版本，初始版本的字串比較限縮，變成一行只能放一次
	//但同樣的能力/卡片對多人使用時，變得會有些缺少

	// $testSentense = "大使 對 大使,使用 陰謀卡:蘋果，寵愛 上升 2:永久";
	// $testSentense = "男爵 對 皇后,使用 地位卡:賭徒，地位 下降 1:國王的代言人";
	// $testSentense = "財政 對 總務,使用 能力:賄賂，地位 下降 1:私人保鑣";
	*/
	//將固定型態的句子，拆分成可供程式分析的小字段
	/*
	// function fun_splitSentense($inputSent = "") {
	// 	//https://medium.com/verybuy-dev/php%E6%AD%A3%E8%A6%8F%E8%A1%A8%E9%81%94%E5%BC%8F%E6%AF%94%E5%B0%8D-89b03ebc10eb
	// 	$ary_inpSent = array();
	// 	$tmp_inpSent = preg_split("/,|，/", $inputSent);

	// 	foreach($tmp_inpSent AS $Key => $Value) {
	// 		$ary_inpSent[$Key] = preg_split("/ |:|：/", $Value);
	// 	}
	// 	return $ary_inpSent;
	// }
	*/
	
	//將各種小字段，經過判斷式拓展成特定的 ID
	//0: 角色 => 0-0: 使用者; 0-1: 無特殊; 0-2: 對象;
	//1: 卡牌 => 1-0: 無特殊; 1-1: 能力種類; 1-2: 能力名稱; 
	//2: 效果 => 2-0: 效果對象; 2-1: 效果結果; 2-2: 效果數量; 2-3:效果持續/卡牌名稱; 
	/*
	// function fun_analyzeSentense($inputSent = "") {
	// 	$ary_inpSent = fun_splitSentense($inputSent);

	// 	$ary_abiUsed = array(
	// 		"Roles" => array(
	// 			"From" 	=> $ary_inpSent[0][0],
	// 			"To" 		=> $ary_inpSent[0][2],
	// 		),
	// 		"Ability" => array(
	// 			"Type" 	=> $ary_inpSent[1][1],				//陰謀/地位/能力
	// 			"Title" => $ary_inpSent[1][2],				//相關名稱
	// 		),
	// 		"Effect" => array(
	// 			"Type" 			=> $ary_inpSent[2][0],		//地位/寵愛/金錢
	// 			"Cause" 		=> $ary_inpSent[2][1],		//上升/下降
	// 			"Quantity" 	=> $ary_inpSent[2][2],		//數量
	// 			"Other" 		=> $ary_inpSent[2][3]			//持續時間/卡牌名稱(地位)
	// 		),
	// 	);

	// 	$cls_roles 	= new cls_withRole;
	// 	$cls_intri 	= new cls_withIntrigue;
	// 	$cls_status = new cls_withStatus;
	// 	$ary_abiUsed["Roles"] = array(
	// 		"From" => fun_analyzeByRoles($ary_abiUsed["Roles"]["From"]),
	// 		"To" 	 => fun_analyzeByRoles($ary_abiUsed["Roles"]["To"]),
	// 	);
	// 	$ary_abiUsed["Ability"] = fun_analyzeByAbility( array("Type" => $ary_abiUsed["Ability"]["Type"], "Title" => $ary_abiUsed["Ability"]["Title"]) );
	// 	$ary_abiUsed["Effect"] 	= fun_analyzeByEffect( array("Type" => $ary_abiUsed["Effect"]["Type"], "Cause" => $ary_abiUsed["Effect"]["Cause"], "Quantity" => $ary_abiUsed["Effect"]["Quantity"], "Other" => (isset($ary_abiUsed["Effect"]["Other"]) ? $ary_abiUsed["Effect"]["Other"] : "") ) );

	// 	return $ary_abiUsed;
	// }
	
	// $result_inpSent = fun_analyzeSentense($testSentense);
	// print_r($result_inpSent);
	*/
?>