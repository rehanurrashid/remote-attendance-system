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
include_once '../model/attandance.php';
 
$database = new Database();
$db = $database->getConnection();
 
$att_punches = new Attandance($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));


// make sure data is not empty
if(!empty($data->emp_pin) && !empty($data->punch_time)){
	
    // set employee property values
    $att_punches->emp_pin = $data->emp_pin;
    $att_punches->punch_time = $data->punch_time;
 
    // create the Employee
    if($att_punches->create()){
 
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