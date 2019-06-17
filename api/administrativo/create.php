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
include_once '../objects/administrativo.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Administrativo($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->idAdministrativo) &&
    !empty($data->nombre) &&
    !empty($data->apellidos) &&
    !empty($data->telefono) &&
    !empty($data->email) &&
    !empty($data->password)
){

    // set product property values
    $admin->idAdministrativo = $data->idAdministrativo;
    $admin->nombre = $data->nombre;
    $admin->apellidos = $data->apellidos;
    $admin->email = $data->email;
    $admin->telefono = $data->telefono;
    $admin->password = $data->password;
    //$cita->fecha = date('Y-m-d H:i:s');

    // create the product
    if($admin->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Admin was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create admin."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create admin. Data is incomplete."));
}
?>