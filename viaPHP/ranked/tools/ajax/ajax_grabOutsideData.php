<?php
	require_once("../../tools/php/tools_dbconnect.php");
	require_once("../../tools/php/tools_dbtools.php");
	//echo "ajax_updRankData"; print_r($_POST["input"]);
	
	$inputData = array();
	//整理送入的資料
	{
		$inputData["Count_ID"] 		= $_POST["input"]["ID"];
		$inputData["Count_No"] 		= $_POST["input"]["No"];
		$inputData["Target_API"] 	= $_POST["input"]["Target_API"];
		
		//擷取外部資料
		{
			// 擷取外部資料
			$ch = curl_init();

			// 設置 cURL 選項
			curl_setopt($ch, CURLOPT_URL, $inputData["Target_API"]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 忽略 SSL 憑證驗證
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 忽略 SSL 主機驗證

			// 執行 cURL 請求並獲取回應
			$response = curl_exec($ch);

			// 檢查是否有錯誤
			if ($response === false) {
					echo 'cURL Error: ' . curl_error($ch);
			} else {
					// 將回應轉換為 PHP 陣列
					$data = json_decode($response, true);

					// 顯示資料
					print_r($data);
			}

			// 關閉 cURL
			curl_close($ch);
		}
		
		//寫入到資料庫
		{
			
		}
		
		
		//print_r($inputData);
		//echo fun_updRankData($inputData);
	}
	
	
	//獲取活動資料
	function fun_updRankData( $data = array() ) {
		
		$Event_ID = $data["Event_ID"];
		$Event_No = $data["Event_No"];
		foreach($data["Player"] AS $Key => $Values) {
			$sql = "UPDATE tb_ranked
								 SET tb_ranked.Score='".json_encode($Values["forRank"])."'
							 WHERE Ranked_ID 	= '".$Values["Ranked_ID"]."' 
								 AND Event_ID 	= '".$Event_ID."' 
								 AND Player_ID 	= '".$Values["Player_ID"]."' ;";
			//echo $sql."</br>";
			$result = fun_updDBData($sql);
		}
		
		return true;
	}
	exit();
?>