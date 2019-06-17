<?php

class Cita{

    private $conn;
    private $table_name = "cita";

    public $idCita;
    public $paciente;
    public $fecha;
    public $enfermedad;
    public $mensaje;


    function Cita($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT c.idCita, c.fecha, p.idPaciente as pId, p.nombre as pNombre, p.apellidos as pApellidos, d.idDoctor as dId, d.nombre as dNombre, d.apellidos as dApellidos, a.idAdministrativo as aId, a.nombre as aNombre, a.apellidos as aApellidos 
        FROM consultorio.cita as c, consultorio.paciente as p, consultorio.doctor as d, consultorio.administrativo as a 
        WHERE c.idPaciente = p.idPaciente AND c.idDoctor = d.idDoctor AND c.idAdministrativo = a.idAdministrativo";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function create(){

        //query to insert
        $query = "INSERT INTO ".$this->table_name." (idPaciente, idDoctor, idAdministrativo, fecha) VALUES (:idPaciente, :idDoctor, :idAdministrativo, :fecha)";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->idPaciente=htmlspecialchars(strip_tags($this->idPaciente));
        $this->idDoctor=htmlspecialchars(strip_tags($this->idDoctor));
        $this->idAdministrativo=htmlspecialchars(strip_tags($this->idAdministrativo));
        $this->fecha=htmlspecialchars(strip_tags($this->fecha));

        //bind values
        $stmt->bindParam(":idPaciente", $this->idPaciente);
        $stmt->bindParam(":idDoctor", $this->idDoctor);
        $stmt->bindParam(":idAdministrativo", $this->idAdministrativo);
        $stmt->bindParam(":fecha", $this->fecha);

        //execute query

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    function readByUserId($idPaciente){
        $query = "SELECT c.idCita, c.fecha, p.idPaciente as pId, p.nombre as pNombre, p.apellidos as pApellidos, d.idDoctor as dId, d.nombre as dNombre, d.apellidos as dApellidos, a.idAdministrativo as aId, a.nombre as aNombre, a.apellidos as aApellidos 
        FROM consultorio.cita as c, consultorio.paciente as p, consultorio.doctor as d, consultorio.administrativo as a 
        WHERE c.idPaciente = ? AND c.idPaciente = p.idPaciente AND c.idDoctor = d.idDoctor AND c.idAdministrativo = a.idAdministrativo";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $idPaciente);
        $stmt->execute();
        
        return $stmt;
        
    }
    
    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE idCita = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->idCita);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->idCita = $row['idCita'];
        $this->idPaciente = $row['idPaciente'];
        $this->idDoctor = $row['idDoctor'];
        $this->idAdministrativo = $row['idAdministrativo'];
        $this->fecha = $row['fecha'];
    }

    // update the product
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                idPaciente = :idPaciente,
                idDoctor = :idDoctor,
                idAdministrativo = :idAdministrativo,
                fecha = :fecha
            WHERE
                idCita = :idCita";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->idPaciente=htmlspecialchars(strip_tags($this->idPaciente));
        $this->idDoctor=htmlspecialchars(strip_tags($this->idDoctor));
        $this->idAdministrativo=htmlspecialchars(strip_tags($this->idAdministrativo));
        $this->fecha=htmlspecialchars(strip_tags($this->fecha));
        $this->idCita = htmlspecialchars(strip_tags($this->idCita));

        //bind values
        $stmt->bindParam(":idCita",$this->idCita);
        $stmt->bindParam(":idPaciente", $this->idPaciente);
        $stmt->bindParam(":idDoctor", $this->idDoctor);
        $stmt->bindParam(":idAdministrativo", $this->idAdministrativo);
        $stmt->bindParam(":fecha", $this->fecha);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the product
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idCita = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->idCita));

        // bind id of record to delete
        $stmt->bindParam(1, $this->idCita);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}