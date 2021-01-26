<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/hr_employee.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$hr_employee = new Hr_Employee($db);
 
// set ID property of record to read
$hr_employee->emp_pin = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$hr_employee->readOne();
 
if($hr_employee->emp_firstname!=null){
	
	$date = explode(" ",$hr_employee->emp_hiredate);
    // create array
    $hr_employee = array(
        "id" => $hr_employee->emp_pin,
        "emp_firstname" => $hr_employee->emp_firstname,
        "emp_hiredate" => $date[0]
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($hr_employee);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Employee does not exist."));
}
?>