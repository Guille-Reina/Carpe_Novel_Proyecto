<?php
$server = 'db4free.net';
$user   = 'girga123';
$password   = '12345678';
$database   = 'carpenovel';
 
try{
    $conexion= new PDO("mysql:host=$server;dbname=$database",$user,$password);
    if($conexion){
     }

} catch( Exception $ex){

    echo $ex->getMessage();
    
}
?>