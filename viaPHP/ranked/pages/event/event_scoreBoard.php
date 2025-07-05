
<script><?php include_once("./tools/js/js_rank_scoreTools.php"); ?></script>
<link href = "./tools/css/rank-score.css" rel="stylesheet">

<div id="leaderboard">
	<ul id="players">
		<li class="header">
			<div class="rank">Rank</div>
			<div class="name">Player</div>
			<div class="score">Score</div>
			<div class="star">Star</div>
			<div class="cards">Card</div>
		</li>
	</ul>
</div>

<div style="clear:both;"></div>
<script>
	$(document).ready(function() {
		$(".sticky-footer").addClass("d-none");
		//ajax_getRankData();
		resetBoard();
	});
</script>
<style>
	#leaderboard li {
		font-family: sans-serif;
		color: white;
		font-size: 20px;
		font-weight: bold;
		line-height: 70px;
	}
	#leaderboard #players {
		width: 650px;
	}
	#leaderboard #players div {
		height: 80px;
	}
	#leaderboard #players li {
		background-image: url("./img/E000001/event_bgimg.png");
		background-size: 650px 80px;
	}
	#leaderboard .player > .rank {
		/* background-image: url(border_bg.jpg); */
		background-size: 50px 80px;
	}
	#leaderboard .rank {
		width: 90px;
		text-align: center;
	}
	#leaderboard .name {
		width: 250px;
    margin-left: 10px;
	}
	#leaderboard .score {
		font-size: 20px;
		width: 100px;
		text-align: center;
	}
	#leaderboard .star {
		font-size: 20px;
		width: 100px;
		text-align: center;
	}
	#leaderboard .cards {
		font-size: 20px;
		width: 100px;
		text-align: center;
	}
	#leaderboard .playerImg {
		width: 50px;
		text-align: center;
	}
	#leaderboard .scoreImg {
		width: 20px;
		text-align: center;
	}
	#leaderboard .starImg {
		width: 20px;
		text-align: center;
	}
	#leaderboard .cardsImg {
		width: 20px;
		text-align: center;
	}
</style>