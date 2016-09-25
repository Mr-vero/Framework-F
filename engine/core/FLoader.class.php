<?php 
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Created on : September 17, 2016
*  Last Modified: September 25, 2016
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
    
     public function publicPush($folder=NULL,$sub=NULL){
        //Ceking the folder and subfolder
        $folder = NULL ? $folder = NULL : $folder = $folder;
        $folder = NULL ? $folder = NULL : $folder = $folder;
        if ($folder !== NULL && $sub == NULL) {
            $this->publicLoader($folder);
        }elseif ($folder !== NULL && $sub !== NULL){
            $this->publicLoader($folder,$sub);
        }
    }

    public function publicLoader($folder,$sub=NULL){
        //Grab all data from public direcrory and listing
        foreach(glob('public/'.$folder.'/'.$sub.'/*.*') as $filename){
            if ($folder == 'css') {
                echo '<link rel="stylesheet" href="'.BASE_URL.$filename.'">'.PHP_EOL;
            }elseif($folder == 'js'){
                echo '<script src="'.BASE_URL.$filename.'"></script>'.PHP_EOL;
            }
        }
    }
}
