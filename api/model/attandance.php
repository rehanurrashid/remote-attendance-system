<?php 

class Attandance{
	private $conn;
	private $table_name ="att_punches";
	private $tab_name ="hr_employee";
 
    // object properties
    public $id;
	public $employee_id;
    public $emp_firstname;
    public $emp_lastname;
	public $punch_time;
	public $emp_pin;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	function create(){
		
		
	$que = " select id from " . $this->tab_name . " WHERE emp_pin = :emp_pin ";
    
    
	$st = $this->conn->prepare($que);
		
	$this->emp_pin=htmlspecialchars(strip_tags($this->emp_pin));
 
    // bind values
    $st->bindParam(":emp_pin", $this->emp_pin);
		
		 // execute query
	$st->execute();
  // get retrieved row
    $row = $st->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->employee_id = $row['id'];
 
// query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                employee_id = :employee_id, punch_time = :punch_time ";
		
		$stmt = $this->conn->prepare($query);
		
		// sanitize
    $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
    // $this->punch_time=htmlspecialchars(strip_tags($this->punch_time));
		
	// bind values
    $stmt->bindParam(":employee_id", $this->employee_id);
	$stmt->bindParam(":punch_time", $this->punch_time);
		
		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}
	// read employee
function read(){
 
    // select all query
    $query = " SELECT
    emp_pin,
    punch_time
FROM
    hr_employee
JOIN att_punches ON hr_employee.id = att_punches.employee_id ";
         
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
    
    return $stmt;
}
	
	// used when filling up the update employee form
function readOne(){
 
    // query to read single record
    $query = "SELECT
    emp_pin,
    punch_time
    FROM
    hr_employee
    JOIN att_punches ON hr_employee.id = att_punches.employee_id
    WHERE
        emp_pin = ".$this->emp_pin;
   
    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();
    
    return $stmt;

}
	
	function timeZone($start, $end, $userid){
		// query to read record according to time
		$query = " SELECT
    					emp.id,
    					emp.emp_firstname,
						pnc.punch_time
				    FROM
				    	hr_employee  emp
				    JOIN 
				    	att_punches pnc 
				    ON
				    	emp.id = pnc.employee_id
				    WHERE
    					DATE_FORMAT(pnc.punch_time,'2019-%m-%d') BETWEEN ? AND ? AND employee_id = ? " ;
		
		//prepare query record
		$stmt = $this->conn->prepare($query);
		
		
		//bind punch time of employee too be updated
		$stmt->bindParam(1, $start);
		$stmt->bindParam(2, $end);
		$stmt->bindParam(3, $userid);
		
		//execute query
		$stmt->execute();
		
		return($stmt);
}
	function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                punch_time = :punch_time,
            WHERE
                emp_pin = :emp_pin";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->emp_pin=htmlspecialchars(strip_tags($this->emp_pin));
    $this->emp_firstname=htmlspecialchars(strip_tags($this->emp_firstname));
    $this->punch_time=htmlspecialchars(strip_tags($this->punch_time));
 
    // bind new values
    $stmt->bindParam(':emp_pin', $this->emp_pin);
    $stmt->bindParam(':punch_time', $this->punch_time);
 
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
?>