<?php isset($_GET['lang'])? $lang =$_GET['lang'] : $lang ="english";
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : application/views/home/index.php
--------------------------------------------------------------*/
	include CONFIG_PATH . "default.php";
/*------------------------------------------------------------
|DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
|THIS IS DEFAULT STRUCTURE FOR THE VIEWS
|ONLY EDIT ON PART
|--------------------------------------------------------------
|This is the Index setup, you can add your custom part by putting the files 
|Inside /part folder then add it 
*/
	include HEAD_PATH. "head.php";
    include CONTENT_PATH. "content.php";
    include FOOTER_PATH. "footer.php";
?>