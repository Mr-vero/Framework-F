<?php
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : framework/core/Fcontroller.php
*/
class Fcontroller{
    // Base Controller has a property called $loader, it is an instance of Loader class(introduced later)
    protected $push;
    protected $session;

    public function __construct(){
        $this->push = new FLoader();
        $this->session = new FLoader();
    }

    public function redirect($url,$message,$wait = 0){
        if ($wait == 0){
            header("Location:$url");
        } else {
            include CURR_VIEW_PATH . "message.html";
        }
        exit;
    }
}