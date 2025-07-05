<?php
	$counterCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");
	$data["counter"] 	= fun_getCounterData(array("Code" => $counterCode));	//獲取計數器資料
	$data["setting"] 	= $data["counter"]["Setting"];												//獲取計數器設定
	$data["grabInfo"] = fun_getGrabInfoData($data["counter"]["ID"]);				//獲取活動玩家資訊

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
		"DurStart" 	=> (isset($data["setting"]["Duration-Start"]) 	&& ($data["setting"]["Duration-Start"] 		!= 0)) ? ($data["setting"]["Duration-Start"]) 	: (0.5),
		"DurPer" 	 	=> (isset($data["setting"]["Duration-Per"]) 		&& ($data["setting"]["Duration-Per"] 			!= 0)) ? ($data["setting"]["Duration-Per"]) 		: (0.1),
		"DurMax" 	 	=> (isset($data["setting"]["Duration-Max"]) 		&& ($data["setting"]["Duration-Max"] 			!= 0)) ? ($data["setting"]["Duration-Max"]) 		: (1),
		"FreUpd" 	 	=> (isset($data["setting"]["Update-Frequency"]) && ($data["setting"]["Update-Frequency"] 	!= 0)) ? ($data["setting"]["Update-Frequency"]) : (5),
		"FreNsec" 	=> (isset($data["setting"]["Duration-Nsec"]) 		&& ($data["setting"]["Duration-Nsec"] 		!= 0)) ? ($data["setting"]["Duration-Nsec"]) 		: (4),
		"FreMsec" 	=> (isset($data["setting"]["Duration-Msec"]) 		&& ($data["setting"]["Duration-Msec"] 		!= 0)) ? ($data["setting"]["Duration-Msec"]) 		: (1),
	);
	$set_GrabInfoMax = (isset($data["grabInfo"][0]["Grab_Values"])) ? ($data["grabInfo"][0]["Grab_Values"]) : (0);			//$set_GrabInfoMax = (0);
	//print_r($set_GrabInfoMax);
?>

<!-- Card Body -->
<div class="card-body">
	<div class="table-area row justify-content-<?=$set_fontContent; ?>">
		<div id="div_numContainer" class="form-row col-auto">
			<?php 
				$set_FormattedNum = number_format($set_GrabInfoMax, 0, '.', ',');
				$get_NumCharacter = str_split($set_FormattedNum);
				foreach($get_NumCharacter AS $Key => $Value): 
			?>
			<div id="numBox_<?=$Key; ?>" class="div_numBlock"><?=$Value; ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<style type="text/css">
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
	div.div_numBlock {
		<?php if( isset($data["setting"]["Background-Color"]) ): ?>
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
		
		<?php if( isset($data["setting"]["Font-Shadow"]) ): ?>
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
	}
	
	div#div_numContainer {
    margin: <?=(isset($data["setting"]["Font-Position"]["Y"])) ? ($data["setting"]["Font-Position"]["Y"]) : (0); ?>px 
						0px
						0px
						<?=(isset($data["setting"]["Font-Position"]["X"])) ? ($data["setting"]["Font-Position"]["X"]) : (0); ?>px;
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
	// 設定生成亂數的間隔時間（毫秒）
	const set_intervalTime = <?=$set_Frequency["FreUpd"]; ?> * 1000; // 1000 毫秒 = 1 秒

	// 定義生成亂數的函數
	function fun_genRandomNumber() {
			const randomNumber = Math.random(); // 生成 0 到 1 之間的亂數
			//console.log("Generated Random Number:", randomNumber);
			return randomNumber
	}
	
	//將輸入的數值拆分成字元
	function fun_sepratString(ipt_text = "") {
		let tmp_str = ipt_text.toString();
		let result = new Array();
		for (let i = 0; i < tmp_str.length; i++) {
			// 將字符存儲到物件中，鍵為索引（從 1 開始），值為字符
			result[i] = tmp_str[i];
		}
		return result;
	}
	
	//更新 div的數值
	function updateDivValue(whichDiv, newValue, duration) {
		const div = document.getElementById(whichDiv);
		// 檢查 div 是否存在
    if (!div) {
			console.error(`Element with ID ${whichDiv} not found.`);
			return; // 如果找不到，則返回
    }
		const oldValue = div.textContent;
		//console.log("oldValue: ", oldValue.trim(), "; newValue", newValue.trim());
		
    // 創建一個新的 span 元素來顯示新值，並添加 slide-up 動畫效果
    const newDiv = document.createElement('div');
    newDiv.textContent = newValue;
    newDiv.style.setProperty('--animation-duration', duration + 's');
    newDiv.classList.add('slide-up');
		
		// 創建一個新的 span 元素來顯示舊值，並添加 slide-out 動畫效果
    //const oldDiv = document.createElement('span');
    //oldDiv.textContent = oldValue;
    //oldDiv.style.setProperty('--animation-duration', duration + 's');
    //oldDiv.classList.add('slide-out');

    // 清空 div 的內容並插入新的 span 元素
    div.innerHTML = '';
    //div.appendChild(oldDiv);
    div.appendChild(newDiv);
		
		// 設置一個定時器來在動畫結束後移除舊值
    //setTimeout(() => {
    //	oldDiv.remove();
    //}, duration * 1000); // 這裡的 duration 應該與 CSS 動畫的持續時間一致
	}
	
	//尋找兩個值不同的部分
	function fun_findFirstDifferenceIndex(value1, value2) {
		let commonPrefixLength = 0;
		while (commonPrefixLength < value1.length && commonPrefixLength < value2.length && value1[commonPrefixLength] === value2[commonPrefixLength]) {
				commonPrefixLength++;
		}
		return commonPrefixLength;
		
		// 測試這個函數
		//let value1 = "1549815262";
		//let value2 = "1549813850";
		//let differenceIndex = fun_findFirstDifferenceIndex(value1, value2);
		//console.log("The first difference is at index:", differenceIndex);
	}


	$(document).ready(function() {
		<?php if($set_BGTransparent != "") : ?>
		$("body, div").addClass("css_transparent");
		<?php endif; ?>
		$(".sticky-footer").addClass("d-none");
		$("#btn_top").addClass("d-none");
		$(".navbar").addClass("d-none");
		$("#accordionSidebar").addClass("d-none");	//$("#content-wrapper").addClass("d-none");
		$("#div_main").css("min-height", "400px");
		
		fun_updateCounterValue();
		timerId = setInterval("fun_updateCounterValue();", set_intervalTime);
	});
	
	let ary_sample 	= new Array();
	ary_sample[0] 	= new Array();
	ary_sample[0]["full"] = <?=$set_GrabInfoMax; ?>;
	
	//更新計數器的資料/數值
	function fun_updateCounterValue() {
		//獲取陣列長度，並將 ajax取回的資料，放到陣列中
		let get_ajaxData = ajax_getCounterData();				//console.log("get_ajaxData ", get_ajaxData);
		//let this_setting = get_ajaxData["setting"];
		let get_x = Object.keys(ary_sample).length;			//擷取陣列長度 	//console.log("get_x: ", get_x);
		
		ary_sample[get_x] = new Array();
		ary_sample[get_x]["full"] = (get_ajaxData && get_ajaxData["values"] !== undefined && get_ajaxData["values"] !== null) ? (get_ajaxData["values"]) : (0);
		ary_sample[get_x]["indi"] = fun_sepratString(ary_sample[get_x]["full"].toLocaleString());			//console.log(ary_sample);
		console.log("x-1: ", ary_sample[get_x-1]["full"], "; x: ", ary_sample[get_x]["full"]);
		
		let startValue 			= ary_sample[get_x-1]["full"];
		let endValue 				= ary_sample[get_x]["full"];
		let totalDuration 	= <?=$set_Frequency["FreMsec"]; ?> * 1000; 		// 總時間 5 秒
		let updateInterval 	= <?=$set_Frequency["FreNsec"]; ?> * 1000; 		// 每次更新間隔 1 秒(這個固定感覺會比較安全)
		let increment 	= Math.ceil( (endValue - startValue) / (totalDuration / updateInterval)); 					// 設定增量 = ( (結束-起始) / ( 更新次數 = (總時間 / 更新間隔) ) )
		//console.log("totalDuration: ",totalDuration, "; updateInterval: ", updateInterval, "; increment:", increment);

		let currentValue = parseInt(startValue);																														// console.log("startValue: ",startValue, "; endValue: ",endValue, "currentValue: ",currentValue);
		//開始定時迴圈
		let interval = setInterval(() => {
			if (currentValue < endValue) {
				currentValue += increment;
				if (currentValue > endValue) {
					currentValue = endValue.toLocaleString(); // 確保不超過最終值
				}
				let formattedValue = parseInt(currentValue).toLocaleString();													//格式化字串	//
				let tmp_indi = fun_sepratString(formattedValue);
				let findDiffIndex = fun_findFirstDifferenceIndex(formattedValue.toString(), (currentValue - increment).toLocaleString().toString());
				let getLength = formattedValue.length;
				//console.log("typeof: ", typeof currentValue, "; currentValue: ", currentValue, "; formattedValue: ",formattedValue, "; tmp_indi: ", tmp_indi);
				
				fun_chkDivValues(getLength);		//檢查是否有需要新增 div
				for (let key in tmp_indi) {
					//console.log(key, ": ", tmp_indi[key]);
					if (key >= findDiffIndex) {
						let duration = <?=$set_Frequency["DurStart"]; ?> + ((getLength - key) * <?=$set_Frequency["DurPer"]; ?>);			//計算淡出的時間
						duration = (duration > <?=$set_Frequency["DurMax"]; ?>) ? <?=$set_Frequency["DurMax"]; ?> : duration;					//限制最大變化時間	//console.log("duration: ", duration);
						updateDivValue("numBox_" + key, tmp_indi[key], duration);
					}
				}
			}
			else if (currentValue > endValue) {
				currentValue += increment;
				if (currentValue < endValue) {
					currentValue = endValue.toLocaleString(); // 確保不超過最終值
				}
				let formattedValue = parseInt(currentValue).toLocaleString();													//格式化字串	//
				let tmp_indi = fun_sepratString(formattedValue);
				let findDiffIndex = fun_findFirstDifferenceIndex(formattedValue.toString(), (currentValue - increment).toLocaleString().toString());
				let getLength = formattedValue.length;
				//console.log("typeof: ", typeof currentValue, "; currentValue: ", currentValue, "; formattedValue: ",formattedValue, "; tmp_indi: ", tmp_indi);
				
				fun_chkDivValues(getLength);		//檢查是否有需要新增 div
				for (let key in tmp_indi) {
					//console.log(key, ": ", tmp_indi[key]);
					if (key >= findDiffIndex) {
						let duration = <?=$set_Frequency["DurStart"]; ?> + ((getLength - key) * <?=$set_Frequency["DurPer"]; ?>);			//計算淡出的時間
						duration = (duration > <?=$set_Frequency["DurMax"]; ?>) ? <?=$set_Frequency["DurMax"]; ?> : duration;					//限制最大變化時間	//console.log("duration: ", duration);
						updateDivValue("numBox_" + key, tmp_indi[key], duration);
					}
				}
			}
			else if(document.getElementById("div_numContainer").children.length == 0) {
				const cre_newDiv = document.createElement('div');
				cre_newDiv.id = "numBox_0"; // 確保 ID 正確
				cre_newDiv.classList.add('div_numBlock');
				document.getElementById("div_numContainer").appendChild(cre_newDiv);
				let duration = <?=$set_Frequency["DurStart"]; ?>;																																	//計算淡出的時間
				updateDivValue("numBox_0", 0, duration);
			}
			else {
				clearInterval(interval); 				// 當達到最終值時清除定時器
			}
		}, updateInterval); 								// 目前是每 1000 毫秒更新一次
	}

	// 檢查是否需要創建新的 div 元素
	function fun_chkDivValues(getLength = 0) {		
    const get_container = document.getElementById("div_numContainer");
		//console.log("get_container: ",get_container.children.length, "; getLength: ",getLength);
    
		// 創建新的 div 元素
		for (let i = get_container.children.length; i <= getLength; i++) {
			const cre_newDiv = document.createElement('div');
			cre_newDiv.id = "numBox_" + i; // 確保 ID 正確
			cre_newDiv.classList.add('div_numBlock');
			get_container.appendChild(cre_newDiv);
		}	

    // 移除多餘的 div 元素
    while (get_container.children.length > getLength) {
			get_container.removeChild(get_container.lastChild);
    }
		return true;
	}

	//利用 ajax抓取資料
	function ajax_getCounterData () {
		//console.log("ajax_getCounterData");
		let code 		= "<?=$counterCode;?>";
		let rspData = new Array();
		rspData = { "values": 0 }
		$.ajax({
			type: "POST",
			url: "./tools/ajax/ajax_getCounterData.php?code="+code,
			dataType: "JSON",
			async: false,
			success: function (response) {
				//console.log("success: ", typeof response, "; response:", response);
				rspData = response;
			},
			error: function (thrownError) {
				//console.log(thrownError);
			}
		});
		return rspData;
	}
</script>