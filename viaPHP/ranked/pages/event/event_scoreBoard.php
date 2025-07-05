
<script><?php require_once("./tools/ajax/ajax_getRankData.php"); ?></script>
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
		resetBoard();
	});
</script>