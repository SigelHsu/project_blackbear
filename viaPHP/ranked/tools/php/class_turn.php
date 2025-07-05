<?php
	//回合處理(回合開始前(beforeTurnStart: 抓取相關資料)、回合開始(TurnStart: 健康卡、軍隊卡、人民卡效果)、
	//回合結束前(beforeTurnEnd: 整理相關資料)、回合結束(TurnEnd: 軍隊卡、人民卡效果、寫入Log，並且需要將pending的資料整理出來(陰謀卡、請願))

	//待處理：回合開始 & 回合結束 
	//$set_phases: 0:	//回合開始；1:	//接旨期 Audience；2:	//外交期 Diplomacy；3:	//會議期 Council；4:	//回合結束

	class cls_withTurn {
		private $p_setLang;
		// private $p_setRound;
		private $p_setTurn;
		private $p_orginalAry;
		private $p_returnAry;
		
		public function __construct ($inputAry = array(), $settingAry = array()) {
			global $set;
			$set_lang = $set["Language"];
			$this->p_setLang = $set_lang;
			// global $set_round;		// $this->p_setRound = $set_round;
			global $set_turn;

			$this->fun_setInputAry($inputAry, $settingAry);						//print_r($inputAry);
			$this->fun_setReturnAry($inputAry);
		}

		private function fun_setInputAry($inputAry = array(), $settingAry = array()) {
			if( count($inputAry) != 0 ) {
				$this->p_orginalAry = $inputAry;
			}

			// if( isset($settingAry["Round"]) ) {
			// 	$this->p_setRound = $settingAry["Round"];
			// }
			if( isset($settingAry["Turn"]) ) {
				$this->p_setTurn = $settingAry["Turn"];
			}
		}
		private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
			if(!empty($outputTag)) {
				$this->p_orginalAry[$outputTag] = $inputAry;
        $this->fun_setReturnAry($this->p_orginalAry[$outputTag], $outputTag);
			}
			else {
				$this->p_orginalAry = $inputAry;
        $this->fun_setReturnAry($this->p_orginalAry);
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

		public function fun_withPhases ($set_phases = "", $inputSentense = "", $settingAry = array()) {
			$rtnAry = array();
			global $set;
			
			$cls_withLog = new cls_withLog;				//為讀寫 Log而做準備
			//先從 Log裡面讀取檔案
			{

			}
			switch($set_phases) {
				default:
					break;

				 case "0":	//回合開始
					//登記 & 結算健康卡、軍隊卡、人民卡牌的效果。
					//列出待處理事項，並把原本的 $pending清空(要寫到另一隻 Log裡面，方便記錄當輪次是哪些待處理)
					
					// //從 Log檔案庫裡面，取得角色資料(就可以直接把 construct那邊的取消)
					// $fileLoc = "./GameLog/".$set["GameID"]."/"."Turn".$this->p_setTurn."";
					// $rtnAry["RoleResult"] = $cls_withLog->fun_readFromLog($fileLoc, "Log_Roles");
					// if($rtnAry["RoleResult"] === "") {
					// 	$rtnAry["RoleResult"] = $this->p_orginalAry;
					// }
					// $this->fun_updateInputAry($rtnAry["RoleResult"]);
					
					//先暫時這樣，之後有時間再弄個 withBeginning
					// $cls_withAud = new cls_withAudience($this->p_orginalAry);
					// $rtnAry["OrderAudi"] 	= $cls_withAud->fun_printOrderForAudience($this->p_setTurn);	//將資訊直接印製出來
					// $rtnAry["RoleResult"] = $cls_withAud->fun_returnValues();
					// break;
					//這邊可能就會變成 國王 使用 軍隊卡:____，{角色} 寵愛度 減少 1

				 case "1":	//接旨期 Audience
					//展示本回合中，每個角色應該領收的陰謀卡&津貼數量
					//並且登記部分資訊(詢問寵愛度/卡牌效果，或者使用卡牌效果
					//接旨期這邊使用卡牌時，不會實際修改效果，需要檢查(先借用了外交期的部分，目前觀測上是沒有影響)
			
					$cls_withAud = new cls_withAudience($this->p_orginalAry);
					$rtnAry["OrderAudi"] 	= $cls_withAud->fun_printOrderForAudience($this->p_setTurn);	//將資訊直接印製出來
					$rtnAry["RoleResult"] = $cls_withAud->fun_returnValues();
					//遇到有使用的話，可能還是需要處理
					if( preg_match("/使用|Used|used|Use|use/", $inputSentense) ) {
						$cls_withDep = new cls_withDiplomacy($this->p_orginalAry, array("Turn" => $this->p_setTurn));
						$cls_withDep->fun_useAbilityInDiplomacy($inputSentense);
						$rtnAry["UseAbility"] = $inputSentense;
						$rtnAry["RoleResult"] = $cls_withDep->fun_returnValues();
					}
					break;

				 case "2":	//外交期 Diplomacy
					//晉見國王的時間、登記在國王面前使用卡牌
					$cls_withDep = new cls_withDiplomacy($this->p_orginalAry, array("Turn" => $this->p_setTurn));
					$cls_withDep->fun_useAbilityInDiplomacy($inputSentense);
					$rtnAry["UseAbility"] = $inputSentense;
					$rtnAry["RoleResult"] = $cls_withDep->fun_returnValues();
					break;

				 case "3":	//會議期 Council
					//只有這裡才會用到 settingAry的內容，因為需要知道請願開始~結束，才知道甚麼時候該結算
					//列出角色順序
					//接受請願 & 計算寵愛 & 處理效果
					$cls_withCou = new cls_withCouncil($this->p_orginalAry, array("Turn" => $this->p_setTurn));
					$rtnAry["OrderCoun"] 	= $cls_withCou->fun_listOrderForPetition();
					$rtnAry["UseSenten"] 	= $inputSentense;
					$rtnAry["WithPetit"] 	= $cls_withCou->fun_useAbilityInCouncil($inputSentense, $settingAry["PetiStep"]);
					$rtnAry["RoleResult"] = $cls_withCou->fun_returnValues();
					break;

				 case "4":	//回合結束
					//將最終結果登記本回合結束 & 下一回合的開始
					//有些效果可能在此時結算(軍隊/人民)
					$cls_withAud = new cls_withAudience($this->p_orginalAry);
					$cls_withAud->fun_updateAllot();														//放在回合結束時處理，還有設定 Tax的部分(有點忘了為什麼要有這個)
										
					//將回合的記錄存檔，然後將角色資料存放到這回合以及下回合
					$rtnAry["RoleResult"] = $this->p_orginalAry;
					$fileLoc = "./GameLog/".$set["GameID"]."/"."Turn".$this->p_setTurn."";
					//$cls_withLog->fun_writeIntoLog($fileLoc, "Roles", $rtnAry["RoleResult"]);
					break;

				case "R": 					//讀取角色順序
					$cls_withAud = new cls_withAudience($this->p_orginalAry);
					$rtnAry["OrderAudi"] = $cls_withAud->fun_printOrderForAudience($this->p_setTurn);
					$cls_withCou = new cls_withCouncil($this->p_orginalAry, array("Turn" => $this->p_setTurn));
					$rtnAry["OrderCoun"] = $cls_withCou->fun_listOrderForPetition();
					break;
			}
			return $rtnAry;
		}

		// //返回陣列
		// public function fun_returnValues() {
		// 	return $this->p_returnAry;
		// }
	}
?>

<?php
	// 範例
	// $thisTurn = 2;
	// $thisPhases = 1;		//接旨期 Audience

	// $cls_withTurn = new cls_withTurn( $ary_roleList, array("Turn" => $thisTurn) );
	// $rtnAry = $cls_withTurn->fun_withPhases($thisPhases);	//將資訊直接印製出來
	// echo "rtnAry: ";
	// print_r($rtnAry);

	// echo "</hr>";
	// $thisTurn = 3;	
	// $thisPhases = 2;	//外交期 Diplomacy
	
	// $testSentense = "財政 使用 能力:賄賂，總務 地位 下降 1:私人保鑣，財政 地位 增加 1:私人保鑣，財政 金錢 減少 5";
	// $testSentense = "皇后 使用 陰謀卡:蘋果(2回合後)，皇后 陰謀卡 增加 3";
	// $testSentense = "皇后 使用 陰謀卡:蘋果(完成)，皇后 津貼 增加 4";
	// $testSentense = "大使 使用 地位卡:吟遊詩人，大使 金錢 增加 8";

	// $cls_withTurn = new cls_withTurn( $ary_roleList, array("Turn" => $thisTurn) );
	// $rtnAry = $cls_withTurn->fun_withPhases($thisPhases, $testSentense);
	// echo "rtnAry: ";
	// print_r($rtnAry);

	// echo "</hr>";
	// $thisTurn = 4;	
	// $thisPhases = 3;		//會議期 Council

	// $testSentense = "皇后 藉由 能力:請願 > 進行 請願:{為了購買蛋糕，申請5枚金幣。}";					$petitionStep = 1;
	// $testSentense = "主教 使用 陰謀卡:banana > 效果:{對於贊成的玩家，永久增加1點寵愛度。}";	$petitionStep = 2;							//此處只會紀錄會發生什麼事
	// $testSentense = "大使 藉由 陰謀卡:conana，皇后 寵愛度 增加 2:本次";			$petitionStep = 2;														//此處會實際影響資料的範例
	// $testSentense = "大使 藉由 陰謀卡:水餃，皇后 寵愛度 增加 4:一回";				$petitionStep = 2;
	// $testSentense = "大使 藉由 陰謀卡:大象，皇后 寵愛度 增加 1:永久";				$petitionStep = 2;
	// $testSentense = "皇后(主教假扮):反對(也不知道有什麼額外資訊需要), 主教:贊成, 王子:贊成，大使:反對";	$petitionStep = 3; 		//<--以這個形式為主
	// $testSentense = "決策卡:當我死了再說，勉強同意";													$petitionStep = 5;
	// $testSentense = "結論 > 通過；
	// 								 財政 使用 能力:請願，財政 稅金 上升 5；
	// 								 主教 使用 陰謀卡:apple，皇后 地位 下降 1:吟遊詩人，王子 地位 下降 1:獄卒，大使 地位 上升 1: 吟遊詩人；
	// 								 王子 使用 陰謀卡:banana，男爵 寵愛度 下降 2；
	// 								 大使 使用 陰謀卡:conana，大使 金錢 上升 5";	$petitionStep = 6;

	// $cls_withTurn = new cls_withTurn( $ary_roleList, array("Turn" => $thisTurn) );
	// $rtnAry = $cls_withTurn->fun_withPhases($thisPhases, $testSentense, array("PetiStep" => $petitionStep));
	// echo "rtnAry: ";
	// print_r($rtnAry);
?>