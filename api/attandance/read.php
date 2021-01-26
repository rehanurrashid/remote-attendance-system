<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/attandance.php';
 
// instantiate database and product object
$database = new database();
$db = $database->getConnection();
 
// initialize object
$attandance = new Attandance($db);
// query products
$stmt = $attandance->read();
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