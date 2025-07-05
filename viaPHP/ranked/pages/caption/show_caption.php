<?php
	$captionCode 			= (isset($_GET["code"])) ? ($_GET["code"]) : ("");
	$data["caption"] 	= fun_getCaptionData(array("Code" => $captionCode));															//獲取字幕組資料
	$captionID 				= $data["caption"]["ID"];
	$data["setting"] 	= $data["caption"]["Setting"];																										//獲取字幕組設定
	$data["subtitle"] = array();																																				//獲取字幕資訊

	$set_fontContent = "start";
	switch($data["setting"]["Font-Content"]) {
		default:
		case 1:
			$set_fontContent = "start";
			break;
		case 2:
			$set_fontContent = "center";
			break;
		case 3:
			$set_fontContent = "end";
			break;
	}
	
	$set_BGTransparent = (isset($data["setting"]["Board-Transparent"]) && ($data["setting"]["Board-Transparent"] == 1)) ? ("d-none") : ("");
	$set_Frequency = array(
		"FreUpd" 	 	=> (isset($data["setting"]["Update-Frequency"]) && ($data["setting"]["Update-Frequency"] 	!= 0)) ? ($data["setting"]["Update-Frequency"]) : (0.5)
	);
?>

<!-- Card Body -->
<div id="div_captionBox" class="card-body justify-content-<?=$set_fontContent; ?>">
	<?php 
		foreach($data["subtitle"] AS $Key => $Value): 
	?>
	<div id="subtitleBox_<?=$Value["Subtitle_ID"]; ?>" class="div_subtitleBlock form-group col-md-12 form-row slide-up">
		<?=$Value["Time_Tag"]; ?><?=htmlspecialchars_decode($Value["Subtitle_Info"]); ?>
	</div>
	<?php endforeach; ?>
</div>

<style type="text/css">
	div#div_main {
		display: grid;
    place-items: center;     /* 水平和垂直置中 */
		margin: 10px auto 0px auto;
	}

	#div_captionBox {
		width: 	<?=(isset($data["setting"]["Board-Width"])) 	? ($data["setting"]["Board-Width"]."px") 		: ("auto"); ?>;
		height: <?=(isset($data["setting"]["Board-Height"])) 	? ($data["setting"]["Board-Height"]."px") 	: ("auto"); ?>;
		<?php
			if( isset($data["setting"]["Caption-Border"]) ) {
				echo "border: ".$data["setting"]["Caption-Border"].";";
			}
		?>
		<?php 
			switch($data["setting"]["Align-Content"]) {
				case 1:
				case "1":
					echo "display: flex; ";
					echo "align-items: flex-start; 			/* 水平方向靠上 */ ";
					echo "justify-content: flex-start; 	/* 垂直方向靠左 */ ";
					break;
				case 2:
				case "2":
					echo "display: flex; ";
					echo "align-items: center; 					/* 水平方向靠上 */ ";
					echo "justify-content: center; 			/* 垂直方向靠左 */ ";
					break;
				case 3:
				case "3":
					echo "display: flex; ";
					echo "align-items: flex-end; 				/* 水平方向靠下 */ ";
					echo "justify-content: flex-end; 		/* 垂直方向靠右 */ ";
					break;
				default:
					break;
			} 
		?>
		overflow-y: scroll;
	}
	.css_transparent {
		background-color: transparent !important;
	}

	div.card-body {
		<?php if( isset($data["setting"]["Background-Img"]) ): ?>
		background-image: url(<?=$data["setting"]["Background-Img"]; ?>);
		<?php endif; ?>
		background-size: contain;
		background-position: center;
		background-repeat: no-repeat;
		witght: <?=(isset($data["setting"]["Board-Width"])) 	? ($data["setting"]["Board-Width"]."px") 		: ("auto"); ?>;
		height: <?=(isset($data["setting"]["Board-Height"])) 	? ($data["setting"]["Board-Height"]."px") 	: ("auto"); ?>;
	}
	div.div_subtitleBlock {
		<?php if( isset($data["setting"]["Background-Color"]) && ( $data["setting"]["Background-Color"] != "" ) ): ?>
		background-color: <?=$data["setting"]["Background-Color"]; ?>;
		<?php endif; ?>
		
		<?php if( isset($data["setting"]["Font-Family"]) ): ?>
		font-family: '<?=$data["setting"]["Font-Family"]; ?>';
		<?php endif; ?>
		
		<?php if( isset($data["setting"]["Font-Size"]) ): ?>
		font-size: <?=$data["setting"]["Font-Size"]; ?>px;
		<?php endif; ?>
		
		<?php if( isset($data["setting"]["Font-Color"]) ): ?>
		color: <?=$data["setting"]["Font-Color"]; ?>;
		<?php endif; ?>
		
		<?php if( isset($data["setting"]["Font-Shadow"]) && ( $data["setting"]["Font-Shadow"] != "" ) ): ?>
		text-shadow: <?=$data["setting"]["Font-Shadow"]; ?>;
		<?php endif; ?>
		
    width: auto;
    height: auto;
		overflow: hidden;
		
    padding: <?=(isset($data["setting"]["Set-Padding"][0])) ? ($data["setting"]["Set-Padding"][0]) : (0); ?>px 
						 <?=(isset($data["setting"]["Set-Padding"][1])) ? ($data["setting"]["Set-Padding"][1]) : (0); ?>px
						 <?=(isset($data["setting"]["Set-Padding"][2])) ? ($data["setting"]["Set-Padding"][2]) : (0); ?>px
						 <?=(isset($data["setting"]["Set-Padding"][3])) ? ($data["setting"]["Set-Padding"][3]) : (0); ?>px;
    margin:  <?=(isset($data["setting"]["Set-Margin"][0])) ? ($data["setting"]["Set-Margin"][0]) : (0); ?>px 
						 <?=(isset($data["setting"]["Set-Margin"][1])) ? ($data["setting"]["Set-Margin"][1]) : (0); ?>px
						 <?=(isset($data["setting"]["Set-Margin"][2])) ? ($data["setting"]["Set-Margin"][2]) : (0); ?>px
						 <?=(isset($data["setting"]["Set-Margin"][3])) ? ($data["setting"]["Set-Margin"][3]) : (0); ?>px;
						 
	 --animation-duration: 0.5s;
	}
	
	@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
	}
	
	@keyframes slideOut {
		from {
			transform: translateY(0);
			opacity: 1;
		}
		to {
			transform: translateY(-100%);
			opacity: 0;
		}
	}

	.slide-up {
		animation: slideUp var(--animation-duration) ease-in-out;
	}
	
	.slide-out {
		display: inline-block;
		animation: slideOut var(--animation-duration) ease-in-out;
	}
	@font-face {
		font-family: 'DFLiSongTC-W5';
		src: url('./tools/fonts/DFLiSongTC-W5.otf') format('opentype');
	}
</style>
<script>
	// 設定執行的間隔時間（毫秒）
	const set_intervalTime = <?=$set_Frequency["FreUpd"]; ?> * 1000; // 1000 毫秒 = 1 秒
	
	$(document).ready(function() {
		<?php if($set_BGTransparent != "") : ?>			//將背景透明化
		$("body, div").addClass("css_transparent");
		<?php endif; ?>
		fun_hideTheTopLeftBar();
		
		//時既要處理效果的部分
		js_makeupSubtitleData(<?=$data["setting"]["When-Refresh"]; ?>);
		let timerId = setInterval("js_makeupSubtitleData(1);", set_intervalTime);
	});
	
	function js_makeupSubtitleData (ipt_grabType = 1) {
		// console.log("js_makeupSubtitleData")
		let get_subtitleList = ajax_getSubtitleData(<?=$captionID; ?>, ipt_grabType);
		console.log("js_makeupSubtitleData ", get_subtitleList);
		//根據抓取到的資料，將字幕寫入到網頁上
		get_subtitleList.forEach(mod => {
			if( mod.Subtitle_ID != "" ) {
				js_pushSubtitle(mod.Subtitle_ID, mod.Subtitle_Info); 
			}
    });
		
	}
	
	function js_pushSubtitle(ipt_subID = 0, ipt_subtitle = "正在載入字幕...") {
		console.log("js_pushSubtitle: ", ipt_subID, "-", ipt_subtitle);
		const tmp_divCaption = document.getElementById("div_captionBox");
		// 檢查 div 是否存在
    if (!tmp_divCaption) {
			console.error(`Element with ID ${whichDiv} not found.`);
			return; 			// 如果找不到，則返回
    }
		
		const tmp_divSubtitle = document.getElementById('subtitleBox_'+ipt_subID);
		//檢查要會插入的 div是否已經存在
		if ( tmp_divSubtitle ) {		
			
			if( tmp_divSubtitle.innerHTML.trim() == ipt_subtitle) {
				console.log(`Element with ID ${'subtitleBox_'+ipt_subID} is exist.`);
				return; 		// 如果已經存在則返回 ERROR
			}
			else {
				/*
				var tempElement = document.createElement('div');
				tempElement.innerHTML = decodedString;

				// 將解碼後的值插入到指定的 div 框架中
				var divElement = document.createElement('div');
				divElement.textContent = tempElement.textContent || tempElement.innerText;
				*/
				
				tmp_divSubtitle.innerHTML = ipt_subtitle;
				return;
			}
		}
		
		//建立會被插入的 div
    const newDiv = document.createElement('div');
    const tempElement = document.createElement('div');
    tempElement.innerHTML = decodeURIComponent(ipt_subtitle);
    newDiv.innerHTML = tempElement.innerHTML;
    newDiv.id = 'subtitleBox_' + ipt_subID;
    newDiv.classList.add('div_subtitleBlock');
    newDiv.classList.add('justify-content-<?=$set_fontContent; ?>');
    newDiv.classList.add('form-group');
    newDiv.classList.add('col-md-12');
    newDiv.classList.add('form-row');
    newDiv.classList.add('slide-up');
		
		//判斷是否要清除舊資料 //如果將來需要，可以考慮是不是用 Max-Line的部分，清掉最舊的資料
		var tmp_isKeepHistroy = <?=$data["setting"]["Keep-Histroy"]; ?>;
		if( tmp_isKeepHistroy == 0) {
			// 清除 tmp_divCaption 裡面的內容
			tmp_divCaption.innerHTML = "";
		}
		
		// 插入新的 div 元素
    tmp_divCaption.appendChild(newDiv);
		newDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
		ajax_publisedhthisSubtitles(ipt_subID)
	}
	
	// caption_subtitle.php			// 將目標文字設置成已發佈
	function ajax_publisedhthisSubtitles(target_ID) {
		// console.log("ajax_publisedhthisSubtitles ");
		let rspData = [];
		
		if( target_ID == "" ) {
			return false;
		}
		
		var datas = [
			{ name: "modify_type", 		value: "Published" },
			{ name: "target_ID", 			value: target_ID }
		];				//console.log("ajax_publisedhthisSubtitles: ", datas);
		
		$.ajax({
			type: "POST",
			url: "./tools/ajax/ajax_updSubtitlesInfo.php",
			dataType: "HTML",
			data: datas,
			async: false,
			success: function (response) {
				//console.log("ajax_publisedhthisSubtitles: ", response);	//console.log(response);
				rspData = response;
				//alert("發佈成功");
				//location.reload();
			},
			error: function (thrownError) {
				console.log("thrownError ", thrownError);
			}
		});
	}
</script>
<script><?php include_once("./tools/js/js_caption_controlTools.php"); ?></script>