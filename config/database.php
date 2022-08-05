<?php
class Database{
private $hostname = "localhost";
private $database = "tienda_virtual";
private $username = "root";
private $password = "";
private $chartset = "utf8";

function connect(){
    try{
    $conexion = "mysql:host=" . $this->hostname . "; dbname=". $this->database . 
    "; chartset". $this->chartset;
    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO($conexion, $this->username, $this->password, $option);

    return $pdo;
    }catch(PDOException $e){
        echo "Error Con la Conexion a la Base de Datos: " . $e->getMessage();
        exit;
    }
}
}
?>