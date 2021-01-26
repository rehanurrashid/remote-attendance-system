<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/hr_employee.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare employee object
$hr_employee = new Hr_Employee($db);
 
// set ID property of record to read
$hr_employee->emp_pin = isset($_GET['id']) ? $_GET['id'] : die();
 
// delete the employee
if($hr_employee->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Employee was deleted."));
}
 
// if unable to delete the employee
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete Employee."));
}
?>