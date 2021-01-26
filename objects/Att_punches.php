<?php
class Att_punches{
 
    // database connection and table name
    private $conn;
    private $table_name = "att_punches";
 
    // object properties
    public $employee_id;
    public $punch_time;
    public $status;
    public $id;
    public $lastInsertId;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

     public function create()
    {
        $select = "SELECT employee_id FROM " . $this->table_name." WHERE punch_time = '$this->punch_time' AND status = '$this->status'";
            
        // prepare query statement
        $stmt = $this->conn->prepare($select);
     
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num==0)
        {
            $query = "INSERT INTO att_punches (employee_id,punch_time,status) VALUES ('$this->employee_id','$this->punch_time','$this->status')";
            // prepare query
            $stmt = $this->conn->prepare($query);
               
            if($stmt->execute())
            {
                $id = $this->conn->lastInsertId();
                $this->lastInsertId=$id;  
                return true;
            }
                return false;
        }
        else
        {
            return false;
        }
    }
};
