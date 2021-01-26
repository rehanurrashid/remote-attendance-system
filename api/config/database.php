<?php 

class database{
	 // specify your own database credentials
    private $host = "localhost";
    private $db_name = "techmelo_attandance";
    private $username = "techmelo_weba";
    private $password = "Techmelo`123";
    
	public $conn;
 
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