<?php
  //放一些有關於 LLK的基本設定
  $set["Language"]    = "CH";
  // $set["DecicionBy"]  = 1;   //$set["DecicionBy"]: 1.國王 2.攝政王/繼承人/投票制，預設為1.國王，之後會根據健康卡(或特定卡牌/能力)調整
  // $set["TaxType"]     = 2;		//$set["TaxType"]: 1.累進制 2.調整制，遊戲開始時就決定好

  // $set["DateOfPlay"]  = "2024/01/03 20:30:00";
  // $set["GameID"]      = "LLK00003";
	// https://richarlin.tw/blog/php-time-date-timezone/
	// https://www.php.net/manual/zh/function.strtotime.php
	//echo "date_play: ".date("Ymd", strtotime($str_dateOfPlay));
	// $set["HealthLv"] 	= 0;		//健康卡
	// $set["MobiliLv"] 	= 0;		//軍隊卡
	// $set["RevellLv"] 	= 0;		//人民卡
	//$set_fileLoc 		= "./GameLog/20240102/Setting";
	//$set_fileTitle 	= "Roles";

  $setting_Phase    = array(0 => "回合開始 Start", 1 => "接旨期 Audience", "2" => "外交期 Diplomacy", "3" => "會議期 Council", "4" => "回合結束 End");
  $setting_State    = array(0 => "未使用", 1 => "參與中", "9" => "地牢中");
  $setting_TaxType  = array(0 => "未制定", 1 => "累進制", "2" => "調整制");
  $setting_TempType = array(0 => "未制定", 1 => "一次性", "2" => "一回合", "-1" => "永久制");
  $setting_Color    = array(
                        "C99" => array(
                          "Title" => array(
                            "EN" => "Gold",
                            "CH" => "金色",
                          ),
                          "Color" => "rgb(255 165 0)",
                        ), 
                        "C01" => array(
                          "Title" => array(
                            "EN" => "Blue",
                            "CH" => "藍色",
                          ),
                          "Color" => "rgb(0 0 255)",
                        ),
                        "C02" => array(
                          "Title" => array(
                            "EN" => "Red",
                            "CH" => "紅色",
                          ),
                          "Color" => "rgb(255 0 0)",
                        ),
                        "C03" => array(
                          "Title" => array(
                            "EN" => "Gray",
                            "CH" => "灰色",
                          ),
                          "Color" => "rgb(100 100 100)",
                        ),
                        "C04" => array(
                          "Title" => array(
                            "EN" => "Green",
                            "CH" => "綠色",
                          ),
                          "Color" => "rgb(60 179 133)",
                        ),
                        "C05" => array(
                          "Title" => array(
                            "EN" => "Black",
                            "CH" => "黑色",
                          ),
                          "Color" => "rgb(0 0 0)",
                        ),
                        "C06" => array(
                          "Title" => array(
                            "EN" => "Brown",
                            "CH" => "咖色",
                          ),
                          "Color" => "rgb(121 85 72)",
                        ),
                        "C07" => array(
                          "Title" => array(
                            "EN" => "White",
                            "CH" => "白色",
                          ),
                          "Color" => "rgb(255 255 255)",
                        ),
                      );

  $setting_SentenseSimple = array(
                            1 => array(
                              0 => "皇后 晉見，詢問 寵愛度",
                              1 => "主教 晉見，詢問 陰謀卡:傳染歡笑 的效果",
                              2 => "大使 使用 地位卡:吟遊詩人，大使 寵愛度 +3 "
                            ),
                            2 => array(
                              0 => "王子 使用 地位卡:鐵匠，王子 金錢 +2",
                              1 => "皇后 使用 陰謀卡:爭寵奪愛，皇后 寵愛度 增加 4",
                              2 => "總管 使用 能力:賄賂，主教 地位 -1:御廚，總管 地位+1:御廚，總管 金錢 -5"
                            ),
                            3 => array(
                              0 => array(
                                1 => "王子 藉由 能力:調派 > 進行 請願：降低主教1點地位，提升皇后1點地位",
                                2 => "{角色} 使用 {陰謀/地位/能力}:{能力名稱} > 效果:{效果字串}(包含了 效果 文字，表示為條件滿足後觸發，於步驟6時再次觸發(Log紀錄)</br>
                                      {角色} 使用 {陰謀/地位/能力}:{能力名稱}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱/持續}(通常為影響投票結果，但有例外:如保留請願/封印請願的)(效果觸發)</br>
                                      ex: 大使 藉由 陰謀卡:conana，皇后 寵愛度 增加 2:本次</br>
                                      ex: 大使 藉由 陰謀卡:水餃，皇后 寵愛度 增加 4:一回</br>
                                      ex: 大使 藉由 陰謀卡:大象，皇后 寵愛度 增加 1:永久",
                                3 => "投票紀錄: {角色}(由{角色}假扮):{贊成(yes)/反對(no)}(額外描述)(Log紀錄); </br>
                                      ex: 皇后(主教假扮):反對(也不知道有什麼額外資訊需要), 主教:贊成, 王子:贊成，大使:反對",
                                4 => "票數計算: !先判斷是否為國王主持，根據投票紀錄(和能力效果)，計算淨寵愛度(Log紀錄)",
                                5 => "決策結果: {決策卡/攝政王}: {通過/不通過}(PS.主教的異端指控需要紀錄兩張)(Log紀錄)",
                                6 => "實際效果結算: 結論 > {通過/否決/保留}</br>
                                      {角色} 使用 能力:請願，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} </br>
                                      {角色} 使用 {陰謀/地位/能力:{能力名稱}}，{效果對象} {效果目標} {上升/下降} {數量:地位名稱} (效果觸發 & Log紀錄)</br>"
                              )
                            )
                          );
?>