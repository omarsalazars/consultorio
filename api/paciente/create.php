<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/connection.php';

// instantiate product object
include_once '../objects/paciente.php';

$database = new Database();
$db = $database->getConnection();

$paciente = new Paciente($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));


// make sure data is not empty
if(
    !empty($data->nombre) &&
    !empty($data->apellidos) &&
    !empty($data->fechaNacimiento) &&
    !empty($data->peso) &&
    !empty($data->telefono) &&
    !empty($data->email) &&
    !empty($data->password)
){

    // set product property values
    $paciente->nombre = $data->nombre;
    $paciente->apellidos = $data->apellidos;
    $paciente->fechaNacimiento = $data->fechaNacimiento;
    $paciente->peso = $data->peso;
    $paciente->telefono = $data->telefono;
    $paciente->email = $data->email;
    $paciente->password = $data->password;

    // create the product
    if($paciente->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Paciente was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create paciente."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create Paciente. Data is incomplete."));
}

?>