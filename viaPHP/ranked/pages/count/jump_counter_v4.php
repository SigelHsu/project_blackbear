

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
				<h6 class="m-0 font-weight-bold text-primary">Jump Counter Board</h6>
			</div>
			<?php 
				$sample = array("full" => "1549813681", 
												"indi" => array(
													"0" 	=> "1",
													"1" 	=> ",",
													"2" 	=> "5",
													"3" 	=> "4",
													"4" 	=> "9",
													"5" 	=> ",",
													"6" 	=> "8",
													"7" 	=> "1",
													"8" 	=> "3",
													"9" 	=> ",",
													"10" 	=> "6",
													"11" 	=> "8",
													"12" 	=> "1",
												));
			?>
			<!-- Card Body -->
			<div class="card-body" style="background-image: url(./img/counter_background.jpg);
																		background-size: contain;
																		background-position: center;
																		background-repeat: no-repeat;
																		height: 1200px;">
				<div class="table-area">
					<div class="form-row" style="padding: 580px 0px 0px 500px">
						<?php foreach ($sample["indi"] AS $Key => $Value):	?>
							<div id="numBox_<?=$Key; ?>" class="div_numBlock">
								<span class="slide-up"><?php echo $Value; ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<style type="text/css">
	div.div_numBlock {
		/*background-color: white;*/
		color: white;
    font-size: 230px;
    width: auto;
    height: auto;
    padding: 0px 5px 0px 5px;
    margin: 5px 5px 5px 5px;
		overflow: hidden;
		font-family: 'DFLiSongTC-W5';
		text-shadow: 
				1px 1px 0 red, 
				-1px -1px 0 red, 
				1px -1px 0 red, 
				-1px 1px 0 red,
				2px 2px 0 yellow, 
				-2px -2px 0 yellow, 
				2px -2px 0 yellow, 
				-2px 2px 0 yellow;
	}
	
	.text-outline {
		color: white; /* 文字顏色 */
		text-shadow: 
				1px 1px 0 red, 
				-1px -1px 0 red, 
				1px -1px 0 red, 
				-1px 1px 0 red,
				2px 2px 0 yellow, 
				-2px -2px 0 yellow, 
				2px -2px 0 yellow, 
				-2px 2px 0 yellow;
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
		src: url('/fonts/DFLiSongTC-W5.otf') format('opentype');
	}
</style>
<script>
	// 設定生成亂數的間隔時間（毫秒）
	const set_intervalTime = 6 * 1000; // 1000 毫秒 = 1 秒

	// 定義生成亂數的函數
	function fun_genRandomNumber() {
			const randomNumber = Math.random(); // 生成 0 到 1 之間的亂數
			//console.log("Generated Random Number:", randomNumber);
			return randomNumber
	}
	
	function fun_sepratString(ipt_text = "") {
		let tmp_str = ipt_text.toString();
		let result = new Array();
		for (let i = 0; i < tmp_str.length; i++) {
			// 將字符存儲到物件中，鍵為索引（從 1 開始），值為字符
			result[i] = tmp_str[i];
		}
		return result;
	}
	function updateDivValue(whichDiv, newValue, duration) {
		const div = document.getElementById(whichDiv);
		const oldValue = div.textContent;
		//console.log("oldValue: ", oldValue.trim(), "; newValue", newValue.trim());
		
    // 創建一個新的 span 元素來顯示新值，並添加 slide-up 動畫效果
    const newSpan = document.createElement('div');
    newSpan.textContent = newValue;
    newSpan.style.setProperty('--animation-duration', duration + 's');
    newSpan.classList.add('slide-up');
		
		// 創建一個新的 span 元素來顯示舊值，並添加 slide-out 動畫效果
    //const oldSpan = document.createElement('span');
    //oldSpan.textContent = oldValue;
    //oldSpan.style.setProperty('--animation-duration', duration + 's');
    //oldSpan.classList.add('slide-out');

    // 清空 div 的內容並插入新的 span 元素
    div.innerHTML = '';
    //div.appendChild(oldSpan);
    div.appendChild(newSpan);
		
		// 設置一個定時器來在動畫結束後移除舊值
    //setTimeout(() => {
    //	oldDiv.remove();
    //}, duration * 1000); // 這裡的 duration 應該與 CSS 動畫的持續時間一致
	}
	
	function fun_findFirstDifferenceIndex(value1, value2) {
		let commonPrefixLength = 0;
		while (commonPrefixLength < value1.length && commonPrefixLength < value2.length && value1[commonPrefixLength] === value2[commonPrefixLength]) {
				commonPrefixLength++;
		}
		return commonPrefixLength;
	}

	// 測試這個函數
	//let value1 = "1549815262";
	//let value2 = "1549813850";
	//let differenceIndex = fun_findFirstDifferenceIndex(value1, value2);
	//console.log("The first difference is at index:", differenceIndex);

	
	$(document).ready(function() {
		
		let ary_sample = {
			0: {
				"full": 1549813681, 
				"indi": {
					"0" 	: "1",
					"1" 	: ",",
					"2" 	: "5",
					"3" 	: "4",
					"4" 	: "9",
					"5" 	: ",",
					"6" 	: "8",
					"7" 	: "1",
					"8" 	: "3",
					"9" 	: ",",
					"10" 	: "6",
					"11" 	: "8",
					"12" 	: "1",
				}
			}
		};
		
		let x = 1;
		setInterval(() => {
				let getRandomNum = Math.ceil((fun_genRandomNumber() * 100000));
				ary_sample[x] = new Array();
				ary_sample[x]["full"] = ary_sample[x-1]["full"] + getRandomNum;

				console.log("x-1: ", ary_sample[x-1]["full"], "; x: ", ary_sample[x]["full"]);
				
				let startValue = ary_sample[x-1]["full"];
				let endValue = ary_sample[x]["full"];
				let totalDuration = 5000; // 總時間 5 秒
				let updateInterval = 1000; // 每次更新間隔 1 秒
				let updateCount = totalDuration / updateInterval; // 更新次數
				let increment = Math.ceil((endValue - startValue) / updateCount); // 設定增量

				let currentValue = startValue;

				let interval = setInterval(() => {
						if (currentValue < endValue) {
								currentValue += increment;
								if (currentValue > endValue) {
										currentValue = endValue; // 確保不超過最終值
								}
								let formattedValue = currentValue.toLocaleString();
								let tmp_indi = fun_sepratString(formattedValue);
								let findDiffIndex = fun_findFirstDifferenceIndex(formattedValue.toString(), (currentValue - increment).toLocaleString().toString());
								let getLength = formattedValue.length;

								for (let key in tmp_indi) {
										if (key >= findDiffIndex) {
												let duration = 0.5 + ((getLength - key) * 0.1);
												duration = (duration > 1) ? 1 : duration;
												updateDivValue("numBox_" + key, tmp_indi[key], duration);
										}
								}
						} else {
								clearInterval(interval); // 當達到最終值時清除定時器
						}
				}, updateInterval); // 每 1000 毫秒更新一次

				x++;
		}, set_intervalTime);

	});

</script>