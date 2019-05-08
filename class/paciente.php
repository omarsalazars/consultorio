<?php

class Paciente{
    var $nombre;
    var $apellido;
    var $email;
    var $telefono;
    var $nacimiento;
    
    function Paciente($nombre,$email,$telefono,$nacimiento){
       $this->nombre = $nombre;
        //$this->apellido = $apellido;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->nacimiento = $nacimiento;
    }
    
    function getNombre(){
        return $this->nombre;
    }
    
    function getApellido(){
        return $this->apellido;
    }
    
    function getEmail(){
        return $this->email;
    }
    
    function getTelefono(){
        return $this->telefono;
    }
    
    function getNacimiento(){
        return $this->nacimiento;
    }
}

?>