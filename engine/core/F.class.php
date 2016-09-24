<?php 
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : framework/core/F.class.php
*/
class F {

   public static function run() {
   	// echo "run()";
        self::init();
        self::autoload();
        self::dispatch();
   }

  // Initialization
    private static function init() {
        // Define path constants
        define("DS", DIRECTORY_SEPARATOR);
        define("ROOT", getcwd() . DS);
        define("APP_PATH", ROOT . 'application' . DS);
        define("FRAMEWORK_PATH", ROOT . "engine" . DS);
        define("PUBLIC_PATH", ROOT . "public" . DS);

        define("CONFIG_PATH", APP_PATH . "config" . DS);
        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
        define("MODEL_PATH", APP_PATH . "models" . DS);
        define("VIEW_PATH", APP_PATH . "views" . DS);

        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);
         
        // Define platform, controller, action, for example:
        // index.php?p=admin&c=Goods&a=add
        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'index');
        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');
        //define("DEFAULT_LANGUAGE", isset($_REQUEST['l']) ? $_REQUEST['l'] : 'english');

        //define Language
        define("LANGUAGE", APP_PATH . "languages" . DS);

        //define part path
        define("PART_PATH", VIEW_PATH . PLATFORM . DS . "part" . DS);
        define("HEAD_PATH", PART_PATH . "head". DS);
        define("CONTENT_PATH", PART_PATH . "content". DS);
        define("FOOTER_PATH", PART_PATH . "footer". DS);

        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS );

        // Load core classes
        require CORE_PATH . "FController.class.php";
        require CORE_PATH . "FLoader.class.php";
        require DB_PATH . "FMysql.class.php";
        require CORE_PATH . "FModel.class.php";
        require CORE_PATH . "FErrorHandler.class.php";


        // Load configuration file
        $GLOBALS['config'] = include CONFIG_PATH . "config.php";

        // Start session
        session_start();
    }


    // Autoloading

    private static function autoload(){

        spl_autoload_register(array(__CLASS__,'load'));

    }


    // Define a custom load method
    private static function load($classname){
        // Here simply autoload app&rsquo;s controller and model classes
        if (substr($classname, -10) == "Controller"){
            // Controller
            require_once CURR_CONTROLLER_PATH . "$classname.class.php";
        } elseif (substr($classname, -5) == "Model"){
            // Model
            require_once  MODEL_PATH . "$classname.class.php";
        }
    }


    // Routing and dispatching
    private static function dispatch(){
        // Instantiate the controller class and call its action method
        $controller_name = CONTROLLER . "Controller";
        $action_name = ACTION . "Action";
        $controller = new $controller_name;
        $controller->$action_name();
    }
}

