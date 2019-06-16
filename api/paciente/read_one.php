<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/connection.php';
include_once '../objects/paciente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$paciente = new Paciente($db);

// set ID property of record to read
$paciente->idPaciente = isset($_GET['idPaciente']) ? $_GET['idPaciente'] : die();

// read the details of product to be edited
$paciente->readOne();

if($paciente->idPaciente!=null){
    // create array
    $paciente_arr = array(
        "idPaciente" =>  $paciente->idPaciente,
        "nombre" => $paciente->nombre,
        "apellidos" => $paciente->apellidos,
        "fechaNacimiento" => $paciente->fechaNacimiento,
        "peso" => $paciente->peso,
        "telefono" => $paciente->telefono,
        "email" => $paciente->email,
        "password" => $paciente->password
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($paciente_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Paciente does not exist."));
}
?>