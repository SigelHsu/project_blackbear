<?php
	//建立特定長度的隨機字串
	function fun_randtext($length) {
		$password_len = $length;    //字串長度
		$password = "";
		//設置亂數內容
		$word  = "";   
		$word .= "abcdefghijklmnopqrstuvwxyz";   
		$word .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";   
		$word .= "0123456789";   
		$len = strlen($word);
		for ($i = 0; $i < $password_len; $i++) {
				$password .= $word[rand() % $len];
		}
		return $password;
	}	
	//建立特定長度的隨機"數字"字串
	function fun_randnumber($length) {
		$password_len = $length;    //字串長度
		$password = "";
		//設置亂數內容
		$word  = "";     
		$word .= "0123456789";   
		$len = strlen($word);
		for ($i = 0; $i < $password_len; $i++) {
				$password .= $word[rand() % $len];
		}
		return $password;
	}
?>