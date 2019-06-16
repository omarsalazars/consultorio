<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/consultorio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
include_once '../config/connection.php';
include_once '../objects/paciente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$paciente = new Paciente($db);

// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$paciente->email = $data->email;
$email_exists = $paciente->emailExists();

// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// generate jwt will be here
// check if email exists and if password is correct
if($email_exists && password_verify($data->password, $paciente->password)){

    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "idPaciente" => $paciente->idPaciente,
            "nombre" => $paciente->nombre,
            "apellidos" => $paciente->apellidos,
            "fechaNacimiento" => $paciente->fechaNacimiento,
            "peso" => $paciente->peso,
            "telefono" => $paciente->telefono,
            "email" => $paciente->email
        )
    );

    // set response code
    http_response_code(200);

    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "idPaciente" => $paciente->idPaciente,
            "nombre" => $paciente->nombre,
            "apellidos" => $paciente->apellidos,
            "fechaNacimiento" => $paciente->fechaNacimiento,
            "peso" => $paciente->peso,
            "telefono" => $paciente->telefono,
            "email" => $paciente->email,
            "jwt" => $jwt
        )
    );

}
else{// login failed

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>