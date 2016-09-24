<?php 
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : framework/core/Floader.php
*/
class FLoader{

    // Load library classes
    public function library($lib){
        include LIB_PATH . "$lib.class.php";
    }

    // loader helper functions. Naming conversion is xxx_helper.php;
    public function helper($helper){
        include HELPER_PATH . "{$helper}_helper.php";
    }

    public function view($view,$data=NULL,$act=NULL){
    	$data = NULL ? $data = NULL : $data = $data;
    	$act = NULL ? $act = 'view' : $act = $act;
    	include CURR_VIEW_PATH . "{$view}.php";
    }

    public function set_message($title,$message){
        //Create session
        session_start();
        define($title,$message);
        $_SESSION[$title] = $message;       
    }

    public function show_message($title){
        if (isset($_SESSION[$title])) {
            return $_SESSION[$title];
        }else{
            return "No Session";
        }
    }
}
