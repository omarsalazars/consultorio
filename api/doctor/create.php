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
include_once '../objects/doctor.php';

$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if( 
    !empty($data->nombre) &&
    !empty($data->apellidos) &&
    !empty($data->telefono) &&
    !empty($data->email) &&
    !empty($data->password)
){

    // set product property values
    $doctor->nombre = $data->nombre;
    $doctor->apellidos = $data->apellidos;
    $doctor->telefono = $data->telefono;
    $doctor->email = $data->email;
    $doctor->password = $data->password;
    //$cita->fecha = date('Y-m-d H:i:s');

    // create the product
    if($doctor->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Doctor was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create Doctor.", "data" => $data));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create Doctor. Data is incomplete.", "data" => $data));
}
?>