<?php
$conexion = new mysqli("localhost", "root", "", "tienda_virtual");

if($conexion->connect_error){
    die('Error de conexion'. $conexion->connect_error);
}