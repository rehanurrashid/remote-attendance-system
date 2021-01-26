<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/hr_employee.php';
 
// instantiate database and product object
$database = new database();
$db = $database->getConnection();
 
// initialize object
$hr_employee = new Hr_Employee($db);
// query products
$stmt = $hr_employee->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $employee_record=array();
    $employee_record["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 $date = explode(" ",$emp_hiredate);
        $emp_record=array(
            "id" => $emp_pin,
            "emp_firstname" => $emp_firstname,
            "emp_hiredate" => $date[0],
			"emp_pwd" => $emp_pwd
        );
 
        array_push($employee_record["records"], $emp_record);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($employee_record);
}

?>