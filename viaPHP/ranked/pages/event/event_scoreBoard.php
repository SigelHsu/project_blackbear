
<?php 
	$eventCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");
	$data["event"] 		= fun_getEventData(array("Code" => $eventCode));	//獲取活動資料
	$data["rules"] 		= fun_getEventRuleData($data["event"]["ID"]);			//獲取活動排序規則
	$data["players"] 	= fun_getEventPlayerData($data["event"]["ID"]);		//獲取活動玩家資訊
	?>
<script><?php include_once("./tools/js/js_rank_scoreTools.php"); ?></script>
<link href = "./tools/css/rank-score.css" rel="stylesheet">

<div id="leaderboard">
	<ul id="players">
		<li class="header <?=($data["event"]["Setting"]["ShowTitle"] == 1) ? ("d-none") : (""); ?>">
			<div class="rank">Rank</div>
			<div class="name">Player</div>
			<?php
				foreach($data["rules"] AS $Key => $Values) :
			?>
			<div class="<?=$Values["Tag"]; ?>"><?=$Values["Tag"]; ?></div>
			<?php 
				endforeach;
			?>
		</li>
	</ul>
</div>

<div style="clear:both;"></div>
<a id="btn_reflash" class="scroll-to-fresh rounded" href="javaScript: updateBoard();">
	<i class="fas fa-sync-alt" data-toggle = "tooltip" data-placement = "top" title = "重新排名"></i>
</a>



<script>
	$(document).ready(function() {
		$(".sticky-footer").addClass("d-none");
		$("#btn_top").addClass("d-none");
		$(".navbar").addClass("d-none");
		$("#accordionSidebar").addClass("d-none");	//$("#content-wrapper").addClass("d-none");
		$("#div_main").css("min-height", "800px");
		resetBoard();	//ajax_getRankData();
	});
</script>
<style>
	#leaderboard li {
		font-family: <?=$data["event"]["Setting"]["Font-Family"]; ?>; 		/*sans-serif;*/
		color: <?=$data["event"]["Setting"]["Font-Color"]; ?>;						/*white*/
		font-size: <?=$data["event"]["Setting"]["Font-Size"]; ?>px;				/*20px*/
		line-height: <?=$data["event"]["Setting"]["Col-Height"]-10; ?>px;	/*70px*/
		font-weight: bold;
	}
	#leaderboard #players {
		width: <?=$data["event"]["Setting"]["Col-Width"]; ?>px;						/*650px*/
	}
	#leaderboard #players div {
		height: <?=$data["event"]["Setting"]["Col-Height"]; ?>px;					/*80px*/
	}
	#leaderboard #players li {
		background-image: url("<?=$data["event"]["Img"]["Loc"]; ?>");			/*"./img/E000001/event_bgimg.png"*/
		background-size: <?=$data["event"]["Img"]["Width"]; ?>px <?=$data["event"]["Img"]["Height"]; ?>px;	/*650px 80px*/
	}
	#leaderboard .player > .rank {
		/* background-image: url(border_bg.jpg); */
		background-size: <?=$data["event"]["Setting"]["Rank-Width"]; ?>px <?=$data["event"]["Setting"]["Col-Height"]; ?>px;	/*50px 80px*/
	}
	#leaderboard .rank {
		width: <?=$data["event"]["Setting"]["Rank-Width"]; ?>px;	/*90px*/
		text-align: center;
	}
	#leaderboard .name {
		width: <?=$data["event"]["Setting"]["Name-Width"]; ?>px;	/*250px*/
    margin-left: 10px;
	}
	#leaderboard .rulesDiv {
		/*font-size: 20px;*/
		width: <?=$data["event"]["Setting"]["Rule-Width"]; ?>px;	/*100px*/
		text-align: center;
	}
	/*
	#leaderboard .playerImg {
		width: 50px;
		text-align: center;
	}
	#leaderboard .rankImg {
		width: 20px;
		text-align: center;
	}
	*/
</style>