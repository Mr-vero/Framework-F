<?php 
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : config/default.php
--------------------------------------------------------------*/
	$url = "http://localhost/framework-f/"; //Change this link
	//$lang = "english"; //Default Language (static);
	$lang = $lang ? $lang = $lang : $lang = "english"; //Dynamic Language; 
/*-------------------------------------------------------------
|PLEASE DO NOT CHANGE THIS PART
|THIS IS THE DEFAULT CONFIGURATION
---------------------------------------------------------------------
---------------------------------------------------------------------*/
	define("BASE_URL", $url); 
	isset($lang) ? $GLOBALS['lang'] =  include LANGUAGE . $lang . ".php" : $GLOBALS['lang'] = include LANGUAGE . "english.php"; 
/*--------------------------------------------------------------------*/
 ?>
