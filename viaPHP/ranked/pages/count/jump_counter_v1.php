

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
													"1" 	=> "5",
													"2" 	=> "4",
													"3" 	=> "9",
													"4" 	=> "8",
													"5" 	=> "1",
													"6" 	=> "3",
													"7" 	=> "6",
													"8" 	=> "8",
													"9" 	=> "1",
												));
			?>
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<div class="form-row">
						<?php foreach ($sample["indi"] AS $Key => $Value):	?>
							<div id="numBox_<?=$Key; ?>" class="div_numBlock">
								<div class="slide-up"><?php echo $Value; ?></div>
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
		background-color: aqua;
    font-size: xxx-large;
    width: auto;
    height: auto;
    padding: 0px 5px 0px 5px;
    margin: 5px 5px 5px 5px;
		overflow: hidden;
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

	.slide-up {
			animation: slideUp 1.0s ease-in-out;
	}
</style>
<script>
	// 設定生成亂數的間隔時間（毫秒）
	const set_intervalTime = 3000; // 1000 毫秒 = 1 秒

	// 定義生成亂數的函數
	function fun_genRandomNumber() {
			const randomNumber = Math.random(); // 生成 0 到 1 之間的亂數
			console.log("Generated Random Number:", randomNumber);
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
	function updateDivValue(whichDiv, newValue) {
		const div = document.getElementById(whichDiv);
		const oldValue = div.textContent;
		console.log("oldValue: ", oldValue.trim(), "; newValue", newValue.trim());
		if(oldValue.trim() === newValue.trim()) {
			console.log("IT SAME");
			return 0
		}
		

		// 創建一個新的 div 元素來顯示新值
		const newDiv = document.createElement('div');
		newDiv.textContent = newValue;
		newDiv.classList.add('slide-up');

		// 將新元素插入到原來的 div 中
		div.innerHTML = '';
		div.appendChild(newDiv);
		
		// 設置一個定時器來在動畫結束後移除舊值
    //setTimeout(() => {
    //    div.textContent = newValue;
    //}, 500); // 這裡的 500 毫秒應該與 CSS 動畫的持續時間一致
	}
	
	$(document).ready(function() {
		
		let ary_sample = {
			0: {
				"full": 1549813681, 
				"indi": {
					"0" : "1",
					"1" : "5",
					"2" : "4",
					"3" : "9",
					"4" : "8",
					"5" : "1",
					"6" : "3",
					"7" : "6",
					"8" : "8",
					"9" : "1",
				}
			}
		};
		
		let x = 1;
		// 使用 setInterval 每隔 set_intervalTime 毫秒調用一次 generateRandomNumber 函數
		setInterval(() => {
			let getRandomNum = Math.ceil((fun_genRandomNumber() * 1000));
			
			ary_sample[x] = new Array();
			ary_sample[x]["full"] = ary_sample[x-1]["full"] + getRandomNum;
			ary_sample[x]["indi"] = fun_sepratString(ary_sample[x]["full"]);
			console.log("ary_sample["+x+"] => ", ary_sample[x]);
			
			let tmp_indi = ary_sample[x]["indi"]
			for (let key in tmp_indi) {
				console.log(key + ": " + tmp_indi[key]);
				updateDivValue("numBox_"+key, tmp_indi[key])
			}
			
			
			x++;
		}, set_intervalTime);
	});

</script>