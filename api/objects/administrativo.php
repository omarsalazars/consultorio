<?php

class Administrativo{

    private $conn;
    private $table_name = "administrativo";

    public $idAdministrativo;
    public $nombre;
    public $apellidos;
    public $fechaNacimiento;
    public $peso;
    public $telefono;
    public $email;
    public $password;


    function Administrativo($db){
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
        $query = "INSERT INTO ".$this->table_name." (nombre, apellidos, telefono, email, password) VALUES (:nombre, :apellidos, :telefono, :email, :password)";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        //bind values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        //execute query

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE idAdministrativo = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->idAdministrativo);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->idAdministrativo = $row['idAdministrativo'];
        $this->nombre = $row['nombre'];
        $this->apellidos = $row['apellidos'];
        $this->telefono = $row['telefono'];
        $this->email = $row['email'];
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
            $this->idAdministrativo = $row['idAdministrativo'];
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->telefono = $row['telefono'];
            $this->password = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }


    // update the product
    function update(){

        // update query
        $query = "UPDATE " . $this->table_name . "
            SET
                nombre = :nombre,
                apellidos = :apellidos,
                telefono = :telefono,
                email = :email
                {$password_set}
            WHERE idAdministrativo = :idAdministrativo";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email=htmlspecialchars(strip_tags($this->email));

        //bind values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the product
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idAdministrativo = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->idAdministrativo));

        // bind id of record to delete
        $stmt->bindParam(1, $this->idAdministrativo);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}