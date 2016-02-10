<?php 

require_once __DIR__."/db_config.php";

class DbInstance extends MySQLi {
    private static $instance = null ;

    private function __construct($host, $user, $password, $database){ 
        parent::__construct($host, $user, $password, $database);
    }

    public static function getInstance() {
        if (self::$instance == null){
            self::$instance = new self(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        return self::$instance;
    }
}
?>
