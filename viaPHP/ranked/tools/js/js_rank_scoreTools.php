let data_Rank;
let timerId;
let scoreToWin = 2000;
let updateInterval 		= <?=$data["event"]["Setting"]["Update-Frequency"]; ?> * 10000;
let set_headerHeight 	= <?=$data["event"]["Setting"]["Col-Height"]; ?>;

<?php
	function fun_settingRules ($rules = array(), $type = 1, $i = 0) {
		$setType  = ($type == 1) ? (">") : ("<");
		$str_rtn  = "";
		$str_rtn .= "if( a.ForRank.".$rules[$i]["Tag"]." ".$setType." b.ForRank.".$rules[$i]["Tag"]." ) { ";
		$str_rtn .= 	"return 1;";
		$str_rtn .= " }";
		$str_rtn .= "else if( a.ForRank.".$rules[$i]["Tag"]." == b.ForRank.".$rules[$i]["Tag"]." ) { ";
		
		if( $i + 1 == count($rules) ) {
			$str_rtn .= 	"return 0;";
		}
		else {
			$str_rtn .= fun_settingRules($rules, $type, $i+1);
		}
		
		$str_rtn .= " }";
		
		return $str_rtn;
	}
?>

//昇冪排序
function ascension(a, b) 	{ 
	//return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score > b.ForRank.Score ? 1 : -1); 
	<?=fun_settingRules($data["rules"], 1); ?>
	return -1;
	
}
//降冪排序
function descending(a, b) {
	//return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score < b.ForRank.Score ? 1 : -1); 
	
	<?=fun_settingRules($data["rules"], 2); ?>
	return -1;
}

//調整相對高度...y為標題欄位的高度。(這邊應該可以調整，除了標題以外，還有各個欄位的高度)
function reposition(data) {
	//$(".sticky-footer").addClass("d-none");
	let height = set_headerHeight;
	let y = height;
	for(var i = 0; i < data.length; i++) {
		
		data[i].$item.css("top", y + "px");
		y += height;			
	}
}
//尋找特定的Player	//https://stackoverflow.com/questions/11258077/how-to-find-index-of-an-object-by-key-and-value-in-an-javascript-array
function getPlayerIndex(key) {
	var index = data_Rank.players.findIndex(function(person) {
				return person.ID == key
			});
	return index;
}
//更新排名版
function updateBoard() {
	let data_newRank 	= ajax_getRankData(), 
			forRankData 	= data_Rank["rules"], 
			oldPlayers 		= data_Rank["players"]
			newPlayers 		= data_newRank["players"];
	for(let i = 0; i < newPlayers.length; i++) {
		
		let tmpData = newPlayers[i],
				oldPlayerKey = getPlayerIndex(tmpData.ID);
		
		oldPlayers[oldPlayerKey].$item.find(".name > span").text(newPlayers.Name);
		
		for(let n = 0; n < forRankData.length; n++) {
			let rankTag 				= forRankData[n]["Tag"], 
					rankImg 				= forRankData[n]["Img"]["Loc"], 
					playerRankData 	= tmpData["ForRank"];
			
			oldPlayers[oldPlayerKey].$item.find("."+rankTag.toLowerCase()+" > span").text(newPlayers[i].ForRank[rankTag]);
		}
		oldPlayers[oldPlayerKey].ForRank = newPlayers[i].ForRank;
	}
	
	oldPlayers.sort(descending);				//根據昇冪或降冪進行排序，descending為降冪
	updateRanks(oldPlayers);
	reposition(oldPlayers);
}
//更新名次
function updateRanks(players) {
	for(var i = 0; i < players.length; i++) {
		var reRank = (i == 0) ? (i + 1) : ( i + Math.abs( descending(players[i-1], players[i]) ) );
		players[i].$item.find(".rank").text(reRank);	
	}
}

//重設排名版
function resetBoard() {
	let $list = $("#players");
	
	$list.find("li.player").remove();
	if(timerId !== undefined) {
		clearInterval(timerId);
	}
	
	data_Rank = ajax_getRankData();			//console.log("data_Rank ", data_Rank);
	
	let forRankData = data_Rank["rules"], 							
			data_Players = data_Rank["players"];						//console.log(data_Players.length, data_Players);
			
	for(let i = 0; i < data_Players.length; i++) {
		let tmpData = data_Players[i], tempString = "";		//console.log(i, tmpData);
		
		tempString += "<li class='player'>";
		tempString += 	"<div class='rank'>" + (i + 1) + "</div>";
		
		tempString += 	"<div class='name'>";
		tempString += 		"<img class='playerImg' src=\""+tmpData.Image.Loc+"\" style = \"width: "+tmpData.Image.Width+"px; text-align: center;\" alt=\""+tmpData.Name+"\">";
		tempString += 		"<span>" + tmpData.Name + "</span>";
		tempString += 	"</div>";
		
		for(let n = 0; n < forRankData.length; n++) {
			let rankTag = forRankData[n]["Tag"], 
					rankImg = forRankData[n]["Img"]["Loc"], 
					rankWid = forRankData[n]["Img"]["Width"], 
					playerRankData = tmpData["ForRank"];
			
			tempString += 	"<div class='rulesDiv'>";
			tempString += 		"<img class='rankImg' src=\""+rankImg+"\" style = \"width: "+rankWid+"px; text-align: center;\" alt=\""+rankTag.toLowerCase()+"Img\">";
			tempString += 		"<span>" + parseInt(playerRankData[rankTag]) + "</span>";
			tempString += 	"</div>";
		}
		
		tempString += "</li>";
		
		let $item = $(tempString);		//console.log($item);
		data_Players[i].$item = $item;
		$list.append($item);
	}
	
	timerId = setInterval("updateBoard();", updateInterval);
	reposition(data_Players);
}


function ajax_getRankData () {
	let rspData = [];
	let code = "<?=$eventCode;?>";
	console.log("ajax_getRankData");
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_getRankData.php?code="+code,
    dataType: "JSON",
		async: false,
    success: function (response) {
			console.log("success", typeof response);
			console.log(response);
			rspData = response;
    },
    error: function (thrownError) {
      console.log(thrownError);
    }
  });
	return rspData;
}






/*------------------------------------------------------------*/
//留存備份用
/*
//昇冪排序			//最原始 function ascension(a, b) 	{ return ( a.ForRank.Score > b.ForRank.Score ? 1 : -1); }
//第一次修改		//	function ascension(a, b) 	{ return (a.ForRank.Score == b.ForRank.Score && a.ForRank.Star > b.ForRank.Star) ? 1 : ( a.ForRank.Score > b.ForRank.Score ? 1 : -1); }
//最終決定型態	//	function ascension(a, b) 	{ return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score > b.ForRank.Score ? 1 : -1); }
//降冪排序			//最原始 function descending(a, b) 	{ return ( a.ForRank.Score < b.ForRank.Score ? 1 : -1); }
//第一次修改		//	function descending(a, b) { return (a.ForRank.Score == b.ForRank.Score && a.ForRank.Star < b.ForRank.Star) ? 1 : ( a.ForRank.Score < b.ForRank.Score ? 1 : -1); }
//最終決定型態	//	function descending(a, b) { return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score < b.ForRank.Score ? 1 : -1); }
*/
/*
//昇冪排序
//function ascension(a, b) 	{ 
//	return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score > b.ForRank.Score ? 1 : -1); 
//}
//降冪排序
//function descending(a, b) {
//	//return (a.ForRank.Score == b.ForRank.Score) ? 0 : ( a.ForRank.Score < b.ForRank.Score ? 1 : -1); 
//	//			 (a.ForRank.Score == b.ForRank.Score && a.ForRank.Star < b.ForRank.Star) ? 1 : ( a.ForRank.Score < b.ForRank.Score ? 1 : -1);
//	
//	return -1;
//	
//	//以 PHP字串概略呈現的形式
//	//echo "if(a.ForRank.".$data["rules"][$i]["Tag"]." < b.ForRank.".$data["rules"][$i]["Tag"];.") { ";
//	//echo 	"return 1;";
//	//echo "}";
//	//echo "else if( a.ForRank.".$data["rules"][$i]["Tag"]." == b.ForRank.".$data["rules"][$i]["Tag"]." ) { ";
//	//	
//	//echo 	"if( a.ForRank.".$data["rules"][$i+1]["Tag"]." < b.ForRank.".$data["rules"][$i+1]["Tag"]." ) { ";
//	//echo 		"return 1;";
//	//echo 	"}";
//	//echo 	"else if( a.ForRank.".$data["rules"][$i+1]["Tag"]." == b.ForRank.".$data["rules"][$i+1]["Tag"]." ) { ";
//	//
//	//echo		"if( a.ForRank.".$data["rules"][$i+2]["Tag"]." < b.ForRank.".$data["rules"][$i+2]["Tag"]." ) { ";
//	//echo 			"return 1;";
//	//echo 		"}";
//	//echo 		"else if( a.ForRank.".$data["rules"][$i+2]["Tag"]." == b.ForRank.".$data["rules"][$i+2]["Tag"]." ) { ";
//	//echo			"return 0;";
//	//echo 		"}";
//	//
//	//echo 	"}";
//	//
//	//echo "}";

//	//整理成容易遞迴的最終方式
//	//if(a.ForRank.Score < b.ForRank.Score) {
//	//	return 1;
//	//}
//	//else if( a.ForRank.Score == b.ForRank.Score ) {
//	//	
//	//	if( a.ForRank.Star < b.ForRank.Star ) {
//	//		return 1;
//	//	}
//	//	else if( a.ForRank.Star == b.ForRank.Star )
//	//	{
//	//		if( a.ForRank.Cards < b.ForRank.Cards ) {
//	//			return 1;
//	//		}
//	//		else if( a.ForRank.Cards == b.ForRank.Cards ) {
//	//			return 0;
//	//		}
//	//	}
//	//}
//	//return -1;

//	//概略整理後
//	//if(a.ForRank.Score < b.ForRank.Score) {
//	//	return 1;
//	//}
//	//else if( a.ForRank.Score == b.ForRank.Score ) {
//	//	
//	//	if( a.ForRank.Star < b.ForRank.Star ) {
//	//		return 1;
//	//	}
//	//	else if( a.ForRank.Star == b.ForRank.Star )
//	//	{
//	//		if( a.ForRank.Cards < b.ForRank.Cards ) {
//	//			return 1;
//	//		}
//	//		else if( a.ForRank.Cards == b.ForRank.Cards ) {
//	//			return 0;
//	//		}
//	//		else {
//	//			return -1;
//	//		}
//	//	}
//	//	else {
//	//		return -1;
//	//	}
//	//}
//	//else {
//	//	return -1;
//	//}

//	//最初的形式
//	//if(a.ForRank.Score < b.ForRank.Score) {
//	//	return 1;
//	//}
//	//else if( a.ForRank.Score == b.ForRank.Score && a.ForRank.Star < b.ForRank.Star ) {
//	//	return 1;
//	//}
//	//else if( a.ForRank.Score == b.ForRank.Score && a.ForRank.Star == b.ForRank.Star && a.ForRank.Cards < b.ForRank.Cards ) {
//	//	return 1;
//	//}
//	//else if( a.ForRank.Score == b.ForRank.Score && a.ForRank.Star == b.ForRank.Star && a.ForRank.Cards == b.ForRank.Cards ) {
//	//	return 0;
//	//}
//	//else {
//	//	return -1;
//	//}
//}
*/


/*------------------------------------------------------------*/
/*這四個 function後續就用不到了*/
//判斷比賽是否結束
function isGameOver(score) {
	return score >= scoreToWin;
}
//隨機選擇一名
function getRandomPlayer() {
	var index = getRandomBetween(0, data_Players.length);
	return data_Players[index];
}
//隨機生成一個介於 50~150之間的點數
function getRandomScoreIncrease() {
	return getRandomBetween(50, 150);
}
//隨機生成一個介於 N~M之間的點數
function getRandomBetween(minimum, maximum) {
	 return Math.floor(Math.random() * maximum) + minimum;
}

/*//廢案...不知道原因，總是會自動更新順序，導致無法對應到正確的資料
//更新排名版
function updateBoard() {
	console.log("data_Rank0 ", data_Rank);
	let data_newRank 	= ajax_getRankDataNew(), 
			forRankData = data_Rank["rules"], 
			oldPlayers 	= data_Rank["players"]
			newPlayers 	= data_newRank["players"];
	for(let i = 0; i < oldPlayers.length; i++) {
		let tmpData = newPlayers[i];
		
		console.log(oldPlayers[i], newPlayers[i]);
		
		oldPlayers[i].$item.find(".name > span").text(newPlayers.Name);
		
		for(let n = 0; n < forRankData.length; n++) {
			let rankTag = forRankData[n]["Tag"], 
					rankImg = forRankData[n]["Image"], 
					playerRankData = tmpData["ForRank"];
			
			oldPlayers[i].$item.find("."+rankTag.toLowerCase()+" > span").text(newPlayers[i].ForRank[rankTag]);
		}
		
		console.log(oldPlayers[i], oldPlayers[i].ForRank, newPlayers[i], newPlayers[i].ForRank);
		oldPlayers[i].ForRank = newPlayers[i].ForRank;
	}
	console.log("data_Rank1 ", data_Rank);
	console.log("data_Players ", data_Players);
	var data_Players = oldPlayers;
	data_Players.sort(descending);				//根據昇冪或降冪進行排序，descending為降冪
	updateRanks(data_Players);
	reposition(data_Players);
	console.log("data_Rank2 ", data_Rank);
	if(isGameOver(player.score)) {
		resetBoard();	
	}
}
*/