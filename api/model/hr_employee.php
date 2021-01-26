<?php
class Hr_Employee{
 
    // database connection and table name
    private $conn;
    private $table_name = "hr_employee";
 
    // object properties
    public $id;
    public $emp_pin;
    public $emp_firstname;
    public $emp_lastname;
    public $emp_hiredate;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
		function read(){
 
    // select all query
    $query = " select emp_pin, emp_firstname, emp_hiredate, emp_pwd from " . $this->table_name ;
         
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
	
	function create(){
		 // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                emp_pin=:id, emp_firstname=:emp_firstname, emp_hiredate=:emp_hiredate, emp_pwd=:emp_pwd, emp_active = 1";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->emp_pin=htmlspecialchars(strip_tags($this->emp_pin));
    $this->emp_firstname=htmlspecialchars(strip_tags($this->emp_firstname));
    $this->emp_hiredate=htmlspecialchars(strip_tags($this->emp_hiredate));
    $this->emp_pwd=htmlspecialchars(strip_tags($this->emp_pwd));
 
    // bind values
    $stmt->bindParam(":id", $this->emp_pin);
    $stmt->bindParam(":emp_firstname", $this->emp_firstname);
    $stmt->bindParam(":emp_hiredate", $this->emp_hiredate);
    $stmt->bindParam(":emp_pwd", $this->emp_pwd);

 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	function readOne(){
 
    // query to read single record
    $query = "SELECT emp_pin, emp_firstname, emp_hiredate FROM " . $this->table_name . " WHERE emp_pin = ? LIMIT 0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of employee to be updated
    $stmt->bindParam(1, $this->emp_pin);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->emp_pin = $row['emp_pin'];
    $this->emp_firstname = $row['emp_firstname'];
    $this->emp_hiredate = $row['emp_hiredate'];
}
	// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                emp_firstname = :emp_firstname,
                emp_hiredate = :emp_hiredate,
				emp_pwd = :emp_pwd
            WHERE
                emp_pin = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->emp_pin=htmlspecialchars(strip_tags($this->emp_pin));
    $this->emp_firstname=htmlspecialchars(strip_tags($this->emp_firstname));
    $this->emp_hiredate=htmlspecialchars(strip_tags($this->emp_hiredate));
    $this->emp_pwd=htmlspecialchars(strip_tags($this->emp_pwd));
    // bind new values
    $stmt->bindParam(':id', $this->emp_pin);
    $stmt->bindParam(':emp_firstname', $this->emp_firstname);
    $stmt->bindParam(':emp_hiredate', $this->emp_hiredate);
    $stmt->bindParam(':emp_pwd', $this->emp_pwd);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
	function delete(){
		$query = " DELETE FROM " . $this->table_name . " WHERE emp_pin = ? ";
		
		$stmt = $this->conn->prepare($query);
		
		
		$stmt->bindParam(1, $this->emp_pin);
		
		if($stmt->execute()){
			return true;
		}
		
		return false;
	}
}