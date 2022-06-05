<?php
$server = 'localhost';
$user   = 'root';
$password   = '';
$database   = 'proyecto';
 
try{
    $conexion= new PDO("mysql:host=$server;dbname=$database",$user,$password);
    if($conexion){
     }

} catch( Exception $ex){

    echo $ex->getMessage();
    
}
?>