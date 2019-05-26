<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/connection.php';
include_once '../objects/cita.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$cita = new Cita($db);

// set ID property of record to read
$cita->idCita = isset($_GET['idCita']) ? $_GET['idCita'] : die();

// read the details of product to be edited
$cita->readOne();

if($cita->idCita!=null){
    // create array
    $citas_arr = array(
        "idCita" =>  $cita->idCita,
        "idPaciente" => $cita->idPaciente,
        "idDoctor" => $cita->idDoctor,
        "idAdministrativo" => $cita->idAdministrativo,
        "fecha" => $cita->fecha
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($citas_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Cita does not exist."));
}
?>