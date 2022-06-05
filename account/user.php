<?php
class Password {
    const SALT = 'EstoEsUnSalt';
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}


session_start();
error_reporting(0);

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
$apellido=(isset($_POST['apellido']))?$_POST['apellido']:"";


$pass=(isset($_POST['pass']))?$_POST['pass']:"";
$usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
$user_email=(isset($_POST['user_email']))?$_POST['user_email']:"";
$contrasenia1=(isset($_POST['contrasenia1']))?$_POST['contrasenia1']:"";
$contrasenia2=(isset($_POST['contrasenia2']))?$_POST['contrasenia2']:"";



$img_user=(isset($_FILES['img_portada']['name']))?$_FILES['img_portada']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../administrador/config/bd.php");

switch($accion){
    case "Registrar":
        if ($contrasenia1 == $contrasenia2){
            $hash = Password::hash($contrasenia1);
            $sentenciaSQL= $conexion->prepare("INSERT INTO `privatemembersdata` ( `Name`, `Surname`, `Picture`, `Password`, `Usuario`, `Emails`) VALUES (:nombre, :apellido, :imagen, :contrasenia, :usuario, :user_email);");
            $sentenciaSQL->bindParam(':nombre',$nombre);
            $sentenciaSQL->bindParam(':apellido',$apellido);
            $sentenciaSQL->bindParam(':usuario',$usuario);
            $sentenciaSQL->bindParam(':user_email',$user_email);
            $sentenciaSQL->bindParam(':contrasenia',$hash);

            $nombreArchivo = 'undraw_profile.svg';
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();
            header("Location:login.php");
        } else{
            $mensaje="Error: Las contraseñas no coinciden";
        }

        break;
    case "Cancelar":
        header("Location:contenido.php");
        break;    
    case "Login":
            if(isset($_POST['usuario'])){
                $sentenciaSQL= $conexion->prepare("SELECT * FROM privatemembersdata WHERE Usuario=:usuario");
                $sentenciaSQL->bindParam(':usuario',$usuario);
                $sentenciaSQL->execute();
                $contenido=$sentenciaSQL->fetch(PDO::FETCH_BOTH);
                $passok = $contenido["Password"];
                $id = $contenido["ID"];
                $hash = Password::hash($pass);
                if(($passok == $hash )){
                    $_SESSION['signed_in'] = true;
                    $_SESSION['Usuario'] =$usuario;
                    $_SESSION['user_id'] =$id;
                    header("Location:../administrador/index.php");

                } else {
                    $mensaje="Usuario o contraseña incorrecto";
                }
            }
        
        break; 
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM privatemembersdata");
$sentenciaSQL->execute();
$listauser=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

