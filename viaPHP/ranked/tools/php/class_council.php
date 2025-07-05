<?php
	/*
	// !這部分還有些未完成的部分：
	//	紀錄 Log、印出 Log資訊
	*/
  //會議期: Council
  //會議期前(beforeCouncil: 回合小結、寫入角色Log、抓取資料、排序、自動請願有無)、會議期(Council: 紀錄 Log-會議主題、投票順序、投票狀況、投票結算、決策卡)
	//延遲的請願，大概會整理成: 0 => array("Petitioner" => ROLE_ID, "Petition" => TEXT, "PendingBy" => BY)	//還沒甚麼想法
?>
<?php
	$ary_pendingPetition = array();
	class cls_withCouncil{
		private $p_setLang;
		private $p_setRoleListAry;
		private $p_setStatusListAry;
		private $p_petitionOrderAry;
		private $p_voteOrderAry;
		private $p_orginalAry;
		private $p_rolesAry;
		private $p_returnAry;
		private $p_settingAry;
		private $p_setTurn;
		
		public function __construct ($inputAry = array(), $settingAry = array("Turn" => 0)) {
			global $set;
			$set_lang = $set["Language"];
			$this->p_setLang = $set_lang;
			global $ary_setRoleList;												//print_r($ary_setIntrigueList);
			$this->p_setRoleListAry = $ary_setRoleList;
			global $ary_setStatusList;											//print_r($ary_setStatusList);
			$this->p_setStatusListAry = $ary_setStatusList;
			$this->p_orginalAry = $inputAry;
			$this->p_settingAry = $settingAry;							//echo "settingAry: </br>"; print_r($this->p_settingAry);
			$this->p_setTurn 	= $settingAry["Turn"];
			$this->fun_setInputAry($inputAry);							//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
			$this->fun_beforeCouncil();
		}
		private function fun_setInputAry($inputAry = array()) {
			//$tmp_Ary = array();
			$this->p_rolesAry = $inputAry;
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_rolesAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_rolesAry = $inputAry;
			}
			$this->fun_setReturnAry($this->p_rolesAry);			//$this->fun_setReturnAry($this->p_rolesAry[$outputTag], $outputTag);
		}
		private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_returnAry[$outputTag] = $inputAry;
			}
			else {
				$this->p_returnAry = $inputAry;
			}
		}
		//先收集一些需要的資訊
		private function fun_beforeCouncil() {
			$this->fun_setOrderAry();
		}
		private function fun_setOrderAry($inputAry = array()) {
			$call_clsSortAryBy = new cls_sortAryby;
			$call_clsSortAryBy->fun_arySort($this->p_rolesAry, "Status", "ASC", array("isCountTotal" => 0, "isAddValueTag" => 0));
			$this->p_petitionOrderAry = $call_clsSortAryBy->fun_returnValues();			//echo "p_petitionOrderAry: ";	print_r($this->p_petitionOrderAry); echo "</br>";
		}
		
		//下列這幾個部分，要改成 return array("data" => array, "print" => "文字")，方便自由取用/利用
		public function fun_listOrderForPetition( $Turn = 0, $inputAry = array() ) {
			$returnAry = array();
			if($Turn !== 0) {
				$this->p_setTurn = $Turn;
			}
			if(count($inputAry) !== 0) {
				$this->fun_setInputAry($inputAry);										//print_r($inputAry);
				$this->fun_setReturnAry($inputAry);
				$returnAry["Before"] = $this->fun_beforeAudience();
			}

			$returnAry["AutoPeti"] 	= $this->fun_printOrderForAutoPetition();
			$returnAry["OrdCoun"] 	= $this->fun_printOrderForCouncil();
			$returnAry["OrdVote"] 	= $this->fun_printOrderForVote();

			return $returnAry;
		}
		//會議期時，請願的順序，因為可能包含了自動請願(地牢的請願、延遲的請願)，在這裡做處理
		public function fun_printOrderForAutoPetition( $Turn = 0, $inputAry = array() ) {
			$resultStr = "";
			global $ary_pendingPetition;
			$counter = 1;
			if($Turn !== 0) {
				$this->p_setTurn = $Turn;
			}
			if(count($inputAry) !== 0) {
				$this->fun_setInputAry($inputAry);										//print_r($inputAry);
				$this->fun_setReturnAry($inputAry);
				$this->fun_beforeAudience();
			}
			
			//echo "第 ".$this->p_setTurn."回合-自動請願：</br>";
			foreach($ary_pendingPetition AS $Key => $Values) {
				$Role_ID = $Values["Role_ID"];
				$resultStr .= "第 ".$counter."項：</br>";
				$resultStr .= "請願者：".$this->p_setRoleListAry[$Role_ID]["Title"][$this->p_setLang]."</br>";
				$resultStr .= "請願內容：".$Values["Petition"]."</br>";
				$resultStr .= "</br>";
				$counter++;
			}
			$ary_pendingPetition = array();	//清空

			//檢查是否有在地牢的玩家
			foreach($this->p_rolesAry AS $Key => $Values) {
				if($Values["Role"]["State"] == 9) {
					$Role_ID = $Values["Role"]["Code"];
					$resultStr .= "第 ".$counter."項：</br>";
					$resultStr .= "請願者：".$this->p_setRoleListAry["R00"]["Title"][$this->p_setLang]."</br>";
					$resultStr .= "請願內容：從地牢釋放 ";
					$resultStr .= "".$this->p_setRoleListAry[$Role_ID]["Title"][$this->p_setLang]." ";
					$resultStr .= "(".$Values["Role"]["State"].")</br>";
					$resultStr .= "</br>";
				}
				$counter++;
			}

			return $resultStr;
		}
		//印出會議期時，關於角色請願時的順序，這部分在會議期開始後，基本上不會變動
		//(會議期間，角色的地位可能有所變動，加個按鈕，方便視情況看要不要重新排序)
		public function fun_printOrderForCouncil( $Turn = 0, $inputAry = array() ) {
			global $setting_Color;
			$resultStr = "";
			if($Turn !== 0) {
				$this->p_setTurn = $Turn;
			}
			if(count($inputAry) !== 0) {
				$this->fun_setInputAry($inputAry);										//print_r($inputAry);
				$this->fun_setReturnAry($inputAry);
				$this->fun_beforeAudience();
			}
			//print_r($this->p_AllotAry);
			$cls_callAllow = new cls_withAllowance($this->p_orginalAry); 
			//echo "第 ".$this->p_setTurn."回合-請願順序：</br>";
			//echo "稅率：".$cls_callAllow->fun_sumTaxRatex()."</br></br>";
			foreach($this->p_petitionOrderAry AS $Key => $Values) {
				$Role_ID = $Values["Role"]["Code"];
				$tmpColor = ( isset($this->p_orginalAry[$Role_ID]["Color"]) && ($this->p_orginalAry[$Role_ID]["Color"] != "") ) ? 
										($setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Color"]) : ("rgb(90 20 239)");
				$tmpColorT = $setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Title"][$this->p_setLang];
				$tmpStyle = "border-left: ".$tmpColor." solid";
				$resultStr .= "<div style = '".$tmpStyle."' data-toggle = \"tooltip\" data-placement = \"top\" title = \"".$tmpColorT."\">";
				$resultStr .= 	"角色：".$this->p_setRoleListAry[$Role_ID]["Title"][$this->p_setLang]." ";
				$resultStr .= 	"(狀態：".$Values["Role"]["State"].")</br>";
				$resultStr .=	 "寵愛度：".$Values["Favor"]["Basic"]."</br>";
				$resultStr .= 	"津貼：".$cls_callAllow->fun_RolesTotalAllowance( array("ID" => $Role_ID) )."</br>";
				$resultStr .=	 "地位卡：".count($Values["Status"])."張</br>";
				foreach($Values["Status"] AS $Key2 => $Status_ID) {
					$resultStr .= "　".$this->p_setStatusListAry[$Status_ID]["Title"][$this->p_setLang]."</br>";
				}
				$resultStr .= "</div>";
				$resultStr .= "</br>";
			}

			return $resultStr;
		}
		//印出會議期時，關於角色投票時的順序，雖然基本上應該與請願時的順序相同，但因可能隨時變化，因此另外獨立出來
		public function fun_printOrderForVote( $Turn = 0, $inputAry = array() ) {
			global $setting_Color;
			$resultStr = "";
			if($Turn !== 0) {
				$this->p_setTurn = $Turn;
			}
			if(count($inputAry) !== 0) {
				$this->fun_setInputAry($inputAry);										//print_r($inputAry);
				$this->fun_setReturnAry($inputAry);
				$this->fun_beforeAudience();
			}
			//print_r($this->p_AllotAry);
			//echo "第 ".$this->p_setTurn."回合-投票順序：</br>";
			foreach($this->p_petitionOrderAry AS $Key => $Values) {
				$Role_ID = $Values["Role"]["Code"];
				$tmpColor = ( isset($this->p_orginalAry[$Role_ID]["Color"]) && ($this->p_orginalAry[$Role_ID]["Color"] != "") ) ? 
										($setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Color"]) : ("rgb(90 20 239)");
				$tmpColorT = $setting_Color[$this->p_orginalAry[$Role_ID]["Color"]]["Title"][$this->p_setLang];
				$tmpStyle = "border-left: ".$tmpColor." solid";
				$resultStr .= "<div style = '".$tmpStyle."' data-toggle = \"tooltip\" data-placement = \"top\" title = \"".$tmpColorT."\">";
				$resultStr .= 	"角色：".$this->p_setRoleListAry[$Role_ID]["Title"][$this->p_setLang]." ";
				$resultStr .= 	"(狀態：".$Values["Role"]["State"].")</br>";
				$resultStr .= 	"寵愛度：".$Values["Favor"]["Basic"]."</br>";
				$resultStr .= 	"地位卡：".count($Values["Status"])."張</br>";
				$resultStr .= "</div>";
				$resultStr .= "</br>";
			}

			return $resultStr;
		}

		//分析使用的能力檢查字串，如果具有 "請願"，則進入紀錄請願環節
		/*
		//請願環節分為(照順序): 1.請願內容: {角色} 藉由 {陰謀/地位/能力}:{能力名稱} > 進行 請願:{敘述}(Log紀錄)、
		//										2.使用卡牌: {角色} 使用 {陰謀/地位/能力}:{能力名稱} > 效果:{效果字串}(包含了 "效果" 文字，表示為條件滿足後觸發，於步驟6時再次觸發(Log紀錄)
		//															 {角色} 使用 {陰謀/地位/能力}:{能力名稱}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱/持續}(通常為影響投票結果，但有例外:如保留請願/封印請願的)(效果觸發)
		//										3.投票紀錄: {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)(Log紀錄)、
		//										4.票數計算: !先判斷是否為國王主持，根據投票紀錄(和能力效果)，計算淨寵愛度(Log紀錄)、
		//										5.決策結果: {決策卡/攝政王}: {通過/不通過}(PS.主教的異端指控需要紀錄兩張)(Log紀錄)、
		//										6.實際效果結算: 結論 > {通過/否決/保留}
		//																	 {角色} 使用 能力:請願，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} 
		//																	 {角色} 使用 {陰謀/地位/能力:{能力名稱}}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} (效果觸發 & Log紀錄)
		//										PS. 用一個結案按鈕，表示此次請願完結，此時處理結論的文字串，若有"保留"請願，需要加入到 ary_pendingPetition裡面；封印(金錢/卡牌/請願)或地牢的部分，則另外修改角色狀態
		*/
		public function fun_useAbilityInCouncil($inputSent = "", $petiStep = 0) {
			//echo "fun_useAbilityInCouncil ".$inputSent."</br>";																										//print_r($this->p_orginalAry); echo "</br></br>";
			$ary_anazData = array();		//之後要想辦法讓這個先從 Log讀取，或傳值進來
			$cls_anazSent = new cls_withAnalyze;
			switch ($petiStep) {
				default:
				case 0:		//S.新的請願，前台應該會刷新，這邊紀錄說是新的就好...吧，理論上也會直接跳到步驟 1之中。
					break;
				
				case 1:		//1.請願內容 Petition
					$ary_anazData = $cls_anazSent->fun_analyzeSentenseForCouncil($inputSent, $petiStep);
					break;
					
				case 2:		//2.使用卡牌 Cards
					if( preg_match("/效果|Effect|effect|Eff|eff/", $inputSent) ) {
						$ary_anazData = $cls_anazSent->fun_analyzeSentenseForCouncil($inputSent, $petiStep);
					}
					else {
						$ary_anazData = $cls_anazSent->fun_analyzeSentenseForGeneral($inputSent);
						$result = $cls_anazSent->fun_activeEffective($inputSent, $ary_anazData, $this->p_rolesAry);
						$this->fun_updateInputAry($result);
						$this->fun_setReturnAry($result);
					}
					break;
					
				case 3:		//3.投票紀錄 Vote
					$ary_anazData = array_merge_recursive( $ary_anazData, $cls_anazSent->fun_analyzeSentenseForCouncil($inputSent, $petiStep) );
					break;
				
				case 4:		//4.票數計算 Calculat
					$ary_anazData["Step4"] = $this->fun_calculatePetiVote($inputSent);
					break;
				
				case 5:		//5.決策結果 Decision
					$ary_anazData = $cls_anazSent->fun_analyzeSentenseForCouncil($inputSent, $petiStep);
					break;

				case 6:		//6.效果結算 Conclusion
					$ary_anazData = $cls_anazSent->fun_analyzeSentenseForCouncil($inputSent, $petiStep);
					if($ary_anazData["Step6"]["Conclusion"]["ID"] !== 9) {
						foreach($ary_anazData["Step6"]["ConEffect"] AS $Key => $Values) {
							$result = $cls_anazSent->fun_activeEffective($inputSent, $Values, $this->p_rolesAry);
							$this->fun_updateInputAry($result);																															//$this->fun_setReturnAry($result);
						}
					}
					else {
						global $ary_pendingPetition;
						array_push($ary_pendingPetition, $ary_anazData);
					}
					//結算完成後，需清空 Favor的 Temp中，Type為 2的資料(一次)
					$tempAry_Roles = $this->p_rolesAry;
					$call_clsFavor = new cls_withFavor;
					foreach($tempAry_Roles AS $Key => $Values) {
						$Values["Favor"] = $call_clsFavor->fun_delFavorByType($Values["Favor"], 2);
						$this->fun_updateInputAry($Values, $Key);
					}
					break;

				case 7:		//E.請願結束，準備處理下一筆；步驟6結束後，需要直接進入此環節，處理完相應步驟(雖然目前應該沒有)，然後繼續回到步驟 S。
					break;
			}																																																				//print_r($ary_anazData); echo "</br></br>"; print_r($this->p_rolesAry); //exit();
			
			//寫入 Log
			//將資料寫入到 Log時，應該會有幾個要注意的 文字跟部份紀錄直接推到最後，然後 $ary_anazData跟 role的資料，需要額外留一份取代用的，方便隨時拿出來使用/修改
			{
				//這幾筆要個別寫入 Log
				//$inputSent; 	$ary_anazData;				$this->p_rolesAry;
				//$inputSent跟 $this->fun_returnValues() 分別寫入 Log以及 登記到總表中
				//這部分因為還沒有寫 Log部分的程式，晚點再研究...
			}

			return $ary_anazData;
		}

		//4.票數計算: !先判斷是否為國王主持，根據投票紀錄(和能力效果)，計算淨寵愛度(Log紀錄)、
		public function fun_calculatePetiVote($inputAry = array() ) {
			global $set;			//決策者
			$returnAry = array(
				"Pure" => 0,
				"Yes"	 => 0,
				"No"	 => 0
			);

			$call_clsFavor = new cls_withFavor($this->p_rolesAry);
			foreach ($inputAry["Step3"]["Data"]["Votes"] AS $Key => $Values) {
				$RoleTolFavor = 0;
				if( isset($this->p_rolesAry[$Values["ID"]]["Favor"]) ) {
					$RoleTolFavor = ($set["DecicionBy"] == 1) ? ( $call_clsFavor->fun_sumRolesFavor($this->p_rolesAry[$Values["ID"]]["Favor"]) ) : (1);
				}
				if($Values["ID"] == "R07") {
					$returnAry["Pure"] += ( (-$Values["VoteID"]) * $RoleTolFavor );
					$returnAry[($Values["VoteID"] !== 1) ? ("VoteYes") : ("VoteNo")] += 1;
					$returnAry[($Values["VoteID"] !== 1) ? ("ForYes") : ("ForNo")] += (-$Values["VoteID"]) * $RoleTolFavor;
				}
				else {
					$returnAry["Pure"] += ( $Values["VoteID"] * $RoleTolFavor );
					$returnAry[($Values["VoteID"] == 1) ? ("VoteYes") : ("VoteNo")] += 1;
					$returnAry[($Values["VoteID"] == 1) ? ("ForYes") : ("ForNo")] += $Values["VoteID"] * $RoleTolFavor;
				}
				$returnAry["Data"][$Key] 						= $Values;
				$returnAry["Data"][$Key]["VoteVal"] = $RoleTolFavor;
			}

			return $returnAry;
		
			//此處會返回這個陣列
			/*
			$testSentense = array(
				"Step4" => Array (
					"Pure" 	=> 22,
					"Yes" 	=> 29,
					"No" 		=> -7,
					"Data" => Array (
						"Votes" => Array (
							0 => Array (
								"ID" 			=> "R02",
								"Name" 		=> "皇后",
								"RoleExt" => "主教假扮",
								"Vote" 		=> "反對",
								"VoteID" 	=> -1,
								"VoteExt" => "也不知道有什麼額外資訊需要",
								"VoteVal" => 7
							),
							1 => Array (
								"ID" 			=> "R04",
								"Name" 		=> "主教",
								"RoleExt" => "",
								"Vote" 		=> "贊成",
								"VoteID" 	=> 1,
								"VoteExt" => "",
								"VoteVal" => 9
							),
							2 => Array (
								"ID" 			=> "R01",
								"Name" 		=> "王子",
								"RoleExt" => "",
								"Vote" 		=> "贊成",
								"VoteID" 	=> 1,
								"VoteExt" => "",
								"VoteVal" => 13
							),
							3 => Array (
								"ID" 			=> "R07",
								"Name" 		=> "大使",
								"RoleExt" => "",
								"Vote" 		=> "反對",
								"VoteID" 	=> -1,
								"VoteExt" => "",
								"VoteVal" => 7
							),
						)
					)
				),
			);	
			*/
		}

		//5.決策結果: {決策卡/攝政王}: {通過/不通過}(PS.主教的異端指控需要紀錄兩張)(Log紀錄)、
		public function fun_resultOfPeti($inputAry = array() ) {
			global $set;			//決策者
			$returnAry = array(
				"Result" 		=> 0,
				"Decision"	=> array(),
				"PureVotes"	=> 0
			);

			$call_clsFavor = new cls_withFavor($this->p_rolesAry);
			foreach ($inputAry["Step3"]["Data"]["Votes"] AS $Key => $Values) {
				$RoleTolFavor = 0;
				if( isset($this->p_rolesAry[$Values["ID"]]["Favor"]) ) {
					$RoleTolFavor = ($set["DecicionBy"] == 1) ? ( $call_clsFavor->fun_sumRolesFavor($this->p_rolesAry[$Values["ID"]]["Favor"]) ) : (1);
				}
				if($Values["ID"] == "R07") {
					$returnAry["Pure"] += ( (-$Values["VoteID"]) * $RoleTolFavor );
					$returnAry[($Values["VoteID"] !== 1) ? ("Yes") : ("No")] += (-$Values["VoteID"]) * $RoleTolFavor;
				}
				else {
					$returnAry["Pure"] += ( $Values["VoteID"] * $RoleTolFavor );
					$returnAry[($Values["VoteID"] == 1) ? ("Yes") : ("No")] += $Values["VoteID"] * $RoleTolFavor;
				}
				$returnAry["Data"][$Key] 						= $Values;
				$returnAry["Data"][$Key]["VoteVal"] = $RoleTolFavor;
			}

			return $returnAry;
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
  //$cls_withCou = new cls_withCouncil($ary_roleList, array("Turn" => 3));
	//$cls_withCou->fun_listOrderForPetition();
	//1.請願內容: {角色} 藉由 {陰謀/地位/能力}:{能力名稱} > 進行 請願:{敘述}(Log紀錄)
	//$testSentense = "皇后 藉由 能力:請願 > 進行 請願:{為了購買蛋糕，申請5枚金幣。}";	$petitionStep = 1;

	//2.使用卡牌: {角色} 使用 {陰謀/地位/能力}:{能力名稱} > 效果:{效果字串}(包含了 "效果" 文字，表示為條件滿足後觸發，於步驟6時再次觸發(Log紀錄)
	//					 {角色} 使用 {陰謀/地位/能力}:{能力名稱}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱/持續}(通常為影響投票結果，但有例外:如保留請願/封印請願的)(效果觸發)
	//$testSentense = "主教 使用 陰謀卡:banana > 效果:{對於贊成的玩家，永久增加1點寵愛度。}";	$petitionStep = 2;						//此處只會紀錄會發生什麼事
	//$testSentense = "大使 藉由 陰謀卡:conana，皇后 寵愛度 增加 2:本次";	$petitionStep = 2;															//此處會實際影響資料的範例
	//$testSentense = "大使 藉由 陰謀卡:水餃，皇后 寵愛度 增加 4:一回";	$petitionStep = 2;
	//$testSentense = "大使 藉由 陰謀卡:大象，皇后 寵愛度 增加 1:永久";	$petitionStep = 2;

	//3.投票紀錄: {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)(Log紀錄)、
	//					 {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述), {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)， {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)
	//$testSentense = "大使:贊成";	$petitionStep = 3;
	//$testSentense = "皇后:反對";	$petitionStep = 3;
	//$testSentense = "皇后(主教假扮):反對(也不知道有什麼額外資訊需要)";	$petitionStep = 3;
	//$testSentense = "主教(王子假扮):贊成(也不知道有什麼額外資訊需要)";	$petitionStep = 3;
	//$testSentense = "皇后(主教假扮):反對(也不知道有什麼額外資訊需要), 主教:贊成, 王子:贊成，大使:反對";	$petitionStep = 3; //<--以這個形式為主

	//4.票數計算: !先判斷是否為國王主持，根據投票紀錄(和能力效果)，計算淨寵愛度(Log紀錄)、
	// $testSentense = array(
	// 	"Step3" => Array (
	// 		"Basic" => Array (
	// 			"Roles" => Array (
	// 				0 => Array (
	// 					"ID" 			=> "R02",
	// 					"Name" 		=> "皇后",
	// 					"RoleExt" => "主教假扮",
	// 					"Vote" 		=> "反對",
	// 					"VoteID" 	=> -1,
	// 					"VoteExt" => "也不知道有什麼額外資訊需要"
	// 				),
	// 				1 => Array (
	// 					"ID" 			=> "R04",
	// 					"Name" 		=> "主教",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "贊成",
	// 					"VoteID" 	=> 1,
	// 					"VoteExt" => ""
	// 				),
	// 				2 => Array (
	// 					"ID" 			=> "R01",
	// 					"Name" 		=> "王子",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "贊成",
	// 					"VoteID" 	=> 1,
	// 					"VoteExt" => ""
	// 				),
	// 				3 => Array (
	// 					"ID" 			=> "R07",
	// 					"Name" 		=> "大使",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "反對",
	// 					"VoteID" 	=> -1,
	// 					"VoteExt" => ""
	// 				),
	// 			),
	// 			"Log" 	=> Array (
	// 				0 => Array (
	// 					0 => "皇后(主教假扮)",
	// 					1 => "反對(也不知道有什麼額外資訊需要)"
	// 				),
	// 				1 => Array (
	// 					0 => "主教",
	// 					1 => "贊成"
	// 				),
	// 				2 => Array (
	// 					0 => "王子",
	// 					1 => "贊成"
	// 				),
	// 				3 => Array (
	// 					0 => "大使",
	// 					1 => "反對"
	// 				),
	// 			)
	// 		),
	// 		"Data" => Array (
	// 			"Votes" => Array (
	// 				0 => Array (
	// 					"ID" 			=> "R02",
	// 					"Name" 		=> "皇后",
	// 					"RoleExt" => "主教假扮",
	// 					"Vote" 		=> "反對",
	// 					"VoteID" 	=> -1,
	// 					"VoteExt" => "也不知道有什麼額外資訊需要"
	// 				),
	// 				1 => Array (
	// 					"ID" 			=> "R04",
	// 					"Name" 		=> "主教",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "贊成",
	// 					"VoteID" 	=> 1,
	// 					"VoteExt" => ""
	// 				),
	// 				2 => Array (
	// 					"ID" 			=> "R01",
	// 					"Name" 		=> "王子",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "贊成",
	// 					"VoteID" 	=> 1,
	// 					"VoteExt" => ""
	// 				),
	// 				3 => Array (
	// 					"ID" 			=> "R07",
	// 					"Name" 		=> "大使",
	// 					"RoleExt" => "",
	// 					"Vote" 		=> "反對",
	// 					"VoteID" 	=> -1,
	// 					"VoteExt" => ""
	// 				),
	// 			)
	// 		)
	// 	),
	// );	$petitionStep = 4;

	//5.決策結果: {決策卡/攝政王}: {通過/不通過}(PS.主教的異端指控需要紀錄兩張)(Log紀錄)、
	//$testSentense = "決策卡:當我死了再說，勉強同意";	$petitionStep = 5;

	
	//6.實際效果結算: 結論 > {通過/否決/保留} -> 先判斷是否保留，是的話，整個內容要複製到 pending裡面
	//							{角色} 使用 能力:請願，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} 
  //							{角色} 使用 {陰謀/地位/能力:{能力名稱}}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} (效果觸發 & Log紀錄)
	//$testSentense = "結論 > 通過；
	//								 財政 使用 能力:請願，財政 稅金 上升 5；
	//								 主教 使用 陰謀卡:apple，皇后 地位 下降 1:吟遊詩人，王子 地位 下降 1:獄卒，大使 地位 上升 1: 吟遊詩人；
	//								 王子 使用 陰謀卡:banana，男爵 寵愛度 下降 2；
	//								 大使 使用 陰謀卡:conana，大使 金錢 上升 5";	$petitionStep = 6;
	//print_r($cls_withCou->fun_useAbilityInCouncil($testSentense, $petitionStep));
  */
?>