<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/connection.php';
include_once '../objects/paciente.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$paciente = new Paciente($db);
 
// read products will be here
// query products
$stmt = $paciente->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // citas array
    $pacientes_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        
        $paciente_item=array(
            "idPaciente" => $idPaciente,
            "nombre" => $nombre,
            "apellidos" => $apellidos,
            "fechaNacimiento" => $fechaNacimiento,
            "peso" => $peso,
            "telefono" => $telefono,
            "email" => $email
        );
 
        array_push($pacientes_arr, $paciente_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($pacientes_arr);
}
else{
    http_response_code(404);
    
    echo json_encode(
        array("message" => "No products found.")
    );
}
 
// no products found will be here