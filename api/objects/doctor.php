<?php

class Doctor{

    private $conn;
    private $table_name = "doctor";

    public $idDoctor;
    public $nombre;
    public $apellidos;
    public $email;
    public $telefono;


    function Doctor($db){
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
        $query = "INSERT INTO ".$this->table_name." (idDoctor, nombre, apellidos, telefono, email, password) VALUES (:idDoctor, :nombre, :apellidos, :telefono, :email, :password)";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->idDoctor=htmlspecialchars(strip_tags($this->idDoctor));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        //bind values
        $stmt->bindParam(":idDoctor", $this->idDoctor);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        

        //execute query

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE idDoctor = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->idDoctor);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->idDoctor = $row['idDoctor'];
        $this->nombre = $row['nombre'];
        $this->apellidos = $row['apellidos'];
        $this->telefono = $row['telefono'];
        $this->email = $row['email'];
    }

    // update the product
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                idDoctor = :idDoctor,
                nombre = :nombre,
                apellidos = :apellidos,
                telefono = :telefono,
                email = :email,
            WHERE
                idDoctor = :idDoctor";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->idDoctor=htmlspecialchars(strip_tags($this->idDoctor));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellidos=htmlspecialchars(strip_tags($this->apellidos));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        //bind values
        $stmt->bindParam(":idDoctor",$this->idDocotr);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the product
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idDoctor = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->idDoctor));

        // bind id of record to delete
        $stmt->bindParam(1, $this->idDoctor);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}