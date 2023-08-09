<?php

class Db {
    private static $instance = null; // Instance
    
    private $host;
    private $user;
    private $pwd;
    private $db;
    private $dsn;
    private $dbh;

    private function __construct () {
        $this->host = "db.3wa.io";
        $this->user = "loicpremel";
        $this->pwd = "77d97ec93581d9deb494e7583df52b69";
        $this->db = "loicpremel_moto";
        $this->dsn = "mysql:dbname=".$this->db.";host=".$this->host;
        $this->dbh = new PDO($this->dsn, $this->user, $this->pwd);
    }

    private function __clone () {}

    public static function getDb() {
        if (is_null(Db::$instance)) {
            Db::$instance = new Db();
        }
        return Db::$instance;
    }
    
    public static function getDbh() {
        if (is_null(Db::$instance)) {
            Db::$instance = new Db();
        }
        return Db::$instance->dbh;
    }
}

