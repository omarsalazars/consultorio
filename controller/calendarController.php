<?php

require '../vendor/autoload.php';
require '../class/paciente.php';
require '../class/cita.php';

$paciente = new Paciente(
    $_POST['nombre'],
    $_POST['email'],
    $_POST['telefono'],
    $_POST['nacimiento'],
);

//$enfermedad = $_POST['enfermedad'];
$enfermedad = '';
$fecha = $_POST['fecha'];
//echo 'FECHAAAA: '.$fecha;
$mensaje = $_POST['mensaje'];
$fecha = DateTime::createFromFormat('Y-m-d H:i', $fecha, new DateTimeZone('America/Mexico_City'));

echo 'FECHAAAA: '.$fecha->format(DateTime::RFC3339);

$cita = new Cita($paciente, $fecha, $enfermedad, $mensaje);
$cita->crearCita();

?>