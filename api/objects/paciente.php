<?php

class Paciente{

    private $conn;
    private $table_name = "paciente";

    public $idPaciente;
    public $nombre;
    public $apellidos;
    public $fechaNacimiento;
    public $peso;
    public $telefono;
    public $email;
    public $password;


    function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * from ". $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function create(){

        //query to insert
        $query = "INSERT INTO ".$this->table_name." (nombre, apellidos, fechaNacimiento, peso, telefono, email, password) VALUES (:nombre, :apellidos, :fechaNacimiento, :peso, :telefono, :email, :password)";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->fechaNacimiento=htmlspecialchars(strip_tags($this->fechaNacimiento));
        $this->peso=htmlspecialchars(strip_tags($this->peso));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':fechaNacimiento', $this->fechaNacimiento);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password',$password_hash);

        //execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // check if given email exist in the database
    function emailExists(){

        // query to check if email exists
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->idPaciente = $row['idPaciente'];
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->fechaNacimiento = $row['fechaNacimiento'];
            $this->peso = $row['peso'];
            $this->telefono = $row['telefono'];
            $this->password = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    /*
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
    */

    // update the product
    // update a user record
    function update(){

        // if password needs to be updated
        $password_set=!empty($this->password) ? ", password = :password" : "";

        // if no posted password, do not update the password
        $query = "UPDATE " . $this->table_name . "
            SET
                nombre = :nombre,
                apellidos = :apellidos,
                fechaNacimiento = :fechaNacimiento,
                peso = :peso,
                telefono = :telefono,
                email = :email
                {$password_set}
            WHERE idPaciente = :idPaciente";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->fechaNacimiento=htmlspecialchars(strip_tags($this->fechaNacimiento));
        $this->peso=htmlspecialchars(strip_tags($this->peso));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind the values from the form
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':fechaNacimiento', $this->fechaNacimiento);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // unique ID of record to be edited
        $stmt->bindParam(':idPaciente', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    /*

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
    */
}