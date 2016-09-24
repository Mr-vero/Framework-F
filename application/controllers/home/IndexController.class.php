<?php
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : application/controllers/home/IndexController.class.php
*/ 
class IndexController extends FController{

    public function indexAction(){

        // Load View template
        $this->push->view('index');
        //include  CURR_VIEW_PATH . "index.php";
    }

}