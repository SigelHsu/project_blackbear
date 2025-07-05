<?php
	$name_root 	= "ranked";
	//$html_root 	= ( isset($_SERVER["HTTP_ORIGIN"]) ) 		? ($_SERVER["HTTP_ORIGIN"]."/".$name_root) 		: ("");				//http://localhost
	$html_root 	= (!empty($_SERVER["HTTPS"]) ? "https" : "http")."://".$_SERVER["HTTP_HOST"]."/".$name_root;
	$dir_root 	= ( isset($_SERVER["DOCUMENT_ROOT"]) ) 	? ($_SERVER['DOCUMENT_ROOT']."/".$name_root) 	: ("");				//D:/xampp/htdocs
?>