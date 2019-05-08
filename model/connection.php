<?php
try {
    $conn = new PDO('mysql:host=localhost:3308;dbname=consultorio','root','root');
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo 'Animo';
} 
catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>