<?php

header("Content-Type: text/html;charset=UTF-8");

class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "zktimenet.db";
    private $username = "root";
    private $password = "root786";
    public $conn="";
 
    // get the database connection
    public function getConnection(){
 

        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>