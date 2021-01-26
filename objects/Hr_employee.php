<?php
class Hr_employee{
 
    // database connection and table name
    private $conn;
    private $table_name = "hr_employee";
 
    // object properties
    public $emp_pin;
    public $emp_firstname;
    public $emp_lastname;
    public $emp_role;
    public $emp_pwd;
    public $emp_hiredate;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function create()
    {
       $select = "SELECT emp_pin FROM " . $this->table_name." WHERE emp_pin = '$this->emp_pin'";
            
        // prepare query statement
        $stmt = $this->conn->prepare($select);
     
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num==0)
        {
            $query = "INSERT INTO hr_employee (emp_pin,emp_role,emp_firstname,emp_pwd) VALUES ('$this->emp_pin','$this->emp_role','$this->emp_firstname','$this->emp_pwd')";
            // prepare query
            $stmt = $this->conn->prepare($query);

            if($stmt->execute())
            {
                $id = $this->conn->lastInsertId();
                $this->location_id=$id;
                
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
