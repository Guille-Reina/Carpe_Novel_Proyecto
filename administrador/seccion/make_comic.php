<?php 
session_start();

$url="http://".$_SERVER['HTTP_HOST']."/sitioweb";

include ("../config/bd.php");

$txtid = $_GET['txtid'];

$sentenciaSQL= $conexion->prepare("SELECT * FROM chapter WHERE ID_Chapter=:id");
$sentenciaSQL->bindParam(':id',$txtid);
$sentenciaSQL->execute();


$txtTitle =(isset($_POST['txtTitle']))?$_POST['txtTitle']:"";
$text=(isset($_POST['text']))?$_POST['text']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


switch($accion){

    case "Crear":
        $posicion = (isset($_POST['posicion']))?$_POST['posicion']:"";
        $tipo="Comic";
        $sentenciaSQL= $conexion->prepare("INSERT INTO chapter (Title, ID_Content, Tipo, Contenido, Fecha, Orden) VALUES (:titulo, :id_Content, :tipo, :txt, NOW(), :orden);");
        $sentenciaSQL->bindParam(':id_Content',$txtid);
        $sentenciaSQL->bindParam(':titulo',$txtTitle);
        $sentenciaSQL->bindParam(':tipo',$tipo);
        $sentenciaSQL->bindParam(':orden',$posicion);
        $contenido="";
        if (isset($_FILES['imagen'])){
	
           echo $cantidad= count($_FILES["imagen"]["tmp_name"]);
            
            for ($i=0; $i<$cantidad; $i++){
                echo $i;
            
            if ($_FILES['imagen']['type'][$i]=='image/png' || $_FILES['imagen']['type'][$i]=='image/jpeg'){
            echo "aqui";
            $fecha= new Datetime();
            $nombreArchivo =($_FILES['imagen']!="")?$fecha->getTimestamp()."_".$_FILES["imagen"]["name"][$i]:"portada.png";
            
            $tmpImagen=$_FILES["imagen"]["tmp_name"][$i];
            
            if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"../../img/contenido/".$nombreArchivo);
            }
            
            }
           
            $contenido .= $nombreArchivo.",";

            }
            $sentenciaSQL->bindParam(':txt',$contenido);
            $sentenciaSQL->execute();
            
        
        }
        header("Location:information.php?txtid=$txtid");
        break;
}

?>

<?php



?>

<html lang="en">
<head>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>/img/favicon1.ico" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo $url;?>/administrador/css/sb-admin-2.min.css" rel="stylesheet">
    <title>CarpeNovel -- Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<form method="POST" enctype="multipart/form-data">

<nav class="navbar navbar-expand navbar-light bg-light shadow-sm">
    <div class="container px-5">
        <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/seccion/information.php?txtid=<?php echo $txtid ?>"> <i class="fas fa-chevron-left"></i> Atras</a>
        <div class="btn-group" role="group">
            <a><button type="submit" name= "accion" class="btn btn-info" value="Crear">Guardar</button></a>
        </div>
    </div>
</nav>

</br>
</br>
<div class="container">
    <div width="100%">
            <div class="form-group">
                <input type="text" required class="form-control"  name="txtTitle" id="txtTitle" placeholder="Título">
                <input type="text" required class="form-control" name="posicion" placeholder="Posicion del capítulo">

            </div>
            <div class="form-group">
                <input type="file" name="imagen[]" value="" multiple><br>
            </div>
    </div>
</div>

</form>

    <script src="<?php echo $url;?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo $url;?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $url;?>/js/sb-admin-2.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.3/glider.min.js"></script>
</body>
</html>
