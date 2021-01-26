<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate Employee object
include_once '../model/hr_employee.php';
 
$database = new Database();
$db = $database->getConnection();
 
$hr_employee = new Hr_Employee($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->emp_firstname) &&
    !empty($data->emp_hiredate) &&
	!empty($data->emp_pwd) 
){
 

    // set employee property values
    $hr_employee->emp_pin = $data->id;
    $hr_employee->emp_firstname = $data->emp_firstname;
    $hr_employee->emp_hiredate = $data->emp_hiredate;
	$hr_employee->emp_pwd = $data->emp_pwd;
// 
//    // create the Employee
    if($hr_employee->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Employee was created."));
    }
// 
//    // if unable to create the employee, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Emplyee."));
    }
}
// 
//tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Employee. Data is incomplete."));
}
?>