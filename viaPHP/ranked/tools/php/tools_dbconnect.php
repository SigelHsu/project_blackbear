<?php
	function fun_dbconnection() {
		$host 	= "localhost";
		$dbuser = "root";
		$dbpassword = "";
		$dbname = "db_ranking";
		$link = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
		if($link){
			mysqli_query($link, "SET NAMES uff8");
			return $link;
		}
		else {
			echo "不正確連接資料庫</br>" . mysqli_connect_error();
		}
	}
	
	function fun_getDBData($sql = "") {
		$link = fun_dbconnection();
		$datas = array();
		
		// 用mysqli_query方法執行(sql語法)將結果存在變數中
		$result = mysqli_query($link,$sql);
	
		if ($result) {
				// mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
				if (mysqli_num_rows($result)>0) {
						// 取得大於0代表有資料
						// while迴圈會根據資料數量，決定跑的次數
						// mysqli_fetch_assoc方法可取得一筆值
						while ($row = mysqli_fetch_assoc($result)) {
								// 每跑一次迴圈就抓一筆值，最後放進data陣列中
								$datas[] = $row;
						}
				}
				// 釋放資料庫查到的記憶體
				mysqli_free_result($result);
		}
		else {
				echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
		}
		// 處理完後印出資料
		if(!empty($result)){
				// 如果結果不為空，就利用print_r方法印出資料
				return $datas;
		}
		else {
				// 為空表示沒資料
				echo "查無資料";
		}
	}
	function fun_updDBData($sql = "") {
		$link = fun_dbconnection();
		
		
		// 用mysqli_query方法執行(sql語法)將結果存在變數中
		$result = mysqli_query($link,$sql);
		return true;
	}
	function fun_insDBData($sql = "") {
		$link = fun_dbconnection();
		
		
		// 用mysqli_query方法執行(sql語法)將結果存在變數中
		$result = mysqli_query($link,$sql);
		return mysqli_insert_id($link);
	}
?>