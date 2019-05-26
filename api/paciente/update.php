<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/connection.php';
include_once '../objects/cita.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$cita = new Cita($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$cita->idCita = $data->idCita;

// set product property values
$cita->idPaciente = $data->idPaciente;
$cita->idDoctor = $data->idDoctor;
$cita->idAdministrativo = $data->idAdministrativo;
$cita->fecha = $data->fecha;

// update the product
if($cita->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Cita was updated."));
}

// if unable to update the product, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update cita."));
}
?>