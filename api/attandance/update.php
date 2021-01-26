<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/hr_employee.php';
 
// get database connection
$database = new database();
$db = $database->getConnection();
 
// prepare employee object
$hr_employee = new Hr_Employee($db);
 
// get emp_pin of employee to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set Emp_Pin property of employee to be edited
$hr_employee->emp_pin = $data->emp_pin;
 
// set Employee property values
$hr_employee->emp_firstname = $data->emp_firstname;
$hr_employee->punch_time = $data->punch_time;
 
// update the employee
if($hr_employee->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Employee was updated."));
}
 
// if unable to update the employee, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update Employee."));
}
?>