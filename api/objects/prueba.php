<?php
include_once 'cita.php';
include_once '../config/connection.php';


$database = new Database();
$db = $database->getConnection();

// prepare product object
$cita = new Cita($db);

// set ID property of record to read
$cita->idPaciente=1;
$cita->idDoctor=1;
$cita->idAdministrativo=1;
$cita->fecha = new DateTime();
$cita->fecha = $cita->fecha->format('Y-m-d H:i:s');

// read the details of product to be edited
$cita->create();



?>