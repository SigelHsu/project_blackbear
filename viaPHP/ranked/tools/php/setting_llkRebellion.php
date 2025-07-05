<?php
	$ary_setRebellionList  = array();
	$ary_setRebellionList += array(
		"P01" => array(
			"ID" 		=> "P01", 
			"Title" => array(
				"Basic" => "Tax Revolt",
				"EN" 		=> "taxrevolt",
				"CH" 		=> "抗稅運動",
			),
			"Condition"	=> array(
				"EN" => "The Treasurer must spend 1 gold ducat at the beginning of each Diplomacy phase while this card is in play because of the number of peasants failing to pay their taxes.",
				"CH" => "財政大臣必須在每次外交期花費 1 塊金幣這張卡上,作為農民沒有繳稅的情況。"
			)
		),
		"P02" => array(
			"ID" 		=> "P02", 
			"Title" => array(
				"Basic" => "Protesting, Not Praying",
				"EN" 		=> "protesting,notpraying",
				"CH" 		=> "抗議，而非祈禱",
				"0" 		=> "抗議,而非祈禱",
			),
			"Condition"	=> array(
				"EN" => "The peasants aren’t on the pews, so they’re not making the usual donations. Reduce the Archbishop’s Allowance by 1 as long as this card is in play.",
				"CH" => "農民不在教堂長椅上,因此他們無法正常捐款。這張卡運作時,大主教的津貼減少	1 塊金幣。"
			)
		),
		"P03" => array(
			"ID" 		=> "P03", 
			"Title" => array(
				"Basic" => "Bread Riots",
				"EN" 		=> "breadriots",
				"CH" 		=> "麵包暴動",
			),
			"Condition"	=> array(
				"EN" => "The Queen tells the peasants to eat cake. The Baron’s army threatens them. And the Royal Bastard just laughs at them.</br>The Queen, the Baron, and the Royal Bastard each lose 1 Favor as long as this card is in play. If the card is deactivated, they each gain 1 Favor.",
				"CH" => "皇后要求農民吃蛋糕。男爵的軍隊威脅他們。而王子只是笑著看著他們。</br>這張卡運作時,皇后、男爵和王子各失去 1 點寵愛度。"
			)
		),
		"P04" => array(
			"ID" 		=> "P04", 
			"Title" => array(
				"Basic" => "Palace Boycott",
				"EN" 		=> "palaceboycott",
				"CH" 		=> "抵制宮廷",
			),
			"Condition"	=> array(
				"EN" => "The peasants refuse to make deliveries to the palace. The Steward is so busy trying to obtain supplies that she cannot play Intrigue cards as long as this card is in play.",
				"CH" => "農民拒絕運送物資到宮廷。這張卡運作時,總管大臣忙著張羅物資,使得她無法使用陰謀卡。"
			)
		),
		"P05" => array(
			"ID" 		=> "P05", 
			"Title" => array(
				"Basic" => "Palace Besieged!",
				"EN" 		=> "palacebesieged!",
				"CH" 		=> "包圍宮廷！",
				"0" 		=> "包圍宮廷!",
				"1" 		=> "包圍宮廷",
			),
			"Condition"	=> array(
				"EN" => "The Baron is clearly not doing his job, for the peasants are at the gate. He loses 1 Status (and a Status card) at the start of each turn if this card is in play.",
				"CH" => "男爵很明顯沒在做他的工作,因為農民都到大門外了。這張卡片運作時,每回合開始時,他都會降低 1 層地位 (和一張地位卡)。"
			)
		),
	);

	//print_r($ary_setRebellionList);
?>