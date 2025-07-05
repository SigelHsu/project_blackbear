<?php
	$ary_setMobilizationList = array();
	$ary_setMobilizationList += array(
		"M01" => array(
			"ID" 		=> "M01", 
			"Title" => array(
				"Basic" => "War Levies",
				"EN" 		=> "warlevies",
				"CH" 		=> "戰爭徵稅",
			),
			"Condition"	=> array(
				"EN" => "You accept the petition if it is supported by a net Favor of 6 or more.",
				"CH" => "財政大臣必須在每次外交期時花費 1 金幣在這張卡片上,以幫助支持軍隊的費用。"
			)
		),
		"M02" => array(
			"ID" 		=> "M02", 
			"Title" => array(
				"Basic" => "Secular Priorities",
				"EN" 		=> "secularpriorities",
				"CH" 		=> "世俗優先",
			),
			"Condition"	=> array(
				"EN" => "You accept the petition if it is supported by a net Favor of 1 or more.",
				"CH" => "增加軍國主義,使得大主教下降 1 層地位(和一張地位卡)。如果這張軍隊動員卡被蓋回去,大主教提升 1 層地位(並抽取一張新的地位卡)。"
			)
		),
		"M03" => array(
			"ID" 		=> "M03", 
			"Title" => array(
				"Basic" => "Nationalism",
				"EN" 		=> "nationalism",
				"CH" 		=> "民族主義",
			),
			"Condition"	=> array(
				"EN" => "You accept the petition no matter how the Council votes.",
				"CH" => "民族主義的自豪感蔓延整個宮廷。為了體現國王日益蔑視他的情況,大使獲得 1 點寵愛度。這張卡被蓋回時,大使失去 1 點寵愛度。"
			)
		),
		"M04" => array(
			"ID" 		=> "M04", 
			"Title" => array(
				"Basic" => "Rumor Mill",
				"EN" 		=> "rumormill",
				"CH" 		=> "流言蜚語",
			),
			"Condition"	=> array(
				"EN" => "If it is possible to rule in a way that reverses the intent of the petition, you do so.",
				"CH" => "許多伯爵聚集在男爵的旗下,幫他收集到了比平常更多的消息:這張卡翻開時,每次的接旨期,他都獲得 3 張陰謀卡。"
			)
		),
		"M05" => array(
			"ID" 		=> "M05", 
			"Title" => array(
				"Basic" => "Almost King!",
				"EN" 		=> "almostking!",
				"CH" 		=> "即將成王！",
				"0" 		=> "即將成王!",
				"0" 		=> "即將成王",
			),
			"Condition"	=> array(
				"EN" => "You accept the petition if it is supported by a net Favor of 18 or more.",
				"CH" => "男爵獲得了許多強大的力量,如果這張卡運作中,男爵每回合會獲得 1層地位(和一張地位卡)。"
			)
		),
	);

	//print_r($ary_setMobilizationList);
?>