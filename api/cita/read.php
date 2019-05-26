<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/connection.php';
include_once '../objects/cita.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$cita = new Cita($db);
 
// read products will be here
// query products
$stmt = $cita->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // citas array
    $citas_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        
        $cita_item=array(
            "idCita" => $idCita,
            "idPaciente" => $idPaciente,
            "idDoctor" => $idDoctor,
            "idAdministrativo" => $idAdministrativo,
            "fecha" => $fecha
        );
 
        array_push($citas_arr, $cita_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($citas_arr);
}
else{
    http_response_code(404);
    
    echo json_encode(
        array("message" => "No products found.")
    );
}
 
// no products found will be here