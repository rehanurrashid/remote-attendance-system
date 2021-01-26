<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/attandance.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$attandance = new Attandance($db);
 
// set ID property of record to read
$attandance->emp_pin = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$stmt = $attandance->readOne();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $attandance_record=array();
    $attandance_record["records"]=array();
 
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $emp_record=array(
            "emp_pin" => $emp_pin,
            "punch_time" => $punch_time            
        );
 
        array_push($attandance_record["records"], $emp_record);
    }
    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($attandance_record);
}
?>