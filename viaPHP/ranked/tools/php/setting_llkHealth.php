<?php
	$ary_setHealthList  = array();
	$ary_setHealthList += array(
		"H01" => array(
			"ID" 		=> "H01", 
			"Title" => array(
				"Basic" => "Deathbed",
				"EN" 		=> "deathbed",
				"CH" 		=> "臨終之時",
			),
			"Result"	=> array(
				"EN" => "The king is ill this turn, although he may still direct the game out-of-character (unless he has an assistant who can do this for him).",
				"CH" => "本回合中,國王病了;雖然他仍可以作為非遊戲角色直接影響(除非有助手可以幫他做這些事)。"
			)
		),
		"H02" => array(
			"ID" 		=> "H02", 
			"Title" => array(
				"Basic" => "Dozing Off",
				"EN" 		=> "dozingoff",
				"CH" 		=> "打瞌睡",
			),
			"Result"	=> array(
				"EN" => "The King is well, but sleepy. When it is time for King’s decision on the current petition, flip a coin: heads, the King decides normally; tails, the King falls asleep and their (or regent) may decide the petition. </br>If there is no heir, then the petition goes to a democratic vote.",
				"CH" => "國王身體很好,但昏昏欲睡。在會議期,當國王該做決策時,拋擲一枚硬幣:人頭,國王照常做出決策;文字,國王睡著了,而他們(或攝政王)可以決策該請願。如果沒有繼承人,那麼該請願將民主投票表決。"
			)
		),
		"H03" => array(
			"ID" 		=> "H03", 
			"Title" => array(
				"Basic" => "Feverish",
				"EN" 		=> "feverish",
				"CH" 		=> "燒昏頭",
			),
			"Result"	=> array(
				"EN" => "The King is reasonably well, but he is not entirely lucid. During the Council phase, petitioning and voting occur in the standard order, by Status (and those with higher Status may still interrupt, as usual). </br>However, when voting on each petition, each player may pretend to be any other player and this use that player’s Favor for the petition at hand. No two players may pretend to be the same player may for the same vote, so the first players to vote will normally have the highest Favor for this turn’s voting.",
				"CH" => "國王相當健康,但也並非完全清醒。在會議期時,請願和投票照標準次序,按照地位(有較高地位的人也可以插隊,像往常一樣)。</br>然後,表決每項請願時,每位玩家可以假扮成其他玩家,而使用該玩家的寵愛度表決請願。</br>沒有兩位玩家能在投同一票時假扮同一位玩家;因此通常第一位投票的玩家在這回合的投票時,具有最高的寵愛度。"
			)
		),
		"H04" => array(
			"ID" 		=> "H04", 
			"Title" => array(
				"Basic" => "Irritated",
				"EN" 		=> "irritated",
				"CH" 		=> "惱羞成怒",
			),
			"Result"	=> array(
				"EN" => "The King is well, but grouchy. All Favor penalties or losses are doubled this turn, and no petitions to be released from the Dungeon are allowed.",
				"CH" => "國王很健康,但憤怒不已。本回合內,所有寵愛度的懲罰,或損失都加倍;而不會有任何從地牢釋放的請願通過。"
			)
		),
		"H05" => array(
			"ID" 		=> "H05", 
			"Title" => array(
				"Basic" => "Pale as a Ghost",
				"EN" 		=> "pale as a ghost",
				"CH" 		=> "蒼白得像鬼",
			),
			"Result"	=> array(
				"EN" => "The King is well this turn, though tired and weak. The controller of the Royal Doctor may insist that the King step down this turn without having to petition for this result.",
				"CH" => "國王這回合很健康,雖然感到疲倦和虛弱。控制御醫的玩家可以堅持國王在本回合中休息,而這結果將導致這回合謝絕所有請願。"
			)
		),
		"H06" => array(
			"ID" 		=> "H06", 
			"Title" => array(
				"Basic" => "Paranoid",
				"EN" 		=> "paranoid",
				"CH" 		=> "偏執狂",
			),
			"Result"	=> array(
				"EN" => "The King is well, but he knows everyone is against him! All players receive 1 additional Intrigue card this turn.",
				"CH" => "國王很健康,但是認為每個人都對他不利!本回合所有玩家額外獲得 1 張陰謀卡。"
			)
		),
		"H07" => array(
			"ID" 		=> "H07", 
			"Title" => array(
				"Basic" => "Spring Chicken",
				"EN" 		=> "springchicken",
				"CH" 		=> "回春",
			),
			"Result"	=> array(
				"EN" => "You accept the petition if it is supported by a net Favor of 3 or more.",
				"CH" => "國王很健康。事實上,他感覺精神飽滿,這回合不會有玩家喪失寵愛度。"
			)
		),
		"H08" => array(
			"ID" 		=> "H08", 
			"Title" => array(
				"Basic" => "That’s Good Medicine!",
				"EN" 		=> "that’sgoodmedicine!",
				"CH" 		=> "多好的藥！",
				"0" 		=> "多好的藥!",
				"1" 		=> "多好的藥",
			),
			"Result"	=> array(
				"EN" => "The King is well, and full of vigor. He pardons and releases everyone in the Dungeon. Further, he allows the Council to operate as a democracy this turn even while he’s in attendance: The King votes for all petitions from players with Favor of 2 or higher and against those from players with 1 or 2 Favor.",
				"CH" => "國王很健康,充滿活力。他赦免並釋放在地牢的所有人。</br>此外,這回合的會議他安排了民主政治,即使他有出席:國王對所有請願投票,提出的玩家有高於 2 點的寵愛度時,投贊成票;而僅有1 點或 2 點的寵愛度時,投反對票。"
			)
		),
		"H09" => array(
			"ID" 		=> "H09", 
			"Title" => array(
				"Basic" => "Stricken",
				"EN" 		=> "stricken",
				"CH" 		=> "病痛侵襲",
			),
			"Result"	=> array(
				"EN" => "The King is ill. However, the controller of the Royal Doctor may have the King treated, if she wishes, and thus have him hold Council this turn.",
				"CH" => "國王病了。然而,控制御醫的玩家可以跟國王討論,如果他願意,那這回合他可以主持會議。"
			)
		),
		"H10" => array(
			"ID" 		=> "H10", 
			"Title" => array(
				"Basic" => "Unwell",
				"EN" 		=> "unwell",
				"CH" 		=> "不舒適",
			),
			"Result"	=> array(
				"EN" => "The King is barely well enough to hold Council. Given his condition, he does not have the patience for dissenting votes: Only votes for a petition are counted (though this includes the ambassador voting “for”—and thus actually against—a petition).",
				"CH" => "國王勉強主持會議。考慮到他的病情,他沒有耐心處理反對票:僅計算贊成請願的票(雖然這包含大使「投票的」—事實上代表反對—請願)。"
			)
		),
		"H11" => array(
			"ID" 		=> "H11", 
			"Title" => array(
				"Basic" => "White Space",
				"EN" 		=> "whitespace",
				"CH" 		=> "空白牌",
			),
			"Result"	=> array(
				"EN" => "Flip a coin to defined the King is sick or not; Head: the King is well, Tails: the King is sick.",
				"CH" => "投擲硬幣，判斷國王是否生病；頭在上：國王無事，字在上：國王生病。"
			)
		),
	);

	//print_r($ary_setHealthList);
?>