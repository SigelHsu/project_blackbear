var players;
var timerId;
var scoreToWin = 2000;
var updateInterval = 2000;

//昇冪排序
function ascension(a, b) 	{ return (a.score == b.score && a.star > b.star) ? 1 : ( a.score > b.score ? 1 : -1); }
//降冪排序，以 score先排序，然後是 star
function descending(a, b) { return (a.score == b.score && a.star < b.star) ? 1 : ( a.score < b.score ? 1 : -1); }

//調整相對高度...y為標題欄位的高度。(這邊應該可以調整，除了標題以外，還有各個欄位的高度)
function reposition() {
	var height = $("#rankBoard .boardTitle").height();
	//console.log("height" , height);
	var y = height;
	for(var i = 0; i < players.length; i++) {
		players[i].$item.css("top", y + "px");
		console.log("players[i]", players[i].$item);
		y += height;			
	}
	$("#div_main").height(players.length * height);
}
//更新排名版
function updateBoard() {
	var player = getRandomPlayer();	
	player.score += 100;		//player.score += getRandomScoreIncrease();
	player.$item.find(".score > span").text(player.score);
	
	players.sort(descending);				//根據昇冪或降冪進行排序，descending為降冪
	updateRanks(players);
	reposition();
	
	if(isGameOver(player.score)) {
		resetBoard();	
	}
}

//判斷比賽是否結束
function isGameOver(score) {
	return score >= scoreToWin;
}
//隨機選擇一名
function getRandomPlayer() {
	var index = getRandomBetween(0, players.length);
	return players[index];
}
//隨機生成一個介於 50~150之間的點數
function getRandomScoreIncrease() {
	return getRandomBetween(50, 150);
}
//隨機生成一個介於 N~M之間的點數
function getRandomBetween(minimum, maximum) {
	 return Math.floor(Math.random() * maximum) + minimum;
}

//更新名次
function updateRanks(players) {
	for(var i = 0; i < players.length; i++) {
		players[i].$item.find(".rank").text(i + 1);	
	}
}

//重設排名版
function resetBoard() {
	var $list = $("#rankList");
	
	$list.find("div.player").remove();
	if(timerId !== undefined) {
		clearInterval(timerId);
	}
	
	players = [
				{ name: "D35truXion", score: 500, star: 5, card: 2, image: "./img/head_icon.jpg", scoreImage: "./img/blood.png", starImage: "./img/star.png", cardImage: "./img/card-game.png" },
				{ name: "Lithos", score: 400, star: 1, card: 3, image: "./img/Perry_the_platypus.png", scoreImage: "./img/blood.png", starImage: "./img/star.png", cardImage: "./img/card-game.png" },
				{ name: "baby.bumpkins", score: 300, star: 2, card: 4, image: "./img/head_icon.jpg", scoreImage: "./img/blood.png", starImage: "./img/star.png", cardImage: "./img/card-game.png" },
				{ name: "SpreadsheetMan", score: 200, star: 3, card: 6, image: "./img/Perry_the_platypus.png", scoreImage: "./img/blood.png", starImage: "./img/star.png", cardImage: "./img/card-game.png" },
				{ name: "Eitz", score: 100, star: 4, card: 8, image: "./img/head_icon.jpg", scoreImage: "./img/blood.png", starImage: "./img/star.png", cardImage: "./img/card-game.png" }
	];
	for(var i = 0; i < players.length; i++) {
		var $item = $(
			"<div class='player rankbar col-12'>" + 
				"<div class='rank col-2'>" + (i + 1) + "</div>" + 
				"<div class='name col-4'>" + 
					"<img class='playerImg' src=\""+players[i].image+"\" alt=\""+players[i].name+"\">" + 
					"<span>" + players[i].name + "</span>" +
				"</div>" +
				"<div class='score col-2'>" + 
					"<img class='scoreImg' src=\""+players[i].scoreImage+"\" alt=\""+players[i].score+"\">" + 
					"<span>" + players[i].score + "</span>" +
				"</div>" +
				"<div class='star col-2'>" + 
					"<img class='starImg' src=\""+players[i].starImage+"\" alt=\""+players[i].star+"\">" + 
					"<span>" + players[i].star + "</span>" + 
				"</div>" +
				"<div class='cards col-2'>"  + 
					"<img class='cardImg' src=\""+players[i].cardImage+"\" alt=\""+players[i].card+"\">" + 
					"<span>" + players[i].card + "</span>" + 
				"</div>" +
			"</div>");
		players[i].$item = $item;
		$list.append($item);
	}
	
	timerId = setInterval("updateBoard();", updateInterval);
	
	reposition();
}