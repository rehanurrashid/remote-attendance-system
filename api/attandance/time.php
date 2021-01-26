<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/attandance.php';
 
// instantiate database and 
employee object
$database = new database();
$db = $database->getConnection();

// initialize object
$attandance = new Attandance($db);

//getting value from url
$start = isset($_GET['start']) ? $_GET['start'] : die();
$end = isset($_GET['end']) ? $_GET['end'] : die();
$userid = isset($_GET['userid']) ? $_GET['userid'] : die();

// query 
employees
$stmt = $attandance->timeZone($start, $end, $userid);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
	
	
    // 
employees array
    $attandance_record=array();
    $attandance_record["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name']
        // just $name only
        extract($row);
		
        $emp_record=array(
            "employee_id" => $id,
            "emp_firstname" => $emp_firstname,
            "punch_time" => $punch_time
        );
 
        array_push($attandance_record["records"], $emp_record);
	}
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show 
employees data in json format
    echo json_encode($attandance_record);
}
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no 
employees found
    echo json_encode(
        array("message" => "No Employee found.")
    );
}

?>
