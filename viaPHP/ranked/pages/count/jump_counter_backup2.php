<?php
	$counterCode = (isset($_GET["code"])) ? ($_GET["code"]) : ("");
?>


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Counter</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Counter board</h6>
			</div>
			<div class="card-body">
				<div class="table-area">
					<div id="div_numContainer" class="form-row"></div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script>
	// 設定生成亂數的間隔時間（毫秒）
	const set_intervalTime = 3 * 1000; // 1000 毫秒 = 1 秒

	// 生成亂數的函式
	function fun_genRandomNumber() {
		const tmp_randomNumber = Math.random(); // 生成 0 到 1 之間的亂數			//console.log("Generated Random Number:", tmp_randomNumber);
		return tmp_randomNumber
	}
	
	// 分割字串的函式
	function fun_sepratString(ipt_text = "") {
		let tmp_str = ipt_text.toString();
		let rtn_result = new Array();
		for (let i = 0; i < tmp_str.length; i++) {
			rtn_result[i] = tmp_str[i];					// 將字符存儲到物件中，鍵為索引（從 1 開始），值為字符
		}
		return rtn_result;
	}
	
	//更新特定容器內的數值
	function fun_updateDivValue(set_whichDiv, set_newValue, set_duration) {
		const get_targetDiv = document.getElementById(set_whichDiv);
		const oldValue = get_targetDiv.textContent;
		//console.log("oldValue: ", oldValue.trim(), "; set_newValue", set_newValue.trim());
		
    // 創建一個新的 span 元素來顯示新值，並添加 slide-up 動畫效果
    const tmp_newDiv = document.createElement("div");
    tmp_newDiv.textContent = set_newValue;
    tmp_newDiv.style.setProperty("--animation-duration", set_duration + "s");
    tmp_newDiv.classList.add("anim_slideIn");
		
		// 創建一個新的 span 元素來顯示舊值，並添加 slide-out 動畫效果		//會卡住，先跳過
    //const tmp_oldDiv = document.createElement("div");
    //tmp_oldDiv.textContent = oldValue;
    //tmp_oldDiv.style.setProperty("--animation-duration", set_duration + "s");
    //tmp_oldDiv.classList.add("anim_slideOut");

    // 清空 div 的內容並插入新的 span 元素
    get_targetDiv.innerHTML = '';
    //get_targetDiv.appendChild(tmp_oldDiv);
    get_targetDiv.appendChild(tmp_newDiv);
		
		// 設置一個定時器來在動畫結束後移除舊值
    //setTimeout(() => {
    //	tmp_oldDiv.remove();
    //}, set_duration * 1000); // 這裡的 duration 應該與 CSS 動畫的持續時間一致
	}
	
	//用來找出兩個字串中，第一個被修改的部分
	function fun_findFirstDifferenceIndex(value1, value2) {
		let commonPrefixLength = 0;
		while (commonPrefixLength < value1.length && commonPrefixLength < value2.length && value1[commonPrefixLength] === value2[commonPrefixLength]) {
				commonPrefixLength++;
		}
		return commonPrefixLength;
		
		// 測試這個函數
		//let value1 = "1549815262";
		//let value2 = "15498138501";
		//let differenceIndex = fun_findFirstDifferenceIndex(value1, value2);
		//console.log("The first difference is at index:", differenceIndex);
	}
	
	$(document).ready(function() {
		//呼叫函式去抓相對的數值
		timerId = setInterval("fun_updateCounterValue();", set_intervalTime);
		
	});
	let ary_sample = {
		0: {
			"full": 0000000000, 
			"indi": {
				"0" : "0",
				"1" : "0",
				"2" : "0",
				"3" : "0",
				"4" : "0",
				"5" : "0",
				"6" : "0",
				"7" : "0",
				"8" : "0",
				"9" : "0",
			}
		}
	};
	function fun_updateCounterValue () {
		//console.log("fun_updateCounterValue");
		//獲取陣列長度，並將 ajax取回的資料，放到陣列中
		let get_ajaxData = ajax_getCounterData();			console.log("get_ajaxData ", get_ajaxData);
		let this_setting = get_ajaxData["setting"];
		let get_x = Object.keys(ary_sample).length;		//console.log("get_x: ", get_x);		
		ary_sample[get_x] = new Array();
		ary_sample[get_x]["full"] = get_ajaxData["values"];
		ary_sample[get_x]["indi"] = fun_sepratString(ary_sample[get_x]["full"]);			//console.log(ary_sample);		
		
		//比對新的數值跟舊有的數值，尋找需要更新的部分
		let findDiffIndex = (typeof ary_sample[get_x-1] !== 'undefined') ? fun_findFirstDifferenceIndex(parseInt(ary_sample[get_x]["full"]).toString(), parseInt(ary_sample[get_x-1]["full"]).toString()) : 0;
		let getLength = parseInt(ary_sample[get_x]["full"]).toString().length;		//console.log("findDiffIndex: ", findDiffIndex);
				
		// 檢查是否需要創建新的 div 元素
		const get_container = document.getElementById("div_numContainer");
		for (let i = get_container.children.length; i < getLength; i++) {
			const cre_newDiv = document.createElement('div');
			cre_newDiv.id = "numBox_" + i;
			cre_newDiv.classList.add('div_numBlock');
			get_container.appendChild(cre_newDiv);
		}
		
		// 移除多餘的 div 元素
		while (get_container.children.length > getLength) {
			get_container.removeChild(get_container.lastChild);
		}
		
		let max_duration 		= (typeof this_setting["set_maxDuration"] 	!== 'undefined') 	? (this_setting["set_maxDuration"]) 	: (1);
		let start_duration 	= (typeof this_setting["set_startDuration"] !== 'undefined') 	? (this_setting["set_startDuration"]) : (0.2);
		let per_Duration 		= (typeof this_setting["set_perDuration"] 	!== 'undefined') 	? (this_setting["set_perDuration"]) 	: (0.1);
		let tmp_indi = ary_sample[get_x]["indi"];
		for (let key in tmp_indi) {
			
			//console.log("getLength: ", getLength, "; key: ", key);
			if(key >= findDiffIndex) {
				let set_duration = start_duration + ( (getLength - key) * per_Duration); // 根據位置設置動畫持續時間
				set_duration = (set_duration >= max_duration) ? max_duration : set_duration;				
				fun_updateDivValue("numBox_" + key, tmp_indi[key], set_duration);
			}
		}
		
		//修改樣式配置
		let elements = document.querySelectorAll('.div_numBlock');
		elements.forEach(element => {
			element.style.backgroundColor = this_setting["background_color"]; // 修改背景顏色
			element.style.color = this_setting["font_color"]; 								// 修改文字顏色
			element.style.fontSize 	= this_setting["font_size"]; 							// 修改字體大小
			element.style.margin 		= this_setting["set_margin"];							// 修改邊距
			element.style.padding 	= this_setting["set_padding"]; 						// 修改內距
		});
	}
	function ajax_getCounterData () {
		//console.log("ajax_getCounterData");
		let rspData = [];
		//let code = "<?=$counterCode;?>";
		let code = "abcdef";
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
	//console.log("ajax_getCounterData ", ajax_getCounterData());
	//console.log("fun_updateCounterValue ", fun_updateCounterValue());
</script>

<style type="text/css">
	div.div_numBlock {
		background-color: black;
		color: white;
    font-size: xxx-large;
    width: auto;
    height: auto;
    padding: 5px 5px 5px 5px;
    margin: 0px 5px 0px 5px;
		overflow: hidden;
	}
	
	@keyframes slideIn-Up {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
	}
	
	@keyframes slideOut-Up {
		from {
			transform: translateY(0);
			opacity: 1;
		}
		to {
			transform: translateY(-100%);
			opacity: 0;
		}
	}

	.anim_slideIn {
			animation: slideIn-Up var(--animation-duration) ease-in-out;
	}
	
	.anim_slideOut {
		display: inline-block;
		animation: slideOut-Up var(--animation-duration) ease-in-out;
	}
</style>